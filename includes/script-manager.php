<?php 
/**
 * Enqueue scripts and styles.
*/

function regular_posts_element_scripts(){

    wp_enqueue_style('regular-posts-element', plugins_url('../assets/css/frontend/regular-posts-element.css', __FILE__ )); 
    
}
add_action('wp_enqueue_scripts','regular_posts_element_scripts');