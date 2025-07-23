<?php
/*
Plugin Name: Auto Multiple Choice
Description: Integrates Auto Multiple Choice tools into WordPress.
*/

if (!defined('ABSPATH')) {
    exit;
}

// Autoload dependencies if available
if (file_exists(__DIR__ . '/vendor/autoload.php')) {
    require __DIR__ . '/vendor/autoload.php';
}

require_once __DIR__ . '/app/helpers.php';
require_once __DIR__ . '/app/Controllers/Admin/MenuController.php';
require_once __DIR__ . '/app/Controllers/PdfController.php';
require_once __DIR__ . '/app/Controllers/ScanController.php';
require_once __DIR__ . '/app/Controllers/ExportController.php';
require_once __DIR__ . '/app/Controllers/MailingController.php';

// Initialize admin menu
add_action('admin_menu', ['\WpAmc\Controllers\Admin\MenuController', 'register']);
