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

add_action('init', 'wp_ois_custom_rewrite_basic');
function wp_ois_custom_rewrite_basic() {
  add_rewrite_rule('community-mapping-guide', 'http://gfdrr.github.io/community-mapping/', 'top');
  add_rewrite_rule('resources', 'http://gfdrr.github.io/resource/', 'top');
}

function wp_ois_custom_plugin_activate() {
  wp_ois_custom_rewrite_basic();
  flush_rewrite_rules();
 }

 function wp_ois_custom_plugin_deactivate() {
  flush_rewrite_rules();
 }

 register_activation_hook(__FILE__, 'wp_ois_custom_plugin_activate');
 //register deactivation function
 register_deactivation_hook(__FILE__, 'wp_ois_custom_plugin_deactivate');
 //add rewrite rules in case another plugin flushes rules
