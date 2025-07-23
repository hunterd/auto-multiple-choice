<h1><?php echo esc_html__('PDF Generation', 'wp-amc'); ?></h1>
<form method="post">
    <input type="hidden" name="wp_amc_action" value="generate_pdf" />
    <?php wp_nonce_field('wp_amc_pdf'); ?>
    <label><?php echo esc_html__('Project Directory', 'wp-amc'); ?>
        <input type="text" name="project" />
    </label>
    <button type="submit"><?php echo esc_html__('Generate PDF', 'wp-amc'); ?></button>
</form>

<?php
use WpAmc\Controllers\PdfController;
if ($_SERVER['REQUEST_METHOD'] === 'POST' &&
    isset($_POST['wp_amc_action']) &&
    $_POST['wp_amc_action'] === 'generate_pdf' &&
    check_admin_referer('wp_amc_pdf')) {
    $controller = new PdfController();
    $project = sanitize_text_field($_POST['project']);
    $result = $controller->generate($project);
    echo '<h2>' . esc_html__('Command output', 'wp-amc') . '</h2>';
    echo '<pre>' . esc_html(implode("\n", $result['output'])) . '</pre>';
    echo '<p>Status: ' . intval($result['status']) . '</p>';
    \WpAmc\add_notice('PDF generation finished with status ' . intval($result['status']));
}
?>
