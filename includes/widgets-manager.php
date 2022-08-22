<?php 

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Register new Elementor widgets.
 *
 * @param \Elementor\Widgets_Manager $widgets_manager Elementor widgets manager.
 * @return void
 */
function register_new_regular_posts_element_widgets( $widgets_manager ) {

   //Image List Box
   require_once( __DIR__ . '/widgets/regular-posts-element.php' );

   $widgets_manager->register( new \Regular_Posts_Element() );

}
add_action( 'elementor/widgets/register', 'register_new_regular_posts_element_widgets' );

?>