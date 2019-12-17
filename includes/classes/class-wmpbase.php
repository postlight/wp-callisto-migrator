<?php
/**
 * Base
 *
 * @package   WmpBase
 * @developer Postlight <http://postlight.com>
 * @version   1.0
 */

/**
 * Exit if accessed directly
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Base Main Class.
 */
class WmpBase {
	/**
	 *
	 * WMP Helpers Class
	 *
	 * @var $helpers
	 **/
	public $helpers;

	/**
	 *
	 * WMP Assets Class
	 *
	 * @var $assets
	 **/
	public $assets;

	/**
	 *
	 * WMP AJAX Class
	 *
	 * @var $ajax
	 **/
	public $ajax;

	/**
	 *
	 * WMP Pages Class
	 *
	 * @var $pages
	 **/
	public $pages;

	/**
	 * Required for extended classes to work
	 */
	public function __construct() {
	}

	/**
	 *
	 * Init WMP Plugin
	 **/
	public function init() {
		/**
		 * Require classes
		 */
		include WMP_PLUGIN_DIR . 'includes/classes/class-wmphelpers.php';
		include WMP_PLUGIN_DIR . 'includes/classes/class-wmpassets.php';
		include WMP_PLUGIN_DIR . 'includes/classes/class-wmpajax.php';
		include WMP_PLUGIN_DIR . 'includes/classes/class-wmppages.php';

		/**
		 * Init classes
		 */
		$this->helpers = new WmpHelpers();
		$this->assets  = new WmpAssets();
		$this->ajax    = new WmpAjax();
		$this->pages   = new WmpPages();
	}
}
