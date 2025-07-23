<div class="wrap">
    <h1><?php esc_html_e('AMC Preferences', 'wp-amc'); ?></h1>
    <form method="post">
        <?php wp_nonce_field('wp_amc_save_preferences'); ?>
        <table class="form-table" role="presentation">
            <tr>
                <th scope="row">
                    <label for="enable_scan"><?php esc_html_e('Enable Scan Module', 'wp-amc'); ?></label>
                </th>
                <td>
                    <input type="checkbox" id="enable_scan" name="enable_scan" value="1" <?php checked(get_option('wp_amc_enable_scan', true)); ?> />
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="enable_mailing"><?php esc_html_e('Enable Mailing Module', 'wp-amc'); ?></label>
                </th>
                <td>
                    <input type="checkbox" id="enable_mailing" name="enable_mailing" value="1" <?php checked(get_option('wp_amc_enable_mailing', true)); ?> />
                </td>
            </tr>
        </table>
        <p class="submit">
            <input type="submit" name="submit_wp_amc_preferences" id="submit" class="button button-primary" value="<?php esc_attr_e('Save Changes'); ?>" />
        </p>
    </form>
</div>
