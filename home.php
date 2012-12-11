<?php

// Remove Page Title
remove_action( 'genesis_post_title', 'genesis_do_post_title' );

add_action( 'genesis_meta', 'sidecar_home_genesis_meta' );
/**
 * Add widget support for homepage. If no widgets active, display the default loop.
 */
function sidecar_home_genesis_meta() {

	if ( /*is_active_sidebar( 'home-headline' ) ||*/ is_active_sidebar( 'home-featured-picture' ) ) {
		remove_action( 'genesis_loop', 'genesis_do_loop' );
		add_action( 'genesis_loop', 'sidecar_home_loop_helper' );
		add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );
	}
}

function sidecar_home_loop_helper() {
	
	if ( is_active_sidebar( 'home-featured-picture' ) ) {
		
		echo '<div class="home-featured-picture">';
		dynamic_sidebar( 'home-featured-picture' );
		echo '</div><!-- end .home-featured-picture -->';
		
	}
	
	if ( is_active_sidebar( 'home-call-to-action' ) ) {
	
		echo '<div class="home-call-to-action">';
		dynamic_sidebar( 'home-call-to-action' );
		echo '</div><!-- end .home-call-to-action -->';
	}
	
	if ( is_active_sidebar( 'home-services' ) ) {
		
		echo '<div class="home-services">';
		dynamic_sidebar( 'home-services' );
		echo '</div><!-- end .home-services -->';
		
	}
	
	if ( is_active_sidebar( 'home-content' ) ) {
		
		echo '<div class="home-content">';
		dynamic_sidebar( 'home-content' );
		echo '</div><!-- end .home-content -->';
		
	}
}

genesis();