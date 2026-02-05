# WP-AMC Setup and Usage Guide

This plugin integrates Auto Multiple Choice (AMC) features into WordPress, allowing you to manage exams, scan sheets, and grade results directly from your WP admin dashboard.

## Prerequisites

- **PHP**: Version 8.2 or higher.
- **WordPress**: Version 6.0 or higher (recommended).
- **Composer**: Required to install PHP dependencies.
- **System Dependencies**: The plugin relies on external Perl scripts (`AMC-*.pl`) which must be installed and accessible in the system path. Ensure the full Auto Multiple Choice software suite is installed on the server.

## Installation

1.  **Download/Clone**: Place the `wp-amc` folder into your WordPress plugins directory (`wp-content/plugins/`).
2.  **Install Dependencies**:
    Navigate to the plugin directory in your terminal and run:
    ```bash
    cd wp-content/plugins/wp-amc
    composer install
    ```
3.  **Activate**: Log in to your WordPress admin dashboard, go to **Plugins**, and activate **Auto Multiple Choice**.

## Usage

Upon activation, a new menu item **Auto Multiple Choice** will appear in the admin sidebar.

### 1. Prepare Exam
*Navigate to: Auto Multiple Choice > Prepare Exam*

Use this page to define your project structure and questions.
- Create a new project.
- Define questions and answers.
- Generate the subject and answer sheets.

### 2. Scan Sheets
*Navigate to: Auto Multiple Choice > Scan Sheets*
*(Requires `Enable Scan Module` to be active in Preferences)*

- Upload scanned images of the answer sheets.
- The system will use `AMC-analyse.pl` to process the images and extract student responses.

### 3. Manual Grading
*Navigate to: Auto Multiple Choice > Manual Grading*

- Review uncertain marks or scans that the system flagged.
- Manually correct grades if necessary.

### 4. Mailing
*Navigate to: Auto Multiple Choice > Mailing*
*(Requires `Enable Mailing Module` to be active in Preferences)*

- Send annotated answer sheets to students via email.
- Requires a CSV list of students with email addresses.

### 5. Export Results
*Navigate to: Auto Multiple Choice > Export Results*

- Export the final grades and results to a CSV file.
- Useful for importing into other gradebook systems.

### 6. Preferences
*Navigate to: Auto Multiple Choice > Preferences*

- Toggle modules like **Scan** and **Mailing** on or off.

## Troubleshooting

- **"Class not found" errors**: Ensure you ran `composer install`.
- **AMC commands failing**: Check that `AMC-export.pl`, `AMC-analyse.pl`, etc., are in your system `$PATH` and executable by the web server user.
- **Database issues**: The plugin creates custom tables (`wp_amc_projects`, `wp_amc_questions`, etc.) upon activation. If these are missing, try deactivating and reactivating the plugin.
