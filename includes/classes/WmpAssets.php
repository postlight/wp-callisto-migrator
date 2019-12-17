<?php
/**
 * Assets
 *
 * @package   WmpAssets
 * @developer Postlight <http://postlight.com>
 * @version   1.0
 */
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Exit if accessed directly
 */
class WmpAssets extends WmpBase
{
    /**
     * Enqueue Assets
     */
    public function wmp_assets()
    {
        //Only add css to wmp pages
        $current_page = get_current_screen()->base;
        $wmp_plugin_pages = [
            'toplevel_page_wmp_index',
            'toplevel_page_wmp_settings'
        ];
        if (in_array($current_page, $wmp_plugin_pages)) {
            //Styles
            wp_enqueue_style('wmp_src_css', WMP_PLUGIN_URL . 'includes/assets/css/styles.css', array(), '1.0');

            //Scripts
            wp_enqueue_script('wmp_js_helpers', WMP_PLUGIN_URL . "includes/assets/js/helpers.js", array('jquery'), '1.0', true);
            wp_enqueue_script('wmp_js_scripts', WMP_PLUGIN_URL . "includes/assets/js/scripts.js", array('jquery'), '1.0', true);
        }
    }

    public function __construct()
    {
        add_action('admin_enqueue_scripts', array(&$this, 'wmp_assets'));

        parent::__construct();
    }
}
