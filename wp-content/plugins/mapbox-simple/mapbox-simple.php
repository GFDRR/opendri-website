<?php
/**
 * Plugin Name: mapbox-simple
 * Description: Allows adding a configurable mapbox map to a post
 * Author: Vizzuality
 * Author URI: http://vizzuality.com
 */
require_once __DIR__ . '/mapbox-simple-settings.php';
$MAPBOX_SIMPLE_APIKEY = get_option('mapbox_simple_apikey' );

function getMapboxSimpleVal($params, $value, $default) {
  return isset($params[$value]) ? $params[$value] : $default;
}

function mapbox_map( $atts ) {
  global $MAPBOX_SIMPLE_APIKEY;
  $map_id = uniqid('mapbox-simple-');
  $layers = getMapboxSimpleVal($atts, 'layers', 'mapbox.streets');
  $latitude = getMapboxSimpleVal($atts, 'latitude', '40.4746');
  $longitude = getMapboxSimpleVal($atts, 'longitude', '-3.7048');
  $zoom = getMapboxSimpleVal($atts, 'zoom', '3');
  $minZoom = getMapboxSimpleVal($atts, 'min_zoom', '0');
  $maxZoom = getMapboxSimpleVal($atts, 'max_zoom', '22');
  $scrollWheelZoom = getMapboxSimpleVal($atts, 'scroll_wheel_zoom', 'false');
  return <<<EOD
  <div id='{$map_id}' style='width:100%; height: 400px'></div>
  <script>
    L.mapbox.accessToken = '{$MAPBOX_SIMPLE_APIKEY}';

    var map = L.mapbox.map('{$map_id}', '{$layers}', {
        minZoom: {$minZoom},
        maxZoom: {$maxZoom},
        scrollWheelZoom: {$scrollWheelZoom}
      })
      .setView([{$latitude}, {$longitude}], {$zoom});
  </script>
EOD;
}

// example: [mapbox_map layers="gfdrr.map-wv1c9ry4,gfdrr.kathmandu-health" latitude="27.6934" longitude="85.3380" zoom="14" max_zoom="20"]
add_shortcode( 'mapbox_map', 'mapbox_map' );

function mapbox_simple_scripts() {
   wp_register_script('mapbox_simple_js', 'https://api.mapbox.com/mapbox.js/v3.1.1/mapbox.js' );
   wp_enqueue_script('mapbox_simple_js');
   wp_register_style('mapbox_simple_styles', 'https://api.mapbox.com/mapbox.js/v3.1.1/mapbox.css' );
   wp_enqueue_style('mapbox_simple_styles');
}

add_action( 'wp_enqueue_scripts', 'mapbox_simple_scripts' );

?>
