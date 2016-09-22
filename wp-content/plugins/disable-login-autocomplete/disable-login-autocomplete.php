<?php
/**
 * Plugin Name: GFDRR OPENDRI custom
 * Description: Remove login autocomplete and add OIS-required headers.
 * Version: 0.1
 * Author: Morbus Iff
 */

add_action('login_init', 'acme_autocomplete_login_init');
function acme_autocomplete_login_init() {
  ob_start();
}

add_action('login_form', 'acme_autocomplete_login_form');
function acme_autocomplete_login_form() {
  $content = ob_get_contents();
  ob_end_clean();

  echo str_replace('id="user_pass"', 'id="user_pass" autocomplete="off"', $content);
}

add_filter('wp_headers', 'wp_ois_custom_headers');
function wp_ois_custom_headers($headers) {
  $headers['X-Frame-Options'] = 'SAMEORIGIN';
  $headers['Cache-Control'] = 'no-cache, no-store';
  return $headers;
}

add_filter('nocache_headers', 'wp_ois_custom_nocache_headers');
function wp_ois_custom_nocache_headers($headers) {
  $headers['Cache-Control'] = 'no-cache, no-store';
  return $headers;
}
