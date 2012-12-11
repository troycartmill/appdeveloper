<?php
/** Start the engine */
require_once( get_template_directory() . '/lib/init.php' );

/** Child theme (do not remove) */
define( 'CHILD_THEME_NAME', 'Project Theme' );
define( 'CHILD_THEME_URL', 'http://demo.sidecardesigns.com/' );

/** Start the engine */
require_once( TEMPLATEPATH.'/lib/init.php' );
if ( version_compare( PARENT_THEME_VERSION, '1.7.9', '>' ) ) {
	// Added Genesis Theme Settings
	include_once( CHILD_DIR . '/lib/functions/contact-form-settings.php' );
}

/** THEME SUPPORT
*******************************************/

/** Add support for custom background */
add_theme_support( 'custom-background' );

/** Add support for custom header **/
add_theme_support( 'genesis-custom-header', array( 'width' => 960, 'height' => 90 ) );

/** Add support for 4-column footer widgets */
add_theme_support( 'genesis-footer-widgets', 4 );

// Image Sizes
// add_image_size( 'featured', 400, 100, true );

/** Add support for structural wraps */
add_theme_support( 'genesis-structural-wraps', array(
    'header',
    'nav',
    'subnav',
    'inner',
    'footer-widgets',
    'footer'
) );

/** Add support for post formats */
add_theme_support( 'post-formats', array(
    'aside',
    'audio',
    'chat',
    'gallery',
    'image',
    'link',
    'quote',
    'status',
    'video'
) );

//Remove Primary and Secondary Nav
remove_action( 'genesis_after_header', 'genesis_do_nav' );
remove_action('genesis_after_header', 'genesis_do_subnav');
	
// Remove Unused User Settings
remove_action( 'show_user_profile', 'genesis_user_options_fields' );
remove_action( 'edit_user_profile', 'genesis_user_options_fields' );
remove_action( 'show_user_profile', 'genesis_user_archive_fields' );
remove_action( 'edit_user_profile', 'genesis_user_archive_fields' );
remove_action( 'show_user_profile', 'genesis_user_seo_fields' );
remove_action( 'edit_user_profile', 'genesis_user_seo_fields' );
remove_action( 'show_user_profile', 'genesis_user_layout_fields' );
remove_action( 'edit_user_profile', 'genesis_user_layout_fields' );

/** FUNCTIONS
*******************************************/

/** Load Google fonts */
add_action( 'wp_enqueue_scripts', 'sidecar_load_google_fonts' );
function sidecar_load_google_fonts() {
    wp_enqueue_style( 
        'google-fonts', 
        'http://fonts.googleapis.com/css?family=Merriweather|Open+Sans|Sanchez|Playfair+Display+SC|Ubuntu', 
        array(), 
        PARENT_THEME_VERSION 
     );
}

/** UNREGISTER GENESIS WIDGETS */
function remove_genesis_widgets() {
    unregister_widget( 'Genesis_Menu_Pages_Widget' );
    unregister_widget( 'Genesis_Widget_Menu_Categories' );
}
add_action( 'widgets_init', 'remove_genesis_widgets', 20 );

/**  Remove Metaboxes  */
function sidecar_remove_metaboxes( $_genesis_theme_settings_pagehook ) {
	remove_meta_box( 'genesis-theme-settings-nav', $_genesis_theme_settings_pagehook, 'main' );
}
add_action( 'genesis_theme_settings_metaboxes', 'sidecar_remove_metaboxes' );

/**
 * Customize Contact Methods
 * @since 1.0.0
 *
 * @author Bill Erickson
 * @link http://sillybean.net/2010/01/creating-a-user-directory-part-1-changing-user-contact-fields/
 *
 * @param array $contactmethods
 * @return array
 */
add_filter( 'user_contactmethods', 'sidecar_contactmethods' );
function sidecar_contactmethods( $contactmethods ) {
	unset( $contactmethods['aim'] );
	unset( $contactmethods['yim'] );
	unset( $contactmethods['jabber'] );
	
	return $contactmethods;
}

/** Customize the entire footer */
/*remove_action( 'genesis_footer', 'genesis_do_footer' );
add_action( 'genesis_footer', 'sidecar_do_footer' );
function sidecar_do_footer() {
    ?>
    <div class="creds">&copy; <?php echo date('Y'); ?> <a href="http://www.sidecardesigns.com/">Project Theme</a> on <a href="http://www.studiopress.com/">Genesis Framework</a> All Rights Reserved.
    </div>
    <div class="gototop">
    <a href="#" title="Return to top" id="return-top">Top</a>
    </div>
    <?php
}
*/

/** Add Navigation Menu as a widget in the bottom of Footer area */
add_action( 'genesis_footer', 'sidecar_footer_menu_widget' );
function sidecar_footer_menu_widget() {
	genesis_widget_area( 'footer-menu-widget', array('before' => '<div class="footer-menu-widget widget-area">' ) );
}

// Remove Edit link
add_filter( 'genesis_edit_post_link', '__return_false' );

/** Custom Registered Widgets */
genesis_register_sidebar( array(
	'id'			=> 'home-featured-picture',
	'name'			=> __( 'Home Featured Picture', 'sidecar' ),
	'description'	=> __( 'This is the Home Featured Picture on the homepage.', 'sidecar' ),
) );
genesis_register_sidebar( array(
	'id'			=> 'home-call-to-action',
	'name'			=> __( 'Home Call to Action', 'sidecar' ),
	'description'	=> __( 'This is the Call to Action at the top of the homepage.', 'sidecar' ),
) );
genesis_register_sidebar( array(
	'id'			=> 'home-services',
	'name'			=> __( 'Home Services', 'sidecar' ),
	'description'	=> __( 'This is the Home Services at the middle of the homepage.', 'sidecar' ),
) );
genesis_register_sidebar( array(
	'id'			=> 'home-content',
	'name'			=> __( 'Home Content', 'sidecar' ),
	'description'	=> __( 'This is the Home Content at the bottom of the homepage.', 'sidecar' ),
) );