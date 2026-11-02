<?php


/*
 * Plugin Name:       widgetflow
 * Plugin URI:        
 * Description:       Show the reading time of each post
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Hasan
 * Author URI:        https://author.hasanmahbub.xyz//
 * License:           GPL v2 or later
 * License URI:       
 *
 * Text Domain:        widgetflow
 * Domain Path:       /languages
 * 
 */


use Hasan\Widgetflow\Main;

if (!defined('ABSPATH')) {
    exit;
}

define('WIDGETFLOW_PATH', plugin_dir_path(__FILE__));
define('WIDGETFLOW_URL', plugin_dir_url(__FILE__));

if (!class_exists(Main::class) && is_readable(__DIR__) . './vendor/autoload.php') {
    require_once __DIR__ . '/vendor/autoload.php';
}



Main::instance()->init();