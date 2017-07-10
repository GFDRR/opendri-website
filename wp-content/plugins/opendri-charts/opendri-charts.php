<?php
/**
 * Plugin Name: OpenDRI charts
 * Description: Allows adding charts to OpenDRI projects from the admin
 * Author: Vizzuality
 * Author URI: http://vizzuality.com
 */
$ODRI_API_SERVER = "http://54.224.10.82/api/v1";
$ODRI_MOCK_DATA = "http://localhost:8080/mocks/histogram-features-hti.json";

function compare_map( $atts ) {
  global $ODRI_API_SERVER;
  global $ODRI_MOCK_DATA;
  ob_start(); ?>
  <div id="compare-map"></div>
  <script>
    (function() {
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
        fetch('<?php echo $ODRI_API_SERVER; ?>/meta/country_polyline/' + country)
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
  global $ODRI_API_SERVER;
  global $ODRI_MOCK_DATA;
  ob_start(); ?>
  <div id="activity-chart"></div>
  <script>
  (function() {
    var settings = <?php echo json_encode($atts) ?>;
    var country = settings.country.toUpperCase() || 'HTI';
    // fetch('<?php echo $ODRI_API_SERVER ?>/stats/all/country/' + country)
    fetch('<?php echo $ODRI_MOCK_DATA ?>')
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
  global $ODRI_API_SERVER;
  global $ODRI_MOCK_DATA;
  ob_start(); ?>
  <div id="contributor-chart" style="width: 50%"></div>
  <script>
  (function() {
    var settings = <?php echo json_encode($atts) ?>;
    var country = settings.country.toUpperCase() || 'HTI';
    // fetch('<?php echo $ODRI_API_SERVER ?>/stats/all/country/' + country)
    fetch('<?php echo $ODRI_MOCK_DATA ?>')
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

add_shortcode( 'opendri_charts_compare_map', 'compare_map' );
add_shortcode( 'opendri_charts_activity', 'activity_chart' );
add_shortcode( 'opendri_charts_contributors', 'contributor_chart' );

function opendri_charts_script() {
   wp_register_script('opendri_charts_bundle', plugins_url('scripts/bundle.js', __FILE__) );
   wp_enqueue_script('opendri_charts_bundle');
   wp_register_style('opendri_charts_styles', plugins_url('styles/styles.css', __FILE__) );
   wp_enqueue_style('opendri_charts_styles');
}

add_action( 'wp_enqueue_scripts', 'opendri_charts_script' );
