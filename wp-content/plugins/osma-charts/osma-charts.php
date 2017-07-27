<?php
/**
 * Plugin Name: OSMA charts
 * Description: Allows adding charts to OSMA projects from the admin
 * Author: Vizzuality
 * Author URI: http://vizzuality.com
 */

require_once __DIR__ . '/osma-charts-settings.php';
$OSMA_API_SERVER = get_option('osma_api_settings_endpoint' );

function compare_map( $atts ) {
  global $OSMA_API_SERVER;
  ob_start(); ?>
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
      var settings = <?php echo json_encode($atts) ?>;
      settings.iframe_base_url = 'https://osm-analytics.vizzuality.com:442';
      if (settings.polygon === undefined) {
        var country = settings.country.toUpperCase() || 'HTI';
        fetch('<?php echo $OSMA_API_SERVER; ?>/meta/country_polyline/' + country)
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
  <?php return ob_get_clean();
}

function activity_chart( $atts ) {
  global $OSMA_API_SERVER;
  ob_start(); ?>
  <div id="activity-chart"></div>
  <script>
  (function() {
    window.document.body.classList.add('-has-osm-attribution');
    var settings = <?php echo json_encode($atts) ?>;
    var country = settings.country.toUpperCase() || 'HTI';
    fetch('<?php echo $OSMA_API_SERVER ?>/stats/all/country/' + country)
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
  <?php return ob_get_clean();
}


function contributor_chart( $atts ) {
  global $OSMA_API_SERVER;
  ob_start(); ?>
  <div id="contributor-chart" style="width: 50%"></div>
  <script>
  (function() {
    window.document.body.classList.add('-has-osm-attribution');
    var settings = <?php echo json_encode($atts) ?>;
    var country = settings.country.toUpperCase() || 'HTI';
    fetch('<?php echo $OSMA_API_SERVER ?>/stats/all/country/' + country)
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
  <?php return ob_get_clean();
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
