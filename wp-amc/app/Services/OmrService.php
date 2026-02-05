<?php

namespace WpAmc\Services;

class OmrService
{
    private $image;
    private $width;
    private $height;
    private $threshold = 128;

    public function load($filepath)
    {
        $info = getimagesize($filepath);
        if (!$info) {
            throw new \Exception("Invalid image file.");
        }

        $type = $info[2];
        switch ($type) {
            case IMAGETYPE_JPEG:
                $this->image = imagecreatefromjpeg($filepath);
                break;
            case IMAGETYPE_PNG:
                $this->image = imagecreatefrompng($filepath);
                break;
            default:
                throw new \Exception("Unsupported image type.");
        }

        if (!$this->image) {
            throw new \Exception("Failed to load image.");
        }

        $this->width = imagesx($this->image);
        $this->height = imagesy($this->image);
    }

    public function detectCorners()
    {
        // For performance, we work on a resized version
        $targetW = 800;
        $ratio = $this->width / $targetW;
        $targetH = (int)($this->height / $ratio);

        $small = imagecreatetruecolor($targetW, $targetH);
        imagecopyresampled($small, $this->image, 0, 0, 0, 0, $targetW, $targetH, $this->width, $this->height);

        // Convert to grayscale
        imagefilter($small, IMG_FILTER_GRAYSCALE);

        // Define search regions (ROI) - restricted to 20% of width/height from corners
        // to avoid picking up content boxes.
        $roiW = (int)($targetW * 0.20);
        $roiH = (int)($targetH * 0.20);

        $quadrants = [
            'TL' => [0, 0, $roiW, $roiH],
            'TR' => [$targetW - $roiW, 0, $roiW, $roiH],
            'BR' => [$targetW - $roiW, $targetH - $roiH, $roiW, $roiH],
            'BL' => [0, $targetH - $roiH, $roiW, $roiH],
        ];

        $corners = [];

        foreach ($quadrants as $key => $q) {
            $blob = $this->findLargestBlackBlob($small, $q[0], $q[1], $q[2], $q[3]);
            if ($blob) {
                // Scale back coordinates
                $corners[$key] = [
                    'x' => $blob['x'] * $ratio,
                    'y' => $blob['y'] * $ratio
                ];
            } else {
                // Fallback: use center of ROI
                $corners[$key] = [
                    'x' => ($q[0] + $q[2]/2) * $ratio,
                    'y' => ($q[1] + $q[3]/2) * $ratio
                ];
            }
        }

        imagedestroy($small);

        return [
            $corners['TL'],
            $corners['TR'],
            $corners['BR'],
            $corners['BL']
        ];
    }

    private function findLargestBlackBlob($img, $x, $y, $w, $h)
    {
        $sumX = 0;
        $sumY = 0;
        $count = 0;

        // Sampling step
        $step = 1; // Increase precision

        for ($i = $x; $i < $x + $w; $i += $step) {
            for ($j = $y; $j < $y + $h; $j += $step) {
                // Boundary check
                if ($i >= imagesx($img) || $j >= imagesy($img)) continue;

                $rgb = imagecolorat($img, (int)$i, (int)$j);
                $r = ($rgb >> 16) & 0xFF;
                $g = ($rgb >> 8) & 0xFF;
                $b = $rgb & 0xFF;

                if (($r + $g + $b) / 3 < $this->threshold) {
                    $sumX += $i;
                    $sumY += $j;
                    $count++;
                }
            }
        }

        if ($count == 0) return null;

        return [
            'x' => $sumX / $count,
            'y' => $sumY / $count
        ];
    }

    public function computeHomography($src, $dst)
    {
        // System of equations for H
        $A = [];
        $B = [];

        for ($i = 0; $i < 4; $i++) {
            $u = $dst[$i]['x'];
            $v = $dst[$i]['y'];
            $x = $src[$i]['x'];
            $y = $src[$i]['y'];

            $A[] = [$u, $v, 1, 0, 0, 0, -$u*$x, -$v*$x];
            $B[] = $x;

            $A[] = [0, 0, 0, $u, $v, 1, -$u*$y, -$v*$y];
            $B[] = $y;
        }

        $h = $this->solveGaussian($A, $B);
        $h[] = 1.0;

        return $h;
    }

    private function solveGaussian($A, $B)
    {
        $n = count($A);
        for ($i = 0; $i < $n; $i++) {
            $maxEl = abs($A[$i][$i]);
            $maxRow = $i;
            for ($k = $i + 1; $k < $n; $k++) {
                if (abs($A[$k][$i]) > $maxEl) {
                    $maxEl = abs($A[$k][$i]);
                    $maxRow = $k;
                }
            }

            $tmp = $A[$maxRow];
            $A[$maxRow] = $A[$i];
            $A[$i] = $tmp;
            $tmp = $B[$maxRow];
            $B[$maxRow] = $B[$i];
            $B[$i] = $tmp;

            if (abs($A[$i][$i]) < 1e-9) continue; // Singular

            for ($k = $i + 1; $k < $n; $k++) {
                $c = -$A[$k][$i] / $A[$i][$i];
                for ($j = $i; $j < $n; $j++) {
                    if ($i == $j) {
                        $A[$k][$j] = 0;
                    } else {
                        $A[$k][$j] += $c * $A[$i][$j];
                    }
                }
                $B[$k] += $c * $B[$i];
            }
        }

        $x = array_fill(0, $n, 0);
        for ($i = $n - 1; $i >= 0; $i--) {
            if (abs($A[$i][$i]) < 1e-9) {
                $x[$i] = 0;
            } else {
                $sum = 0;
                for ($j = $i + 1; $j < $n; $j++) {
                    $sum += $A[$i][$j] * $x[$j];
                }
                $x[$i] = ($B[$i] - $sum) / $A[$i][$i];
            }
        }

        return $x;
    }

    public function transformPoint($h, $u, $v)
    {
        $d = $h[6] * $u + $h[7] * $v + 1;
        if ($d == 0) $d = 0.0001;

        $x = ($h[0] * $u + $h[1] * $v + $h[2]) / $d;
        $y = ($h[3] * $u + $h[4] * $v + $h[5]) / $d;

        return ['x' => $x, 'y' => $y];
    }

    public function measureBoxes($matrix, $boxes)
    {
        $results = [];

        foreach ($boxes as $box) {
            $cx = $box['x'] + $box['w'] / 2;
            $cy = $box['y'] + $box['h'] / 2;

            $p = $this->transformPoint($matrix, $cx, $cy);

            // Calculate approximate radius in pixel space based on box width
            // This assumes uniform scaling roughly.
            // Map (cx + w/2) to find radius.
            $p_edge = $this->transformPoint($matrix, $cx + $box['w']/2, $cy);
            $rad = sqrt(pow($p_edge['x'] - $p['x'], 2) + pow($p_edge['y'] - $p['y'], 2));

            // Safety margin: measure inner 60% of the box
            $rad = $rad * 0.6;
            if ($rad < 1) $rad = 1;

            $blackPixels = 0;
            $totalPixels = 0;

            $startX = max(0, (int)($p['x'] - $rad));
            $endX = min($this->width, (int)($p['x'] + $rad));
            $startY = max(0, (int)($p['y'] - $rad));
            $endY = min($this->height, (int)($p['y'] + $rad));

            for ($y = $startY; $y < $endY; $y++) {
                for ($x = $startX; $x < $endX; $x++) {
                    $rgb = imagecolorat($this->image, $x, $y);
                    $r = ($rgb >> 16) & 0xFF;
                    $g = ($rgb >> 8) & 0xFF;
                    $b = $rgb & 0xFF;

                    if (($r + $g + $b) / 3 < $this->threshold) {
                        $blackPixels++;
                    }
                    $totalPixels++;
                }
            }

            $ratio = $totalPixels > 0 ? $blackPixels / $totalPixels : 0;

            $results[$box['id']] = [
                'ratio' => $ratio,
                'checked' => $ratio > 0.5
            ];
        }

        return $results;
    }

    public function __destruct() {
        if ($this->image && $this->image instanceof \GdImage) {
            imagedestroy($this->image);
        } elseif ($this->image && is_resource($this->image)) {
            imagedestroy($this->image);
        }
    }
}
