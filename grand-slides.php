<?php
/**
    Grand Slides Function
`																																																					/-096543-974
    @package zourbuth
    @subpackage Template
 
    Copyright 2011  zourbuth.com  (email : zourbuth@gmail.com)

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

function grand_slider_post_type_init() {
	$labels = array(
    	'name' => _x('Grand Slides', 'post type general name'),
    	'singular_name' => _x('Grand Slides', 'post type singular name'),
    	'add_new' => _x('Add New Slide', 'book'),
    	'add_new_item' => __('Add New Slide'),
    	'edit_item' => __('Edit Slide'),
    	'new_item' => __('New Slide'),
    	'view_item' => __('View Slide'),
    	'search_items' => __('Search Slides'),
    	'not_found' =>  __('No slide found'),
    	'not_found_in_trash' => __('No slides found in Trash'),
    	'parent_item_colon' => ''
	);		
	$args = array(
    	'labels' => $labels,
    	'public' => true,
    	'publicly_queryable' => true,
    	'show_ui' => true, 
    	'query_var' => true,
    	'rewrite' => true,
    	'capability_type' => 'post',
    	'hierarchical' => false,
    	'menu_position' => null,
    	'supports' => array('title','editor', 'thumbnail', 'custom-fields'),
	); 		

	register_post_type( 'grand_slides', $args );
}
add_action('init', 'grand_slider_post_type_init');
?>