<?php
/*
Plugin Name: Auto Multiple Choice
Description: Integrates Auto Multiple Choice tools into WordPress.
*/

if (!defined('ABSPATH')) {
    exit;
}

require_once __DIR__ . '/app/Controllers/Admin/MenuController.php';

// Initialize admin menu
add_action('admin_menu', ['\WpAmc\Controllers\Admin\MenuController', 'register']);
// Set default options on activation
register_activation_hook(__FILE__, function () {
    add_option('wp_amc_enable_scan', true);
    add_option('wp_amc_enable_mailing', true);
});
