<?php
defined( 'ABSPATH' ) or die( 'Direct access not allowed!' );
function jmb_googlemap_custom_post_type() {
 
// Set UI labels for Custom Post Type
    $labels = array(
        'name'                => _x( 'Google Map', 'Post Type General Name', 'twentythirteen' ),
        'singular_name'       => _x( 'Google Map', 'Post Type Singular Name', 'twentythirteen' ),
        'menu_name'           => __( 'Google Maps', 'twentythirteen' ),
        //'parent_item_colon'   => __( 'Parent Movie', 'twentythirteen' ),
        'all_items'           => __( 'All Google Maps', 'twentythirteen' ),
        //'view_item'           => __( 'View Carousels', 'twentythirteen' ),
        'add_new_item'        => __( 'Add Google Map', 'twentythirteen' ),
        'add_new'             => __( 'Add New', 'twentythirteen' ),
        'edit_item'           => __( 'Edit Map', 'twentythirteen' ),
        'update_item'         => __( 'Update Map', 'twentythirteen' ),
        'search_items'        => __( 'Search Map', 'twentythirteen' ),
        'not_found'           => __( 'Not Found', 'twentythirteen' ),
        'not_found_in_trash'  => __( 'Not found in Trash', 'twentythirteen' ),
    );
     
// Set other options for Custom Post Type
     
    $args = array(
        'label'               => __( 'jbm-google-map', 'twentythirteen' ),
        'description'         => __( 'Google Map', 'twentythirteen' ),
        'labels'              => $labels,
        // Features this CPT supports in Post Editor
        'supports'            => array( 'title'),
        // You can associate this CPT with a taxonomy or custom taxonomy. 
       // 'taxonomies'          => array( 'genres' ),
        /* A hierarchical CPT is like Pages and can have
        * Parent and child items. A non-hierarchical CPT
        * is like Posts.
        */ 
        'hierarchical'        => false,
        'public'              => false,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 2,
        'can_export'          => true,
        'has_archive'         => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'capability_type'     => 'post',
    );
     
    // Registering your Custom Post Type
    register_post_type( 'jbm_google_map', $args );
 
}
 
/* Hook into the 'init' action so that the function
* Containing our post type registration is not 
* unnecessarily executed. 
*/
 
add_action( 'init', 'jmb_googlemap_custom_post_type', 0 );

function viswong_custom_capabilities( $args, $post_type_name ) {

	// If you only want this to apply to certain post types.
	// Change "SOMETHING" to the actual slug used.
	if ( 'jbm_google_map' === $post_type_name ) {
		$args['capabilities'] = array(
			'create_posts' => 'do_not_allow',
		);
	}

	return $args;
}
add_filter( 'cptui_pre_register_post_type', 'viswong_custom_capabilities', 10, 2 );

?>