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
  <iframe id='{$map_id}' style='width:100%; height: 400px; border:0'></iframe>
  <script>
    var mbScriptContents = [
      "L.mapbox.accessToken = '{$MAPBOX_SIMPLE_APIKEY}';",
      "var map = L.mapbox.map('map', '{$layers}', {",
        "  minZoom: {$minZoom},",
        "  maxZoom: {$maxZoom},",
        "  scrollWheelZoom: {$scrollWheelZoom}",
        "})",
        ".setView([{$latitude}, {$longitude}], {$zoom});"
    ]
    var iframe = document.getElementById('{$map_id}');
    var html = document.createElement('html');
    var head = document.createElement('head');
    var mb = document.createElement('script');
    mb.src = 'https://api.mapbox.com/mapbox.js/v3.1.1/mapbox.js'
    var script = document.createElement('script');
    script.text = mbScriptContents.join('');
    var css = document.createElement('link');
    css.rel = 'stylesheet';
    css.href = 'https://api.mapbox.com/mapbox.js/v3.1.1/mapbox.css';
    var body = document.createElement('body');
    body.style = 'margin: 0';
    var div = document.createElement('div');
    div.style = 'width:100%; height: 400px';
    div.id = 'map';
    body.appendChild(div);
    html.appendChild(body);
    head.appendChild(mb);
    head.appendChild(script);
    head.appendChild(css);
    html.appendChild(head);

    iframe.contentWindow.document.open();
    iframe.contentWindow.document.write(html.outerHTML);
    iframe.contentWindow.document.close();


  </script>
EOD;
}

// example: [mapbox_map layers="gfdrr.map-wv1c9ry4,gfdrr.kathmandu-health" latitude="27.6934" longitude="85.3380" zoom="14" max_zoom="20"]
add_shortcode( 'mapbox_map', 'mapbox_map' );

?>
