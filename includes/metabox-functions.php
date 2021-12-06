<?php
/**
 * Include and setup custom metaboxes and fields. (make sure you copy this file to outside the CMB2 directory)
 *
 * Be sure to replace all instances of 'yourprefix_' with your project's prefix.
 * http://nacin.com/2010/05/11/in-wordpress-prefix-everything/
 *
 * @category YourThemeOrPlugin
 * @package  Demo_CMB2
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     https://github.com/CMB2/CMB2
 */

/**
 * Get the bootstrap! If using the plugin from wordpress.org, REMOVE THIS!
 */

if ( file_exists( dirname( __FILE__ ) . '/../metabox/init.php' ) ) {
	require_once dirname( __FILE__ ) . '/../metabox/init.php';
} elseif ( file_exists( dirname( __FILE__ ) . '/../metabox/init.php' ) ) {
	require_once dirname( __FILE__ ) . '/../metabox/init.php';
}

/**
 * Conditionally displays a metabox when used as a callback in the 'show_on_cb' cmb2_box parameter
 *
 * @param  CMB2 object $cmb CMB2 object.
 *
 * @return bool             True if metabox should show
 */
function jbm_show_if_front_page( $cmb ) {
	// Don't show this metabox if it's not the front page template.
	if ( get_option( 'page_on_front' ) !== $cmb->object_id ) {
		return false;
	}
	return true;
}

/**
 * Conditionally displays a field when used as a callback in the 'show_on_cb' field parameter
 *
 * @param  CMB2_Field object $field Field object.
 *
 * @return bool                     True if metabox should show
 */
function jbm_hide_if_no_cats( $field ) {
	// Don't show this field if not in the cats category.
	if ( ! has_tag( 'cats', $field->object_id ) ) {
		return false;
	}
	return true;
}

/**
 * Manually render a field.
 *
 * @param  array      $field_args Array of field arguments.
 * @param  CMB2_Field $field      The field object.
 */
function jbm_render_row_cb( $field_args, $field ) {
	$classes     = $field->row_classes();
	$id          = $field->args( 'id' );
	$label       = $field->args( 'name' );
	$name        = $field->args( '_name' );
	$value       = $field->escaped_value();
	$description = $field->args( 'description' );
	?>
	<div class="custom-field-row <?php echo esc_attr( $classes ); ?>">
		<p><label for="<?php echo esc_attr( $id ); ?>"><?php echo esc_html( $label ); ?></label></p>
		<p><input id="<?php echo esc_attr( $id ); ?>" type="text" name="<?php echo esc_attr( $name ); ?>" value="<?php echo $value; ?>"/></p>
		<p class="description"><?php echo esc_html( $description ); ?></p>
	</div>
	<?php
}

/**
 * Manually render a field column display.
 *
 * @param  array      $field_args Array of field arguments.
 * @param  CMB2_Field $field      The field object.
 */
function jbm_display_text_small_column( $field_args, $field ) {
	?>
	<div class="custom-column-display <?php echo esc_attr( $field->row_classes() ); ?>">
		<p><?php echo $field->escaped_value(); ?></p>
		<p class="description"><?php echo esc_html( $field->args( 'description' ) ); ?></p>
	</div>
	<?php
}

/**
 * Conditionally displays a message if the $post_id is 2
 *
 * @param  array             $field_args Array of field parameters.
 * @param  CMB2_Field object $field      Field object.
 */
function jbm_before_row_if_2( $field_args, $field ) {
	if ( 2 == $field->object_id ) {
		echo '<p>Testing <b>"before_row"</b> parameter (on $post_id 2)</p>';
	} else {
		echo '<p>Testing <b>"before_row"</b> parameter (<b>NOT</b> on $post_id 2)</p>';
	}
}

add_action( 'cmb2_admin_init', 'jbm_register_googlemap_group_field_metabox' );
/**
 * Hook in and add a metabox to demonstrate repeatable grouped fields
 */
function jbm_register_googlemap_group_field_metabox() {
	$prefix = 'jbm_group_';
	//if(isset($_GET['post'])){
		//$post_id = $_GET['post'];
	
	/**
	 * Repeatable Field Groups
	 */
	$cmb_group = new_cmb2_box( array(
		'id'           => $prefix . 'map_markers',
		'title'        => esc_html__( 'Info Window', 'cmb2' ),
		'object_types' => array( 'jbm_google_map' ),
	) );

	// $group_field_id is the field id string, so in this case: $prefix . 'demo'
	$group_field_id = $cmb_group->add_field( array(
		'id'          => $prefix . 'google_map',
		'type'        => 'group',
		'description' => esc_html__( '', 'cmb2' ),
		'options'     => array(
			'group_title'   => esc_html__( 'Marker {#}', 'cmb2' ), // {#} gets replaced by row number
			'add_button'    => esc_html__( 'Add Another Marker item', 'cmb2' ),
			'remove_button' => esc_html__( 'Remove Marker Item', 'cmb2' ),
			'sortable'      => true, // beta
		    'closed'     => true, // true to have the groups closed by default
		),
		'classes'    => 'jbm-group-class'

	) );

	/**
	 * Group fields works the same, except ids only need
	 * to be unique to the group. Prefix is not needed.
	 *
	 * The parent field's id needs to be passed as the first argument.
	 */
	$cmb_group->add_group_field( $group_field_id, array(
		'name'       => esc_html__( 'Title', 'cmb2' ),
		'id'         => 'jbm_marker_title',
		'type'       => 'text',
		'classes'    => 'jbm-group-class'
		// 'repeatable' => true, // Repeatable fields are supported w/in repeatable groups (for most types)
	) );

	$cmb_group->add_group_field( $group_field_id, array(
		'name'        => esc_html__( 'Description', 'cmb2' ),
		'description' => esc_html__( '', 'cmb2' ),
		'id'          => 'jbm_marker_description',
		'type'    => 'wysiwyg',
		'options' => array(
			'textarea_rows' => 3,
		),
		'classes'    => 'jbm-group-class'
	) );
	
	$cmb_group->add_group_field( $group_field_id, array(
		'name'       => esc_html__( 'Latitude', 'cmb2' ),
		'id'         => 'jbm_ltd',
		'type'       => 'text',
		'classes'    => 'jbm-group-class'
		// 'repeatable' => true, // Repeatable fields are supported w/in repeatable groups (for most types)
	) );
	
	$cmb_group->add_group_field( $group_field_id, array(
		'name'       => esc_html__( 'Longitude', 'cmb2' ),
		'id'         => 'jbm_lng',
		'type'       => 'text',
		'classes'    => 'jbm-group-class'
		// 'repeatable' => true, // Repeatable fields are supported w/in repeatable groups (for most types)
	) );

	$cmb_group->add_group_field( $group_field_id, array(
		'name' => esc_html__( 'Marker Image', 'cmb2' ),
		'id'   => 'jbm_marker_image',
		'type' => 'file',
		'preview_size' => array( 50, 50 ), // Default: array( 50, 50 )
		'classes'    => 'jbm-group-class'
	) );
	
	$cmb_demo = new_cmb2_box( array(
		'id'            => $prefix . 'display_googlemap_shorcode',
		'title'         => esc_html__( 'Shortcode', 'cmb2' ),
		'object_types'  => array( 'jbm_google_map' ), // Post type
		// 'show_on_cb' => 'yourprefix_show_if_front_page', // function should return a bool value
		// 'context'    => 'normal',
		// 'priority'   => 'high',
		// 'show_names' => true, // Show field names on the left
		// 'cmb_styles' => false, // false to disable the CMB stylesheet
		// 'closed'     => true, // true to keep the metabox closed by default
		// 'classes'    => 'extra-class', // Extra cmb2-wrap classes
		// 'classes_cb' => 'yourprefix_add_some_classes', // Add classes through a callback.
	) );
	if(isset($_GET['post'])){
		$cmb_demo->add_field( array(
			//'name'       => esc_html__( '', 'cmb2' ),
			//'desc'       => esc_html__( '', 'cmb2' ),
			'id'         => $prefix . 'readonly',
			'type'       => 'text',
			'default'    => esc_attr__( '[jbm_googlemap_shortcode id="'.$_GET['post'].'"]', 'cmb2' ),
			'save_field' => false, // Disables the saving of this field.
			'attributes' => array(
				//'disabled' => 'disabled',
				'readonly' => 'readonly',
			),
		) );
	}
//}
}
add_action( 'cmb2_admin_init', 'jbm_register_googlemap_group_field_options' );
/**
 * Hook in and register a metabox to handle a theme options page and adds a menu item.
 */
function jbm_register_googlemap_group_field_options() {

	/**
	 * Registers options page menu item and form.
	 */
	$cmb_options = new_cmb2_box( array(
		'id'           => 'jbm_googlemap_options_page',
		'title'        => esc_html__( 'Settings', 'cmb2' ),
		'object_types' => array( 'options-page' ),

		/*
		 * The following parameters are specific to the options-page box
		 * Several of these parameters are passed along to add_menu_page()/add_submenu_page().
		 */

		'option_key'      => 'jbm_google_map_options', // The option key and admin menu page slug.
		'icon_url'        => 'dashicons-palmtree', // Menu icon. Only applicable if 'parent_slug' is left empty.
		// 'menu_title'      => esc_html__( 'Options', 'cmb2' ), // Falls back to 'title' (above).
		'parent_slug'     => 'edit.php?post_type=jbm_google_map', // Make options page a submenu item of the themes menu.
		// 'capability'      => 'manage_options', // Cap required to view options-page.
		// 'position'        => 1, // Menu position. Only applicable if 'parent_slug' is left empty.
		// 'admin_menu_hook' => 'network_admin_menu', // 'network_admin_menu' to add network-level options page.
		// 'display_cb'      => false, // Override the options-page form output (CMB2_Hookup::options_page_output()).
		// 'save_button'     => esc_html__( 'Save Theme Options', 'cmb2' ), // The text for the options-page save button. Defaults to 'Save'.
		// 'disable_settings_errors' => true, // On settings pages (not options-general.php sub-pages), allows disabling.
	) );

	/**
	 * Options fields ids only need
	 * to be unique within this box.
	 * Prefix is not needed.
	 */
	$cmb_options->add_field( array(
		'name'       => esc_html__( 'Google Map API', 'cmb2' ),
		'id'         => 'jbm_google_map',
		'type'       => 'text',
		//'classes'    => 'jbm-group-class'
		// 'repeatable' => true, // Repeatable fields are supported w/in repeatable groups (for most types)
	) );

}
