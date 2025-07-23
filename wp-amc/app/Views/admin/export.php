<div class="wrap">
    <h1><?php echo esc_html__('Export Results', 'wp-amc'); ?></h1>
    <form method="post">
        <input type="hidden" name="wp_amc_action" value="export_results" />
        <?php wp_nonce_field('wp_amc_admin_export'); ?>
        <table class="form-table" role="presentation">
            <tr>
                <th scope="row"><label for="project"><?php echo esc_html__('Project Directory', 'wp-amc'); ?></label></th>
                <td><input name="project" type="text" id="project" class="regular-text" /></td>
            </tr>
            <tr>
                <th scope="row"><label for="output"><?php echo esc_html__('Output CSV', 'wp-amc'); ?></label></th>
                <td><input name="output" type="text" id="output" class="regular-text" /></td>
            </tr>
        </table>
        <?php submit_button(__('Export Marks', 'wp-amc')); ?>
    </form>
</div>

<?php
use WpAmc\Controllers\ExportController;
if ($_SERVER['REQUEST_METHOD'] === 'POST' &&
    isset($_POST['wp_amc_action']) &&
    $_POST['wp_amc_action'] === 'export_results' &&
    check_admin_referer('wp_amc_admin_export')) {
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
