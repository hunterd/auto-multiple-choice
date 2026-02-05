<?php
namespace WpAmc\Models;

class GradeModel
{
    const OPTION_KEY = 'wpamc_grade';

    public static function save(array $data): void
    {
        $values = [
            'grade_file' => sanitize_text_field($data['grade_file'] ?? ''),
        ];
        update_option(self::OPTION_KEY, $values);
    }

    public static function get(): array
    {
        return get_option(self::OPTION_KEY, []);
    }
}
