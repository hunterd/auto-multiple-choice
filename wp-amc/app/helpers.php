<?php
namespace WpAmc;

/**
 * Append a message to the plugin log file.
 */
function log_message(string $message): void
{
    $dir = __DIR__ . '/../logs';
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
    }
    $file = $dir . '/wp-amc.log';
    $date = date('Y-m-d H:i:s');
    file_put_contents($file, "[$date] $message\n", FILE_APPEND);
}

/**
 * Display a WordPress admin notice and log the message.
 */
function add_notice(string $message, string $type = 'info'): void
{
    add_action('admin_notices', function() use ($message, $type) {
        printf('<div class="notice notice-%s is-dismissible"><p>%s</p></div>', esc_attr($type), esc_html($message));
    });
    log_message($message);
}
