# WP-AMC Plugin

This WordPress plugin integrates [Auto Multiple Choice](https://www.auto-multiple-choice.net/) features.

## Installation

1. From this directory, run:

   ```bash
   composer install
   ```

   This downloads the PHP dependencies defined in `composer.json`.

2. Copy the plugin folder into your WordPress `wp-content/plugins` directory and activate it from the admin area.


## Hooks

The plugin exposes several action hooks allowing extensions to run custom code at key points:

- `wp_amc_prepare_exam` fires when the **Prepare Exam** page is loaded.
- `wp_amc_scan_sheets` fires when the **Scan Sheets** page is loaded.
- `wp_amc_mailing` fires when the **Mailing** page is loaded (if the module is enabled).
- `wp_amc_manual_grading` fires when the **Manual Grading** page is loaded.
- `wp_amc_export_results` fires when the **Export Results** page is loaded.
- `wp_amc_preferences` fires when the **Preferences** page is loaded.

Developers can hook into these actions to modify the behaviour of the plugin or inject additional content.
