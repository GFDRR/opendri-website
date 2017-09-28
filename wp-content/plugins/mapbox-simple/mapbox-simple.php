<?php
/**
 * Plugin Name: mapbox-simple
 * Description: Allows adding a configurable mapbox map to a post
 * Author: Vizzuality
 * Author URI: http://vizzuality.com
 */
require_once __DIR__ . '/mapbox-simple-settings.php';
$MAPBOX_SIMPLE_APIKEY = get_option('mapbox_simple_apikey' );


function mapbox_map( $atts ) {
  global $MAPBOX_SIMPLE_APIKEY;
  $atts_encode = json_encode($atts);
  // $test_param = getVal($atts, '$test_param', 'thi is a test');
  $map_id = uniqid('mapbox-simple-');
  return <<<EOD
  {$MAPBOX_SIMPLE_APIKEY}
  <div id='{$map_id}' style='width:100%; height: 400px'></div>
  <script>
    console.log({$atts_encode})
    L.mapbox.accessToken = '{$MAPBOX_SIMPLE_APIKEY}';

    try {
      var map = L.mapbox.map('{$map_id}', 'gfdrr.map-wv1c9ry4,gfdrr.kathmandu-health')
      .setView([27.6934,85.3380], 15);
    } catch (e) {
      console.log(e)
    }
  </script>
EOD;
}

// example: []
add_shortcode( 'mapbox_map', 'mapbox_map' );

function mapbox_simple_scripts() {
   wp_register_script('mapbox_simple_js', 'https://api.mapbox.com/mapbox.js/v3.1.1/mapbox.js' );
   wp_enqueue_script('mapbox_simple_js');
   wp_register_style('mapbox_simple_styles', 'https://api.mapbox.com/mapbox.js/v3.1.1/mapbox.css' );
   wp_enqueue_style('mapbox_simple_styles');
}

add_action( 'wp_enqueue_scripts', 'mapbox_simple_scripts' );

?>
