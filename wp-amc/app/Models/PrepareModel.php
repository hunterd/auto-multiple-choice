<?php
namespace WpAmc\Models;

class PrepareModel
{
    const OPTION_KEY = 'wpamc_prepare';

    public static function save(array $data): void
    {
        $values = [
            'project_dir' => sanitize_text_field($data['project_dir'] ?? ''),
        ];
        update_option(self::OPTION_KEY, $values);
    }

    public static function get(): array
    {
        return get_option(self::OPTION_KEY, []);
    }
}
