<div class="wrap">
    <h1><?php esc_html_e('Manual Grading', 'wp-amc'); ?></h1>
    <form method="post">
        <?php settings_fields('wpamc_grade'); ?>
        <?php wp_nonce_field('wpamc_grade_nonce', 'wpamc_grade_nonce'); ?>
        <table class="form-table wpamc-table">
            <tr>
                <th scope="row"><label for="grade_file"><?php esc_html_e('Grade file', 'wp-amc'); ?></label></th>
                <td><input name="grade_file" id="grade_file" type="text" class="regular-text" value="" /></td>
            </tr>
        </table>
        <?php submit_button(); ?>
    </form>
</div>
