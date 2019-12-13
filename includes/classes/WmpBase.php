<?php
/**
 * Base plugin class
 *
 * @package WmpBase
 * @developer  Postlight <http://postlight.com>
 * @version 1.0
 *
 */
if (!defined('ABSPATH')) {
    exit;
}

/** Exit if accessed directly */
class WmpBase
{
    public $hooks;
    public $dbTables;
    public $helpers;
    public $assets;
    public $pages;

    /** Required for extended classes to work */
    public function __construct()
    {
    }

    public function init()
    {
        /** Require classes */
        require wmp_plugin_dir . 'includes/classes/hooks/WmpHooks.php';
        require wmp_plugin_dir . 'includes/classes/db/WmpDb.php';
        require wmp_plugin_dir . 'includes/classes/assets/WmpAssets.php';
        require wmp_plugin_dir . 'includes/classes/helpers/WmpHelpers.php';
        require wmp_plugin_dir . 'includes/classes/pages/WmpPages.php';

        /** Init classes */
        $this->hooks = new WmpHooks();
        $this->dbTables = new WmpDb();
        $this->helpers = new WmpHelpers();
        $this->assets = new WmpAssets();
        $this->pages = new WmpPages();
    }
}
