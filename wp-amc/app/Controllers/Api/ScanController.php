<?php

namespace WpAmc\Controllers\Api;

use WP_REST_Request;
use WP_REST_Response;
use WpAmc\Services\OmrService;

class ScanController
{
    public function process(WP_REST_Request $request)
    {
        // 1. Validation
        $files = $request->get_file_params();
        $params = $request->get_params();

        if (empty($files['image'])) {
            return new WP_REST_Response(['error' => 'No image uploaded'], 400);
        }

        if (empty($params['layout'])) {
            return new WP_REST_Response(['error' => 'No layout data provided'], 400);
        }

        $layout = json_decode($params['layout'], true);
        if (!$layout || !isset($layout['corners']) || !isset($layout['boxes'])) {
            return new WP_REST_Response(['error' => 'Invalid layout data'], 400);
        }

        // 2. Handle File
        $file = $files['image'];
        $tmpPath = $file['tmp_name'];

        // 3. Process
        try {
            $service = new OmrService();
            $service->load($tmpPath);

            // A. Detect actual corners
            $detectedCorners = $service->detectCorners();

            // B. Compute Homography (Actual -> Ideal mapping logic needed?)
            // Layout 'corners' are usually the ideal coordinates (e.g. 0,0 for TL)
            // Or the user provides the theoretical corner positions on the page.

            // Layout structure expectation:
            // layout['corners'] = [['x'=>0,'y'=>0], ['x'=>210,'y'=>0], ...] (mm or pixels)
            // layout['boxes'] = [['id'=>'1', 'x'=>10, 'y'=>20, 'w'=>5, 'h'=>5], ...]

            // Ideally, we match detectedCorners (pixel space) to layout['corners'] (logical space)
            // But we need to ensure the order matches. detectCorners returns TL, TR, BR, BL.
            // We assume layout['corners'] is also TL, TR, BR, BL.

            $homography = $service->computeHomography($detectedCorners, $layout['corners']);

            // C. Measure Boxes
            $results = $service->measureBoxes($homography, $layout['boxes']);

            return new WP_REST_Response([
                'success' => true,
                'detected_corners' => $detectedCorners,
                'results' => $results
            ], 200);

        } catch (\Exception $e) {
            return new WP_REST_Response(['error' => $e->getMessage()], 500);
        }
    }
}
