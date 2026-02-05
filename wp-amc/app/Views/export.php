<h1><?php echo esc_html__('Export Results', 'wp-amc'); ?></h1>
<form method="post">
    <input type="hidden" name="wp_amc_action" value="export_results" />
    <?php wp_nonce_field('wp_amc_export'); ?>
    <label><?php echo esc_html__('Project Directory', 'wp-amc'); ?>
        <input type="text" name="project" />
    </label>
    <label><?php echo esc_html__('Output CSV', 'wp-amc'); ?>
        <input type="text" name="output" />
    </label>
    <button type="submit"><?php echo esc_html__('Export Marks', 'wp-amc'); ?></button>
</form>

<?php
use WpAmc\Controllers\ExportController;
if ($_SERVER['REQUEST_METHOD'] === 'POST' &&
    isset($_POST['wp_amc_action']) &&
    $_POST['wp_amc_action'] === 'export_results' &&
    check_admin_referer('wp_amc_export')) {
    $controller = new ExportController();
    $project = sanitize_text_field($_POST['project']);
    $outputFile = sanitize_text_field($_POST['output']);
    $result = $controller->exportResults($project, $outputFile);
    echo '<h2>' . esc_html__('Command output', 'wp-amc') . '</h2>';
    echo '<pre>' . esc_html(implode("\n", $result['output'])) . '</pre>';
    echo '<p>Status: ' . intval($result['status']) . '</p>';
    \WpAmc\add_notice('Export finished with status ' . intval($result['status']));
}
?>
