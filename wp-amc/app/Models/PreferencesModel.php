<?php
namespace WpAmc\Models;

class PreferencesModel
{
    const OPTION_KEY = 'wpamc_preferences';

    public static function save(array $data): void
    {
        $values = [
            'setting' => sanitize_text_field($data['setting'] ?? ''),
        ];
        update_option(self::OPTION_KEY, $values);
    }

    public static function get(): array
    {
        return get_option(self::OPTION_KEY, []);
    }
}
