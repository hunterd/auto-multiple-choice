<h1><?php echo esc_html__('Send Annotated Copies', 'wp-amc'); ?></h1>
<form method="post">
    <input type="hidden" name="wp_amc_action" value="send_emails" />
    <?php wp_nonce_field('wp_amc_mailing'); ?>
    <label><?php echo esc_html__('Project Directory', 'wp-amc'); ?>
        <input type="text" name="project" />
    </label>
    <label><?php echo esc_html__('Students List CSV', 'wp-amc'); ?>
        <input type="text" name="students" />
    </label>
    <button type="submit"><?php echo esc_html__('Send Emails', 'wp-amc'); ?></button>
</form>

<?php
use WpAmc\Controllers\MailingController;
if ($_SERVER['REQUEST_METHOD'] === 'POST' &&
    isset($_POST['wp_amc_action']) &&
    $_POST['wp_amc_action'] === 'send_emails' &&
    check_admin_referer('wp_amc_mailing')) {
    $controller = new MailingController();
    $project = sanitize_text_field($_POST['project']);
    $students = sanitize_text_field($_POST['students']);
    $result = $controller->sendEmails($project, $students);
    echo '<h2>' . esc_html__('Command output', 'wp-amc') . '</h2>';
    echo '<pre>' . esc_html(implode("\n", $result['output'])) . '</pre>';
    echo '<p>Status: ' . intval($result['status']) . '</p>';
    \WpAmc\add_notice('Mailing finished with status ' . intval($result['status']));
}
?>
