<div class="wrap">
    <h1><?php echo esc_html__('Scan Copies', 'wp-amc'); ?></h1>
    <form method="post">
        <input type="hidden" name="wp_amc_action" value="scan_copies" />
        <?php wp_nonce_field('wp_amc_admin_scan'); ?>
        <table class="form-table" role="presentation">
            <tr>
                <th scope="row"><label for="project"><?php echo esc_html__('Project Directory', 'wp-amc'); ?></label></th>
                <td><input name="project" type="text" id="project" class="regular-text" /></td>
            </tr>
            <tr>
                <th scope="row"><label for="scans"><?php echo esc_html__('Scans Directory', 'wp-amc'); ?></label></th>
                <td><input name="scans" type="text" id="scans" class="regular-text" /></td>
            </tr>
        </table>
        <?php submit_button(__('Run Analysis', 'wp-amc')); ?>
    </form>
</div>

<?php
use WpAmc\Controllers\ScanController;
if ($_SERVER['REQUEST_METHOD'] === 'POST' &&
    isset($_POST['wp_amc_action']) &&
    $_POST['wp_amc_action'] === 'scan_copies' &&
    check_admin_referer('wp_amc_admin_scan')) {
    $controller = new ScanController();
    $project = sanitize_text_field($_POST['project']);
    $scans = sanitize_text_field($_POST['scans']);
    $result = $controller->analyse($project, $scans);
    echo '<h2>' . esc_html__('Command output', 'wp-amc') . '</h2>';
    echo '<pre>' . esc_html(implode("\n", $result['output'])) . '</pre>';
    echo '<p>Status: ' . intval($result['status']) . '</p>';
    \WpAmc\add_notice('Scan finished with status ' . intval($result['status']));
}
?>
