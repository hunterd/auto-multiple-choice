<?php
/*
Plugin Name: Auto Multiple Choice
Description: Integrates Auto Multiple Choice tools into WordPress.
*/

if (!defined('ABSPATH')) {
    exit;
}

define('WP_AMC_PLUGIN_FILE', __FILE__);

require_once __DIR__ . '/app/Models/PrepareModel.php';
require_once __DIR__ . '/app/Models/ScanModel.php';
require_once __DIR__ . '/app/Models/GradeModel.php';
require_once __DIR__ . '/app/Models/ExportModel.php';
require_once __DIR__ . '/app/Models/PreferencesModel.php';

require_once __DIR__ . '/app/Controllers/Admin/MenuController.php';

// Initialize admin menu
add_action('admin_menu', ['\WpAmc\Controllers\Admin\MenuController', 'register']);
add_action('admin_enqueue_scripts', ['\WpAmc\Controllers\Admin\MenuController', 'enqueue_assets']);
