<?php
/*
Plugin Name: Extend WordPress Upload
Plugin URI: http://bordoni.me/wp/plugins/extend-upload
Version: 0.0.1
Description: A WordPress plugin to Extend the default WordPress upload
Author: Quatix
Author URI: http://www.quatix.com.br
Text Domain: eup
Domain Path: /lang
License: GNU General Public License 2.0 (GPL) http://www.gnu.org/licenses/gpl.html
*/

if ( version_compare(PHP_VERSION, '5.2', '<') ) {
	if ( is_admin() && (!defined('DOING_AJAX') || !DOING_AJAX) ) {
		require_once ABSPATH.'/wp-admin/includes/plugin.php';
		deactivate_plugins( __FILE__ );
		wp_die( __('To install Extend Upload, your server must have at least PHP version 5.2, as WordPress 3.2 requires.'), __( 'Error While installing Extend Upload' ), array( 'back_link' => true ) );
	} else {
		return;
	}
}

add_action( 'init', function() {
	$pluginurl = plugins_url() . "/" . basename( dirname(__FILE__) );
	if ( preg_match( '/^https/', $pluginurl ) && !preg_match( '/^https/', get_bloginfo('url') ) )
		$pluginurl = preg_replace( '/^https/', 'http', $pluginurl );

	wp_register_script( 'extend-upload', $pluginurl . "/js/extend-upload.js", array( 'json2', 'jquery', 'thickbox', 'media-upload' ), '0.0.1', true );
	wp_register_style( 'extend-upload', $pluginurl . "/css/extend-upload.css", array( 'thickbox' ), '0.0.1', 'screen' );
}, 5 );

add_action( 'image_send_to_editor', function( $html, $id, $caption, $title, $align, $url, $size, $alt ) {
	$html = str_replace( 'src="' , 'data=\'' . json_encode( array( 'id'=>$id ) ) . '\' src="', $html );
	return $html;
}, 10, 8 );