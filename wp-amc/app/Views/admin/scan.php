<div class="wrap">
    <h1><?php esc_html_e('Scan Sheets', 'wp-amc'); ?></h1>
    <form method="post">
        <?php settings_fields('wpamc_scan'); ?>
        <?php wp_nonce_field('wpamc_scan_nonce', 'wpamc_scan_nonce'); ?>
        <table class="form-table wpamc-table">
            <tr>
                <th scope="row"><label for="scans_dir"><?php esc_html_e('Scans directory', 'wp-amc'); ?></label></th>
                <td><input name="scans_dir" id="scans_dir" type="text" class="regular-text" value="" /></td>
            </tr>
        </table>
        <?php submit_button(); ?>
    </form>
</div>
