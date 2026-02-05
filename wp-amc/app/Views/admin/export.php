<div class="wrap">
    <h1><?php esc_html_e('Export Results', 'wp-amc'); ?></h1>
    <form method="post">
        <?php settings_fields('wpamc_export'); ?>
        <?php wp_nonce_field('wpamc_export_nonce', 'wpamc_export_nonce'); ?>
        <table class="form-table wpamc-table">
            <tr>
                <th scope="row"><label for="output_csv"><?php esc_html_e('Output CSV', 'wp-amc'); ?></label></th>
                <td><input name="output_csv" id="output_csv" type="text" class="regular-text" value="" /></td>
            </tr>
        </table>
        <?php submit_button(__('Export', 'wp-amc')); ?>
    </form>
</div>
