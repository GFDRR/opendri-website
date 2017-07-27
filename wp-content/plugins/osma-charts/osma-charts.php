<?php
/**
 * Plugin Name: OSMA charts
 * Description: Allows adding charts to OSMA projects from the admin
 * Author: Vizzuality
 * Author URI: http://vizzuality.com
 */

require_once __DIR__ . '/osma-charts-settings.php';
$OSMA_API_ENDPOINT_ADDRESS = get_option('osma_api_endpoint_address' );
$OSMA_SITE_ADDRESS = get_option('osma_site_address' );

function compare_map( $atts ) {
  global $OSMA_API_ENDPOINT_ADDRESS;
  global $OSMA_SITE_ADDRESS;
  $atts_encode = json_encode($atts);
  
  return <<<EOD
  <div id="compare-map" class="compare-map"></div>
  <script>
    (function() {
      window.document.body.classList.add('-has-osm-attribution');
      function compareMap(settings) {
        ODRI.compareMap('#compare-map', {
          width: '100%',
          height: '500px',
          settings: settings
        });
      }
      var settings = {$atts_encode};
      settings.iframe_base_url = '{$OSMA_SITE_ADDRESS}';
      if (settings.polygon === undefined) {
        var country = settings.country.toUpperCase() || 'HTI';
        fetch('{$OSMA_API_ENDPOINT_ADDRESS}/meta/country_polyline/' + country)
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
    })()
  </script>
EOD;
}

function activity_chart( $atts ) {
  global $OSMA_API_ENDPOINT_ADDRESS;
  $atts_encode = json_encode($atts);
  
  return <<<EOD
  <div id="activity-chart"></div>
  <script>
  (function() {
    window.document.body.classList.add('-has-osm-attribution');
    var settings = {$atts_encode};
    var country = settings.country.toUpperCase() || 'HTI';
    fetch('{$OSMA_API_ENDPOINT_ADDRESS}/stats/all/country/' + country)
      .then(function(response) {
        return response.json();
      })
      .then(function(data) {
        ODRI.activity('#activity-chart', {
          data: data,
          granularity: settings.default_granularity,
          facet: settings.default_facet,
          range: [settings.start_date, settings.end_date]
        })
      });
  })()
  </script>
EOD;
}


function contributor_chart( $atts ) {
  global $OSMA_API_ENDPOINT_ADDRESS;
  $atts_encode = json_encode($atts);
  return <<<EOD
  <div id="contributor-chart" style="width: 50%"></div>
  <script>
  (function() {
    window.document.body.classList.add('-has-osm-attribution');
    var settings = {$atts_encode};
    var country = settings.country.toUpperCase() || 'HTI';
    fetch('{$OSMA_API_ENDPOINT_ADDRESS}/stats/all/country/' + country)
      .then(function(response) {
        return response.json();
      })
      .then(function(data) {
        ODRI.contributors('#contributor-chart', {
          data: data,
          range: [settings.start_date, settings.end_date]
        })
      });
  })()
  </script>
EOD;
}

add_shortcode( 'osma_charts_compare_map', 'compare_map' );
add_shortcode( 'osma_charts_activity', 'activity_chart' );
add_shortcode( 'osma_charts_contributors', 'contributor_chart' );


function osma_charts_script() {
   wp_register_script('osma_charts_bundle', plugins_url('scripts/bundle.js', __FILE__) );
   wp_enqueue_script('osma_charts_bundle');
   wp_register_style('osma_charts_styles', plugins_url('styles/styles.css', __FILE__) );
   wp_enqueue_style('osma_charts_styles');
}

add_action( 'wp_enqueue_scripts', 'osma_charts_script' );
