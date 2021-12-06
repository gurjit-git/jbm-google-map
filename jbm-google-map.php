<?php
/*
Plugin Name: JBM Google Map
Plugin URI: http://wordpress.org/
Description: This is a Google Map plugin
Author: Gurjit Singh
Version: 1.0
Author URI: http://gurjitsingh.com
*/
defined( 'ABSPATH' ) or die( 'Direct access not allowed!' );
define( 'JBM_GOOGLEMAP_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );

include(JBM_GOOGLEMAP_PLUGIN_PATH.'includes/googlemap-post-type.php');
include(JBM_GOOGLEMAP_PLUGIN_PATH.'includes/metabox-functions.php');
include(JBM_GOOGLEMAP_PLUGIN_PATH.'includes/map-shortcode.php');
add_shortcode('jbm_googlemap_shortcode','jbm_map_shortcode');

function jbm_include_gooogle_map_css_js(){
	
	$jbm_google_map_options = get_option( 'jbm_google_map_options' );
	
    wp_enqueue_style( 'jmb_google_map_css', plugins_url('/assets/css/style.css', __FILE__), false, '1.0.0', 'all');
	
	wp_enqueue_script( 'jbm-newscript', plugins_url( '/assets/js/jquery.min.js' , __FILE__ ), array( 'jquery' ), '1.0.0', true  );
	
	//wp_enqueue_script('js-google_map_markerclusterer', 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js');
	
	wp_enqueue_script('js-google', '//maps.googleapis.com/maps/api/js?key='.$jbm_google_map_options['jbm_googlemap_api'].'&callback=initMap', null, null);
	
	wp_enqueue_script( 'jbm-custom-script', plugins_url( '/assets/js/custom.js' , __FILE__ ), array( 'jquery' ), '1.0.0', true  );

}
add_action('wp_enqueue_scripts', "jbm_include_gooogle_map_css_js");

function jbm_gooogle_map_load_custom_wp_admin_style() {
        wp_register_style( 'custom_wp_admin_css', plugins_url('/assets/css/admin/custom.css', __FILE__), false, '1.0.0', 'all' );
        wp_enqueue_style( 'custom_wp_admin_css' );
}
add_action( 'admin_enqueue_scripts', 'jbm_gooogle_map_load_custom_wp_admin_style' );