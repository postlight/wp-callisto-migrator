<?php
/**
 * Base
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
    public $helpers;
    public $assets;
    public $ajax;
    public $pages;

    /** Required for extended classes to work */
    public function __construct()
    {
    }

    public function init()
    {
        /** Require classes */
        require wmp_plugin_dir . 'includes/classes/WmpHelpers.php';
        require wmp_plugin_dir . 'includes/classes/WmpAssets.php';
        require wmp_plugin_dir . 'includes/classes/WmpAjax.php';
        require wmp_plugin_dir . 'includes/classes/WmpPages.php';

        /** Init classes */
        $this->helpers = new WmpHelpers();
        $this->assets = new WmpAssets();
        $this->ajax = new WmpAjax();
        $this->pages = new WmpPages();
    }
}
