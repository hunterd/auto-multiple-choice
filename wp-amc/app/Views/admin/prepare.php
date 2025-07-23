<div class="wrap">
    <h1><?php esc_html_e('Prepare Exam', 'wp-amc'); ?></h1>
    <form method="post">
        <?php settings_fields('wpamc_prepare'); ?>
        <?php wp_nonce_field('wpamc_prepare_nonce', 'wpamc_prepare_nonce'); ?>
        <table class="form-table wpamc-table">
            <tr>
                <th scope="row"><label for="project_dir"><?php esc_html_e('Project directory', 'wp-amc'); ?></label></th>
                <td><input name="project_dir" id="project_dir" type="text" class="regular-text" value="" /></td>
            </tr>
        </table>
        <?php submit_button(); ?>
    </form>
</div>
