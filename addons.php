<?php
/**
 * Plugin Name: Regular Posts Element For Elementor
 * Description: Regular Posts Element is a custom extension of Elementor.
 * Plugin URI:  https://github.com/mdnesarmridha/regular-posts-element-for-elementor
 * Version:     1.0.1
 * Author:      MD.NESAR MRIDHA
 * Author URI:  https://devnesar.com/
 * Text Domain: regular-posts-element
 * 
 * Elementor tested up to:     3.7.0
 * Elementor Pro tested up to: 3.7.0
 * 
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

function Regular_Posts_Element_For_Elementor_loaded() {

	// Load plugin file
	require_once( __DIR__ . '/includes/plugin.php' );

	// Run the plugin
	\Regular_Posts_Element_For_Elementor\Plugin::instance();



}
add_action( 'plugins_loaded', 'Regular_Posts_Element_For_Elementor_loaded' );