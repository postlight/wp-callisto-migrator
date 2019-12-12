<?php
/**
 * Assets
 *
 * @package WmpAssets
 * @developer  Postlight <http://postlight.com>
 * @version 1.0
 *
 */
if (!defined('ABSPATH')) {
    exit;
}

/** Exit if accessed directly */
class WmpAssets extends WmpBase
{
    /** Enqueue Assets */
    public function wmp_assets()
    {
        //Only add bootstrap to wmp pages
        // $current_page = get_current_screen()->base;
        // $wmp_plugin_pages = [
        //     'toplevel_page_wmp_index',
        //     'toplevel_page_wmp_settings',
        //     'wmp_page_logs',
        // ];
        // if (in_array($current_page, $wmp_plugin_pages)) {
        //     wp_enqueue_style('wmp_src_bootstrap_css', wmp_plugin_url . 'includes/assets/libraries/bootstrap/css/bootstrap.css', array(), '1.0');
        //     wp_enqueue_style('wmp_src_bootstrap_css_theme', wmp_plugin_url . 'includes/assets/libraries/bootstrap/css/bootstrap-theme.css', array(), '1.0');
        //     wp_enqueue_script('wmp_src_bootstrap_js', wmp_plugin_url . "includes/assets/libraries/bootstrap/js/bootstrap.js", array('jquery'), '1.0', true);
        // }
        wp_enqueue_style('wmp_src_css', wmp_plugin_url . 'includes/assets/css/styles.css', array(), '1.0');
    }

    public function __construct()
    {
        add_action('admin_enqueue_scripts', array(&$this, 'wmp_assets'));

        parent::__construct();
    }
}
