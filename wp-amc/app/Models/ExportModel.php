<?php
namespace WpAmc\Models;

class ExportModel
{
    const OPTION_KEY = 'wpamc_export';

    public static function save(array $data): void
    {
        $values = [
            'output_csv' => sanitize_text_field($data['output_csv'] ?? ''),
        ];
        update_option(self::OPTION_KEY, $values);
    }

    public static function get(): array
    {
        return get_option(self::OPTION_KEY, []);
    }
}
