<?php
/**
 * Plugin Name: OpenDRI charts
 * Description: Allows adding charts to OpenDRI projects from the admin
 * Author: Vizzuality
 * Author URI: http://vizzuality.com
 */

 function compare_map() {
   ob_start(); ?>
   <div id="compare-map"></div>
   <script>
   ODRI.compareMap('#compare-map', {
     width: '100%',
     height: '500px',
     settings: {
       iframeBaseUrl: 'http://localhost:3000',
       defaultFeatureType: 'highways'
     }
   })
   </script>
   <?php	return ob_get_clean();
 }
 add_shortcode( 'opendri_charts_compare_map', 'compare_map' );


 function opendri_charts_script() {
   wp_register_script('opendri_charts_bundle', plugins_url('scripts/bundle.js', __FILE__) );
   wp_enqueue_script('opendri_charts_bundle');
 }
 add_action( 'wp_enqueue_scripts', 'opendri_charts_script' );
