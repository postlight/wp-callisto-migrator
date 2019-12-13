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
        //Only add css to wmp pages
         $current_page = get_current_screen()->base;
         $wmp_plugin_pages = [
             'toplevel_page_wmp_index',
             'toplevel_page_wmp_settings',
             'wmp_page_logs',
         ];
         if (in_array($current_page, $wmp_plugin_pages)) {
             wp_enqueue_style('wmp_src_css', wmp_plugin_url . 'includes/assets/css/styles.css', array(), '1.0');
         }
    }

    public function __construct()
    {
        add_action('admin_enqueue_scripts', array(&$this, 'wmp_assets'));

        parent::__construct();
    }
}
