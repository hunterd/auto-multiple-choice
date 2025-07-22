<?php
namespace WpAmc\Controllers\Admin;

class MenuController
{
    public static function register()
    {
        add_menu_page(
            __('Auto Multiple Choice', 'wp-amc'),
            __('Auto Multiple Choice', 'wp-amc'),
            'manage_options',
            'wp-amc',
            [self::class, 'prepare_exam'],
            'dashicons-feedback',
            6
        );

        add_submenu_page('wp-amc', __('Prepare Exam', 'wp-amc'), __('Prepare Exam', 'wp-amc'), 'manage_options', 'wp-amc', [self::class, 'prepare_exam']);
        add_submenu_page('wp-amc', __('Scan Sheets', 'wp-amc'), __('Scan Sheets', 'wp-amc'), 'manage_options', 'wp-amc-scan', [self::class, 'scan_sheets']);
        add_submenu_page('wp-amc', __('Manual Grading', 'wp-amc'), __('Manual Grading', 'wp-amc'), 'manage_options', 'wp-amc-grade', [self::class, 'manual_grading']);
        add_submenu_page('wp-amc', __('Export Results', 'wp-amc'), __('Export Results', 'wp-amc'), 'manage_options', 'wp-amc-export', [self::class, 'export_results']);
        add_submenu_page('wp-amc', __('Preferences', 'wp-amc'), __('Preferences', 'wp-amc'), 'manage_options', 'wp-amc-preferences', [self::class, 'preferences']);
    }

    public static function prepare_exam()
    {
        self::render('prepare');
    }

    public static function scan_sheets()
    {
        self::render('scan');
    }

    public static function manual_grading()
    {
        self::render('grade');
    }

    public static function export_results()
    {
        self::render('export');
    }

    public static function preferences()
    {
        self::render('preferences');
    }

    protected static function render($view)
    {
        $view_file = __DIR__ . '/../../Views/admin/' . $view . '.php';
        if (file_exists($view_file)) {
            include $view_file;
        } else {
            echo '<div class="wrap"><h1>' . esc_html__('View not found.', 'wp-amc') . '</h1></div>';
        }
    }
}
