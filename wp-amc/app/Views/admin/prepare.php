<div class="wrap">
    <h1><?php echo esc_html__('Prepare Exam', 'wp-amc'); ?></h1>
    <form method="post">
        <input type="hidden" name="wp_amc_action" value="generate_pdf" />
        <?php wp_nonce_field('wp_amc_admin_prepare'); ?>
        <table class="form-table" role="presentation">
            <tr>
                <th scope="row"><label for="project"><?php echo esc_html__('Project Directory', 'wp-amc'); ?></label></th>
                <td><input name="project" type="text" id="project" class="regular-text" /></td>
            </tr>
        </table>
        <?php submit_button(__('Generate PDF', 'wp-amc')); ?>
    </form>
</div>

<?php
use WpAmc\Controllers\PdfController;
if ($_SERVER['REQUEST_METHOD'] === 'POST' &&
    isset($_POST['wp_amc_action']) &&
    $_POST['wp_amc_action'] === 'generate_pdf' &&
    check_admin_referer('wp_amc_admin_prepare')) {
    $controller = new PdfController();
    $project = sanitize_text_field($_POST['project']);
    $result = $controller->generate($project);
    echo '<h2>' . esc_html__('Command output', 'wp-amc') . '</h2>';
    echo '<pre>' . esc_html(implode("\n", $result['output'])) . '</pre>';
    echo '<p>Status: ' . intval($result['status']) . '</p>';
    \WpAmc\add_notice('PDF generation finished with status ' . intval($result['status']));
}
?>
