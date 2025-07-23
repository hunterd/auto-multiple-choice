<?php
/*
Plugin Name: Auto Multiple Choice
Description: Integrates Auto Multiple Choice tools into WordPress.
*/

if (!defined('ABSPATH')) {
    exit;
}

require_once __DIR__ . '/vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as Capsule;

function wpamc_init_eloquent()
{
    global $wpdb;

    static $initialized = false;
    if ($initialized) {
        return;
    }

    $capsule = new Capsule();
    $capsule->addConnection([
        'driver'    => 'mysql',
        'host'      => DB_HOST,
        'database'  => DB_NAME,
        'username'  => DB_USER,
        'password'  => DB_PASSWORD,
        'charset'   => $wpdb->charset ?: 'utf8mb4',
        'collation' => $wpdb->collate ?: 'utf8mb4_unicode_ci',
        'prefix'    => $wpdb->prefix . 'amc_',
    ]);

    $capsule->setAsGlobal();
    $capsule->bootEloquent();

    $initialized = true;
}

add_action('plugins_loaded', 'wpamc_init_eloquent');

use Illuminate\Database\Schema\Blueprint;

function wpamc_activate()
{
    wpamc_init_eloquent();
    $schema = Capsule::schema();

    if (!$schema->hasTable('projects')) {
        $schema->create('projects', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('path');
        });
    }

    if (!$schema->hasTable('questions')) {
        $schema->create('questions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('project_id');
            $table->text('text');
            $table->integer('score')->default(0);
        });
    }

    if (!$schema->hasTable('answers')) {
        $schema->create('answers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('question_id');
            $table->text('text');
            $table->boolean('is_correct')->default(false);
        });
    }

    if (!$schema->hasTable('students')) {
        $schema->create('students', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('email');
        });
    }

    if (!$schema->hasTable('results')) {
        $schema->create('results', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('project_id');
            $table->float('score')->default(0);
        });
    }
}

register_activation_hook(__FILE__, 'wpamc_activate');

// Initialize admin menu
add_action('admin_menu', ['\WpAmc\Controllers\Admin\MenuController', 'register']);
