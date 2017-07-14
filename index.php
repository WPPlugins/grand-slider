<?php
/*
Plugin Name: Grand Slider
Plugin URI: http://zourbuth.com/plugins/grand-slider
Description: A powerful plugin to display your content with slides in some attractive animations. Easy setup and not hard to config. Build with visual shortcode to help you create animation content and effects. This plugin comes with the slides post type and support another post type to diplay with the slides. You can embed videos, images or content to each slide. Grand and luxurious slider is created to display your important events.
Version: 1.0.2
Author: zourbuth
Author URI: http://zourbuth.com
License: GPL2
*/

/*  Copyright 2011  zourbuth.com  (email : zourbuth@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

/* Launch the plugin. */
add_action( 'plugins_loaded', 'grand_slider_plugins_loaded' );

/* Initializes the plugin and it's features. */
function grand_slider_plugins_loaded() {

	/* Set constant path to the members plugin directory. */
	define( 'GRAND_SLIDER_DIR', plugin_dir_path( __FILE__ ) );
	define( 'GRAND_SLIDER_URL', plugin_dir_url( __FILE__ ) );
	
	/* Create the grand slides post type */
	require_once( GRAND_SLIDER_DIR . 'grand-slides.php' );

	/* Load slider file */
	require_once( GRAND_SLIDER_DIR . 'grand-slider.php' );
	require_once( GRAND_SLIDER_DIR . 'shortcode/sc-function.php' );
	
	/* Load the script and style for slider. */
	if ( !is_admin() ) {
		wp_enqueue_style("grand-slider", GRAND_SLIDER_URL . "css/grand-slider.css");
		wp_enqueue_script( 'jquery' );
		wp_register_script( 'grand-easing', GRAND_SLIDER_URL .'js/jquery.easing.1.3.js' );
		wp_enqueue_script( 'grand-easing' );
		wp_register_script( 'grand-slider', GRAND_SLIDER_URL .'js/jquery.grandSlider.min.js' );
		wp_enqueue_script( 'grand-slider' );
	}
}

function grand_slider_extract_attr($atts) {
	if ( is_array($atts) )
		foreach ( $atts as $att )
			$style .= ' ' . $att;

	return $style;
}

function grand_slider_excerpt( $str, $length, $minword = 3 ) {
    $sub = '';
    $len = 0;
    
    foreach (explode(' ', $str) as $word) {
        $part = (($sub != '') ? ' ' : '') . $word;
        $sub .= $part;
        $len += strlen($part);
        
        if (strlen($word) > $minword && strlen($sub) >= $length)
            break;
    }
    
    return $sub . (($len < strlen($str)) ? '...' : '');
}
?>