<?php
/**
 * Plugin pages
 *
 * @package   WmpPages
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
 * Pages Class.
 */
class WmpPages extends WmpBase {

	/**
	 *
	 * WMP Settings option
	 *
	 * @var $options
	 **/
	private $options;

	/**
	 * Add pages
	 */
	public function wmp_pages() {
		$capability = 'manage_options';
		add_menu_page( 'Callisto Migrator', 'Callisto Migrator', $capability, 'wmp_index', 'wmp_index', 'dashicons-category', null );
		add_submenu_page( 'wmp_index', 'Settings', 'Settings', $capability, 'wmp_settings', array( $this, 'wmp_settings_cb' ) );
	}

	/**
	 * Option page fields
	 */
	public function wmp_options_sections() {
		register_setting(
			'wmp_settings_group',
			'wmp_settings_api_endpoint'
		);

		add_settings_section(
			'setting_section_id',
			'API Endpoint Settings',
			array( $this, 'wmp_options_sections_cb' ),
			'wmp_settings'
		);

		add_settings_field(
			'wmp_settings_api_endpoint_field',
			'Self Hosted API Endpoint',
			array( $this, 'wmp_mercury_parser_settings_api_cb' ),
			'wmp_settings',
			'setting_section_id'
		);
	}

	/**
	 * Input settings callback
	 */
	public function wmp_mercury_parser_settings_api_cb() {
		printf(
			'<input type="url" placeholder="https://r0andgen27.execute-api.us-east-1.amazonaws.com/dev/parser" class="regular-text" id="wmp_settings_api_endpoint_field" name="wmp_settings_api_endpoint[wmp_settings_api_endpoint_field]" value="%s" />',
			isset( $this->options['wmp_settings_api_endpoint_field'] ) ? esc_attr( $this->options['wmp_settings_api_endpoint_field'] ) : ''
		);
		echo '<span class="description"> Enter your self-hosted Postlight Parser API endpoint here</span><br>';
	}

	/**
	 * Options settings callback
	 */
	public function wmp_options_sections_cb() {
	}

	/**
	 * Settings group callback
	 */
	public function wmp_settings_cb() {
		// Set class property.
		$this->options = get_option( 'wmp_settings_api_endpoint' );
		?>
		<div class="wrap">
			<h1>WP Postlight Parser API Settings</h1>
			<?php settings_errors(); ?>
			<form method="post" action="options.php">
				<?php
				settings_fields( 'wmp_settings_group' );
				do_settings_sections( 'wmp_settings' );
				submit_button();
				?>
			</form>
		</div>
		<?php
	}

	/**
	 * Wmp Pages class + settings fields.
	 */
	public function __construct() {
		/**
		 * Require pages
		 */
		include WMP_PLUGIN_DIR . 'includes/classes/pages/wmp-index.php';

		add_action( 'admin_menu', array( &$this, 'wmp_pages' ) );

		// Settings options.
		add_action( 'admin_init', array( &$this, 'wmp_options_sections' ) );

		parent::__construct();
	}
}
