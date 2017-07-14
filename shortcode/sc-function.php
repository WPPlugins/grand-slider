<?php
/**
 * TinyMCE Plugin
 * Package: Gumaraphous
 * http://zourbuth.com
 * Version 0.1
 */
 
/** Button informations **/
function grand_slider_addbuttons() {
	// Add only in Rich Editor mode
	if ( get_user_option('rich_editing') == 'true') {
	// add the button for wp25 in a new way
		add_filter("mce_external_plugins", "add_grand_slider_tinymce_plugin", 5);
		add_filter('mce_buttons', 'register_grand_slider_button', 5);
	}
}

/** Let register this button **/
function register_grand_slider_button($buttons) {
	array_push($buttons, "separator", "gsld");
	return $buttons;
}

/** Load the TinyMCE plugin **/
function add_grand_slider_tinymce_plugin($plugin_array) {
	$plugin_array['gsld'] = GRAND_SLIDER_URL . 'shortcode/editor_plugin.js';	
	return $plugin_array;
}

/** Change the TinyMCE version **/
function grand_slider_change_tinymce_version($version) {
	return ++$version;
}

/** Modified the version when TinyMCE plugins are changed **/
add_filter('tiny_mce_version', 'grand_slider_change_tinymce_version');

/** Flow this with init action **/
add_action('init', 'grand_slider_addbuttons');
?>