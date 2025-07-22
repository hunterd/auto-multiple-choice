<?php
/*
Plugin Name: Auto Multiple Choice
*/

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

// Plugin path constant
if (!defined('WP_AMC_PATH')) {
    define('WP_AMC_PATH', plugin_dir_path(__FILE__));
}

// Activation and deactivation hooks
function wp_amc_activate() {
    // Place activation logic here
}

function wp_amc_deactivate() {
    // Place deactivation logic here
}

register_activation_hook(__FILE__, 'wp_amc_activate');
register_deactivation_hook(__FILE__, 'wp_amc_deactivate');

// Simple autoloader following PSR-4 like structure
spl_autoload_register(function ($class) {
    $prefix = 'WP_AMC\\';
    $base_dir = WP_AMC_PATH . 'app/';
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }
    $relative_class = substr($class, $len);
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';
    if (file_exists($file)) {
        require $file;
    }
});

// Register admin menu
add_action('admin_menu', 'wp_amc_admin_menu');
function wp_amc_admin_menu() {
    add_menu_page(
        'Auto Multiple Choice',
        'Auto MC',
        'manage_options',
        'wp-amc',
        'wp_amc_router'
    );
}

// Basic router for admin pages
function wp_amc_router() {
    $routes = include WP_AMC_PATH . 'app/routes.php';
    $page = isset($_GET['page']) ? $_GET['page'] : 'wp-amc';
    if (isset($routes[$page])) {
        list($class, $method) = $routes[$page];
        if (class_exists($class) && method_exists($class, $method)) {
            call_user_func([$class, $method]);
            return;
        }
    }
    echo '<div class="wrap"><h1>Page not found</h1></div>';
}
