<div class="wrap">
    <h1><?php esc_html_e('Preferences', 'wp-amc'); ?></h1>
    <form method="post">
        <?php settings_fields('wpamc_preferences'); ?>
        <?php wp_nonce_field('wpamc_preferences_nonce', 'wpamc_preferences_nonce'); ?>
        <table class="form-table wpamc-table">
            <tr>
                <th scope="row"><label for="setting"><?php esc_html_e('Sample setting', 'wp-amc'); ?></label></th>
                <td><input name="setting" id="setting" type="text" class="regular-text" value="" /></td>
            </tr>
        </table>
        <?php submit_button(); ?>
    </form>
</div>
