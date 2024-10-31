<?php

/**
Plugin Name: PopUp Everything
Description: PopUp Everything plugin lets you display content within a little area on your website. Great for contact information or contact forms.
Author: mrommel
Contributers: mrommel, mathiasholmbo
Author URI: https://rommel.dk
Version: 1.0.1
*/

/**
 * Load plugin textdomain.
 */
add_action( 'plugins_loaded', 'popup_everything_translation' );
function popup_everything_translation() {
	load_plugin_textdomain( 'popup-everything', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
}

/**
 * Register styles and scripts
 */
add_action('wp_footer', 'popup_everything_styles_scripts');
function popup_everything_styles_scripts() {

	wp_register_style('popup-everything', plugins_url('assets/css/popup-everything.css', __FILE__), array(), null, 'all');
	wp_print_styles('popup-everything');
}

/**
 * Load the guts of the plugin.
 */
require_once( __DIR__ . '/includes/options.php' );
require_once( __DIR__ . '/includes/template.php' );
