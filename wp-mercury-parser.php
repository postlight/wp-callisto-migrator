<?php
/*
Plugin Name: WP Mercury Parser
Plugin URI: https://mercury.postlight.com/web-parser/
Description: Mercury Parser for WordPress
Version: 1.0
Author: Postlight
Author URI: https://postlight.com
 */
if (!defined('ABSPATH')) {
    exit;
}
/** Exit if accessed directly */

/** Definitions start */
if (!defined('wmp_prefix')) {

    define('wmp_prefix', 'wmp_');

    define('wmp_default_timezone', 'America/New York');
    define('wmp_date_format', 'd-m-Y');

    define('wmp_plugin_folder_name', 'wp-mercury-parser');
    define('wmp_plugin_url', WP_PLUGIN_URL . '/' . wmp_plugin_folder_name . '/');

    define('wmp_plugin_dir', dirname(__FILE__) . '/');

    if (isset(get_option('wmp_settings_api_endpoint')['wmp_settings_api_endpoint_field']) && get_option('wmp_settings_api_endpoint')['wmp_settings_api_endpoint_field']) {
        define('wmp_mercury_parser_endpoint', get_option('wmp_settings_api_endpoint')['wmp_settings_api_endpoint_field']);
        define('wmp_custom_endpoint', 1);
    } else {
        define('wmp_mercury_parser_endpoint', 'https://qlcdg90ss7.execute-api.us-east-1.amazonaws.com/dev/parser');
        define('wmp_custom_endpoint', 0);
    }
}
/** Definitions end */

/** Root DIR start */
function wmp_get_plugin_dir() {
    return plugin_dir_path( __FILE__ );
}
/** Root DIR end */

/** Load plugin Start */
require wmp_plugin_dir . '/includes/classes/WmpBase.php';
global $wmp;
$wmp = new WmpBase;
$wmp->init();
/** Load plugin End */


