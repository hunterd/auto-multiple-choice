<?php
namespace WpAmc\Models;

class ScanModel
{
    const OPTION_KEY = 'wpamc_scan';

    public static function save(array $data): void
    {
        $values = [
            'scans_dir' => sanitize_text_field($data['scans_dir'] ?? ''),
        ];
        update_option(self::OPTION_KEY, $values);
    }

    public static function get(): array
    {
        return get_option(self::OPTION_KEY, []);
    }
}
