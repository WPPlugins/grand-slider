<?php 

function get_plugin_data_gs( $plugin_file, $markup = true, $translate = true ) {

	$default_headers = array(
		'Name' => 'Plugin Name',
		'PluginURI' => 'Plugin URI',
		'Version' => 'Version',
		'Description' => 'Description',
		'Author' => 'Author',
		'AuthorURI' => 'Author URI',
		'TextDomain' => 'Text Domain',
		'DomainPath' => 'Domain Path',
		'Network' => 'Network',
		// Site Wide Only is deprecated in favor of Network.
		'_sitewide' => 'Site Wide Only',
	);

	$plugin_data = get_file_data( $plugin_file, $default_headers, 'plugin' );

	// Site Wide Only is the old header for Network
	if ( empty( $plugin_data['Network'] ) && ! empty( $plugin_data['_sitewide'] ) ) {
		_deprecated_argument( __FUNCTION__, '3.0', sprintf( __( 'The <code>%1$s</code> plugin header is deprecated. Use <code>%2$s</code> instead.' ), 'Site Wide Only: true', 'Network: true' ) );
		$plugin_data['Network'] = $plugin_data['_sitewide'];
	}
	$plugin_data['Network'] = ( 'true' == strtolower( $plugin_data['Network'] ) );
	unset( $plugin_data['_sitewide'] );

	// For backward compatibility by default Title is the same as Name.
	$plugin_data['Title'] = $plugin_data['Name'];

	if ( $markup || $translate )
		$plugin_data = _get_plugin_data_gs_markup_translate_gs( $plugin_file, $plugin_data, $markup, $translate );
	else
		$plugin_data['AuthorName'] = $plugin_data['Author'];

	return $plugin_data;
}

function _get_plugin_data_gs_markup_translate_gs($plugin_file, $plugin_data, $markup = true, $translate = true) {

	//Translate fields
	if ( $translate && ! empty($plugin_data['TextDomain']) ) {
		if ( ! empty( $plugin_data['DomainPath'] ) )
			load_plugin_textdomain($plugin_data['TextDomain'], false, dirname($plugin_file). $plugin_data['DomainPath']);
		else
			load_plugin_textdomain($plugin_data['TextDomain'], false, dirname($plugin_file));

		foreach ( array('Name', 'PluginURI', 'Description', 'Author', 'AuthorURI', 'Version') as $field )
			$plugin_data[ $field ] = translate($plugin_data[ $field ], $plugin_data['TextDomain']);
	}

	$plugins_allowedtags = array(
		'a'       => array( 'href' => array(), 'title' => array() ),
		'abbr'    => array( 'title' => array() ),
		'acronym' => array( 'title' => array() ),
		'code'    => array(),
		'em'      => array(),
		'strong'  => array(),
	);

	$plugin_data['AuthorName'] = $plugin_data['Author'] = wp_kses( $plugin_data['Author'], $plugins_allowedtags );

	//Apply Markup
	if ( $markup ) {
		if ( ! empty($plugin_data['PluginURI']) && ! empty($plugin_data['Name']) )
			$plugin_data['Title'] = '<a href="' . $plugin_data['PluginURI'] . '" title="' . esc_attr__( 'Visit plugin homepage' ) . '">' . $plugin_data['Name'] . '</a>';
		else
			$plugin_data['Title'] = $plugin_data['Name'];

		if ( ! empty($plugin_data['AuthorURI']) && ! empty($plugin_data['Author']) )
			$plugin_data['Author'] = '<a href="' . $plugin_data['AuthorURI'] . '" title="' . esc_attr__( 'Visit author homepage' ) . '">' . $plugin_data['Author'] . '</a>';

		$plugin_data['Description'] = wptexturize( $plugin_data['Description'] );
		if ( ! empty($plugin_data['Author']) )
			$plugin_data['Description'] .= ' <cite>' . sprintf( __('By %s'), $plugin_data['Author'] ) . '.</cite>';
	}

	// Sanitize all displayed data. Author and AuthorName sanitized above.
	$plugin_data['Title']       = wp_kses( $plugin_data['Title'],       $plugins_allowedtags );
	$plugin_data['Version']     = wp_kses( $plugin_data['Version'],     $plugins_allowedtags );
	$plugin_data['Description'] = wp_kses( $plugin_data['Description'], $plugins_allowedtags );
	$plugin_data['Name']        = wp_kses( $plugin_data['Name'],        $plugins_allowedtags );

	return $plugin_data;
}

?>