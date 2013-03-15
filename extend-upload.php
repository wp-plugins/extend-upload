<?php
/*
Plugin Name: Extend WordPress Upload
Plugin URI: http://bordoni.me/wp/plugins/extend-upload
Version: 0.0.4
Description: A WordPress plugin to Extend the default WordPress upload
Author: Gustavo Bordoni
Author URI: http://bordoni.me/
Text Domain: extup
Domain Path: /lang
License: GNU General Public License 2.0 (GPL) http://www.gnu.org/licenses/gpl.html
*/

if ( version_compare(PHP_VERSION, '5.2', '<') ) {
	if ( is_admin() && (!defined('DOING_AJAX') || !DOING_AJAX) ) {
		require_once ABSPATH.'/wp-admin/includes/plugin.php';
		deactivate_plugins( __FILE__ );
		wp_die( __('To install Extend Upload, your server must have at least PHP version 5.2, as WordPress 3.2 requires.', 'extup' ), __( 'Error While installing Extend Upload', 'extup' ), array( 'back_link' => true ) );
	} else {
		return;
	}
}

add_action( 'init', function() {
	$pluginurl = plugins_url() . "/" . basename( dirname(__FILE__) );
	if ( preg_match( '/^https/', $pluginurl ) && !preg_match( '/^https/', get_bloginfo('url') ) )
		$pluginurl = preg_replace( '/^https/', 'http', $pluginurl );

	wp_register_script( 'extend-upload', $pluginurl . "/js/extend-upload.js", array( 'json2', 'jquery', 'thickbox', 'media-upload' ), '0.0.3', true );
	wp_register_style( 'extend-upload', $pluginurl . "/css/extend-upload.css", array( 'thickbox' ), '0.0.3', 'screen' );
}, 5 );

add_filter( 'media_send_to_editor', function( $html, $send_id, $attachment){
	$html = str_replace( 'href=' , 'data-callUpload=\'' . json_encode( array( 'id'=>$send_id ) ) . '\' href=', $html );
	return $html;
}, 11, 3 );

add_action( 'image_send_to_editor', function( $html, $id, $caption, $title, $align, $url, $size, $alt ) {
	$html = str_replace( 'src=' , 'data-callUpload=\'' . json_encode( array( 'id'=>$id ) ) . '\' src=', $html );
	return $html;
}, 11, 8 );


add_action( 'admin_head-media-upload-popup', function() {
	if( isset($_GET['button']) && !empty($_GET['button']) ) {
	?>
	<script type='text/javascript'>/* <![CDATA[ */
	(function($) {
		$(window).load(function () {
			var extup = { 'selector': {}, '$': {} };
			extup.selector.item = '#media-items .media-item';
			extup.selector.button = '#media-items .media-item td.savesend input.button[id^="send"]';
			extup.selector.strictbutton = 'td.savesend input.button[id^="send"]';
			extup.$.button = $(extup.selector.button);
			extup.$.button.val("<?php echo esc_attr($_GET['button']); ?>");
			$(document).on({
				'hover': function() {
					var $this = $(this),
						$button = $this.find( extup.selector.strictbutton ),
						attr = $this.attr('id');
					$button.val("<?php echo esc_attr($_GET['button']); ?>");
				}
			}, extup.selector.item );
		});
	})(jQuery);
	/* ]]> */</script>
	<?php
	}
}, 20 );