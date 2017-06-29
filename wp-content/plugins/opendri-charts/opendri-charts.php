<?php
/**
 * Plugin Name: OpenDRI charts
 * Description: Allows adding charts to OpenDRI projects from the admin
 * Author: Vizzuality
 * Author URI: http://vizzuality.com
 */

function compare_map( $atts ) {
  ob_start(); ?>
  <div id="compare-map"></div>
  <script>
    function compareMap(settings) {
      ODRI.compareMap('#compare-map', {
        width: '100%',
        height: '500px',
        settings: settings
      });
    }
    var settings = <?php echo json_encode($atts) ?>;
    settings.iframe_base_url = 'http://localhost:3000';
    if (settings.polygon === undefined) {
      var country = settings.country.toUpperCase() || 'HTI';
      fetch('http://54.224.10.82/api/v1/meta/country_polyline/' + country)
        .then(function(response) {
          return response.text();
        })
        .then(function(polygon) {
          settings.polygon = polygon;
          compareMap(settings);
        });
    } else {
      compareMap(settings);
    }
  </script>
  <?php return ob_get_clean();
}

add_shortcode( 'opendri_charts_compare_map', 'compare_map' );


function opendri_charts_script() {
 wp_register_script('opendri_charts_bundle', plugins_url('scripts/bundle.js', __FILE__) );
 wp_enqueue_script('opendri_charts_bundle');
}
add_action( 'wp_enqueue_scripts', 'opendri_charts_script' );
