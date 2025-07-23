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

        if (get_option('wp_amc_enable_scan', true)) {
            add_submenu_page('wp-amc', __('Scan Sheets', 'wp-amc'), __('Scan Sheets', 'wp-amc'), 'manage_options', 'wp-amc-scan', [self::class, 'scan_sheets']);
        }

        if (get_option('wp_amc_enable_mailing', true)) {
            add_submenu_page('wp-amc', __('Mailing', 'wp-amc'), __('Mailing', 'wp-amc'), 'manage_options', 'wp-amc-mailing', [self::class, 'mailing']);
        }

        add_submenu_page('wp-amc', __('Manual Grading', 'wp-amc'), __('Manual Grading', 'wp-amc'), 'manage_options', 'wp-amc-grade', [self::class, 'manual_grading']);
        add_submenu_page('wp-amc', __('Export Results', 'wp-amc'), __('Export Results', 'wp-amc'), 'manage_options', 'wp-amc-export', [self::class, 'export_results']);
        add_submenu_page('wp-amc', __('Preferences', 'wp-amc'), __('Preferences', 'wp-amc'), 'manage_options', 'wp-amc-preferences', [self::class, 'preferences']);
    }

    public static function prepare_exam()
    {
        if (!current_user_can('manage_options')) {
            wp_die(__('You do not have permission to access this page.', 'wp-amc'));
        }
        do_action('wp_amc_prepare_exam');
        self::render('prepare');
    }

    public static function scan_sheets()
    {
        if (!current_user_can('manage_options')) {
            wp_die(__('You do not have permission to access this page.', 'wp-amc'));
        }
        do_action('wp_amc_scan_sheets');
        self::render('scan');
    }

    public static function manual_grading()
    {
        if (!current_user_can('manage_options')) {
            wp_die(__('You do not have permission to access this page.', 'wp-amc'));
        }
        do_action('wp_amc_manual_grading');
        self::render('grade');
    }

    public static function export_results()
    {
        if (!current_user_can('manage_options')) {
            wp_die(__('You do not have permission to access this page.', 'wp-amc'));
        }
        do_action('wp_amc_export_results');
        self::render('export');
    }

    public static function preferences()
    {
        if (!current_user_can('manage_options')) {
            wp_die(__('You do not have permission to access this page.', 'wp-amc'));
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_wp_amc_preferences'])) {
            check_admin_referer('wp_amc_save_preferences');
            update_option('wp_amc_enable_scan', !empty($_POST['enable_scan']));
            update_option('wp_amc_enable_mailing', !empty($_POST['enable_mailing']));
        }

        do_action('wp_amc_preferences');
        self::render('preferences');
    }

    public static function mailing()
    {
        if (!current_user_can('manage_options')) {
            wp_die(__('You do not have permission to access this page.', 'wp-amc'));
        }
        do_action('wp_amc_mailing');
        self::render('mailing');
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
