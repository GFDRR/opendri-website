<?php

if ( ! defined( 'ABSPATH' ) ) exit;

class MapboxSimpleSettingsPage
{
  /**
   * Holds the values to be used in the fields callbacks
   */
  private $mapbox_simple_apikey;

  /**
   * Start up
   */
  public function __construct()
  {
	add_action( 'admin_menu', array( $this, 'add_plugin_page' ) );
	add_action( 'admin_init', array( $this, 'page_init' ) );
  }

  /**
   * Add options page
   */
  public function add_plugin_page()
  {
	// This page will be under "Settings"
	add_options_page(
	  'Settings Admin',
	  'Mapbox Simple',
	  'manage_options',
	  'mapbox-simple-admin',
	  array( $this, 'create_admin_page' )
	);
  }

  /**
   * Options page callback
   */
  public function create_admin_page()
  {
	// Set class property
	$this->mapbox_simple_apikey = get_option( 'mapbox_simple_apikey', 'SET UP MAPBOX API KEY' );
	?>
	<div class="wrap">
	  <h1>Mapbox Simple Settings</h1>
	  <form method="post" action="options.php">
		<?php
		// This prints out all hidden setting fields
		settings_fields( 'mapbox_simple_group' );
		do_settings_sections( 'mapbox-simple-admin' );
		submit_button();
		?>
	  </form>
	</div>
	<?php
  }

  /**
   * Register and add settings
   */
  public function page_init()
  {
	register_setting(
	  'mapbox_simple_group', // Option group
	  'mapbox_simple_apikey', // Option name
	  array( $this, 'sanitize' ) // Sanitize
	);

	add_settings_section(
	  'mapbox_simple', // ID
	  'Mapbox Simple', // Title
	  null, // Callback
	  'mapbox-simple-admin' // Page
	);

	add_settings_field(
	  'mapbox_simple_apikey', // ID
	  'API Key', // Title
	  array( $this, 'mapbox_simple_apikey_callback' ),
	  'mapbox-simple-admin', // Page
	  'mapbox_simple' // Section
	);

  }

  /**
   * Sanitize each setting field as needed
   *
   * @param array $input Contains all settings fields as array keys
   *
   * @return array
   */
  public function sanitize( $input )
  {
	$new_input = array();

	if ( isset( $input ) ) {
	  $new_input = sanitize_text_field( $input );
	}

	return $new_input;
  }

  /**
   * Get the settings option array and print one of its values
   */
  public function mapbox_simple_apikey_callback()
  {
	printf(
	  '<input type="text" id="endpoint" name="mapbox_simple_apikey" value="%s" />',
	  isset( $this->mapbox_simple_apikey ) ? esc_attr( $this->mapbox_simple_apikey) : ''
	);
  }
}

if ( is_admin() ) {
  $mapbox_simple_settings_page = new MapboxSimpleSettingsPage();
}
