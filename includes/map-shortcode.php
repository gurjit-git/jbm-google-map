<?php
//defined( 'ABSPATH' ) or die( 'Direct access not allowed!' );
function jbm_map_shortcode($atts){
	
	$atts = shortcode_atts( array(
		'id' => '',
		'text-align' => "",
		'margin' => "",
		'image-height' => "",
		'image-width' => "100%",
		'container-class' => ''
	), $atts, 'jbm_googlemap_shortcode' );

	$map_html = '';
	
	$entries = get_post_meta( $atts['id'], 'jbm_group_google_map', true );
	
	foreach ( (array) $entries as $key => $entry ) {
		
		if(isset( $entry['jbm_marker_title'] ) ){
			$title1 = esc_html( $entry['jbm_marker_title'] );
		}
		if(isset( $entry['jbm_marker_description'] ) ){
			$desc1 = $entry['jbm_marker_description'];
		}
		if(isset( $entry['jbm_ltd'] ) ){
			$ltd1 = esc_html( $entry['jbm_ltd'] );
		}
		if(isset( $entry['jbm_lng'] ) ){
			$lng1 = esc_html( $entry['jbm_lng'] );
		}
		if(isset( $entry['jbm_marker_image'] ) ){
			$img1 = esc_html( $entry['jbm_marker_image'] );
		}
	}
	
	$map_html .= '<div class="acf-map" style="width:100%; height:400px">';
	foreach ( (array) $entries as $key => $entry ) {
		
		if(isset( $entry['jbm_marker_title'] ) ){
			$title = esc_html( $entry['jbm_marker_title'] );
		}
		if(isset( $entry['jbm_marker_description'] ) ){
			$desc = $entry['jbm_marker_description'];
		}
		if(isset( $entry['jbm_ltd'] ) ){
			$ltd = esc_html( $entry['jbm_ltd'] );
		}
		if(isset( $entry['jbm_lng'] ) ){
			$lng = esc_html( $entry['jbm_lng'] );
		}
		if(isset( $entry['jbm_marker_image'] ) ){
			$img = esc_html( $entry['jbm_marker_image'] );
		}
		
		$map_html .= '<div class="marker"  data-lat="'.$ltd.'" data-lng="'.$lng.'" data-title="'.$title.'" data-icon="'.$img.'">'.$desc.'</div>';
	
	}
		
	$map_html .= '</div>';

	return $map_html;
}
?>