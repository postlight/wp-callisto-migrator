<?php
/**
 * Assets
 *
 * @package   WmpAssets
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
 * Assets Class.
 */
class WmpAssets extends WmpBase {
	/**
	 * Enqueue Assets
	 */
	public function wmp_assets() {
		// Only add css to wmp pages.
		$current_page     = get_current_screen()->base;
		$wmp_plugin_pages = array(
			'toplevel_page_wmp_index',
			'toplevel_page_wmp_settings',
		);
		if ( in_array( $current_page, $wmp_plugin_pages, true ) ) {
			// Register styles and scripts.
			wp_register_style( 'wmp_src_css', plugins_url('../assets/css/styles.css', __FILE__), array(), '1.3' );
			wp_register_script( 'wmp_js_helpers', plugins_url('../assets/js/helpers.js', __FILE__), array( 'jquery' ), '1.3', true );
			wp_register_script( 'wmp_js_scripts', plugins_url('../assets/js/scripts.js', __FILE__), array( 'jquery' ), '1.3', true );

			// Enqueue styles and scripts.
			wp_enqueue_style( 'wmp_src_css' );
			wp_enqueue_script( 'wmp_js_helpers' );
			wp_enqueue_script( 'wmp_js_scripts' );
		}
	}

	/**
	 *
	 * WMP Assets Enqueues
	 **/
	public function __construct() {
		add_action( 'admin_enqueue_scripts', array( &$this, 'wmp_assets' ) );

		parent::__construct();
	}
}
