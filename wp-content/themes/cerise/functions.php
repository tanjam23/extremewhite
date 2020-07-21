<?php
add_action('wp_enqueue_scripts', 'cerise_removeScripts' , 20);
function cerise_removeScripts() {
	$parent_style = 'parent-style';
    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
//De-Queuing Styles sheet 
wp_dequeue_style( 'flat-blue',get_template_directory_uri() .'/css/skins/flat-blue.css'); 
//EN-Queing Style sheet 
wp_enqueue_style('lite-brown', get_stylesheet_directory_uri() . '/css/skins/pink.css');
}


add_action( 'after_setup_theme', 'cerise_setup' ); 	
	function cerise_setup()
	{
	add_theme_support( 'title-tag' );
	}
?>