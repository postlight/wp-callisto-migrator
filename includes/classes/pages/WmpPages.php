<?php
/**
 * Plugin pages
 *
 * @package WmpPages
 * @developer  Postlight <http://postlight.com>
 * @version 1.0
 *
 */
if (!defined('ABSPATH')) {
    exit;
}

class WmpPages extends WmpBase
{

    /** Add pages */
    public function wmp_pages()
    {
        $capability = "manage_options";
        add_menu_page("Mercury Parser", "Mercury Parser", $capability, "wmp_index", "wmp_index", "dashicons-category", null);
        add_submenu_page("wmp_index", "Settings", "Settings", $capability, "wmp_settings", "wmp_settings");
        // add_submenu_page("wmp_index", "Export Logs", "Export Logs", $capability, "wmp_logs", "wmp_logs");
    }

    public function __construct()
    {
        /** Require pages */
        require wmp_plugin_dir . 'includes/classes/pages/content/wmp_index.php';
        require wmp_plugin_dir . 'includes/classes/pages/content/wmp_settings.php';
        // require wmp_plugin_dir . 'includes/classes/pages/content/wmp_logs.php';

        add_action("admin_menu", array(&$this, "wmp_pages"));
        parent::__construct();
    }
}
