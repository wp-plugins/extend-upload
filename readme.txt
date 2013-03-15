=== Extend Upload ===
Contributors: webord
Donate link: http://bordoni.me/
Tags: upload, developer, dev, extend
Requires at least: 3.0
Tested up to: 3.5.1
Stable tag: 0.0.4

A plugin for developers to Extend WordPress upload to be able to use it at any place.

== Description ==

I had a problem that most of the time I had to upload a file, and I had to use a HTML upload, and that's kind of bad, so I created something to use the Thickbox and the WordPress Uploader.

To use you must enqueue in the page used both the style and the script of the plugin:
`
<?php
	wp_enqueue_script( 'extend-upload' );
	wp_enqueue_style( 'extend-upload' );
`

Then you can use the plugin by calling the jQuery Extends:
`
(function($) {
	$(document).ready(function () {
		$('.uc-call').callUpload();
	});
})(jQuery.noConflict());
`
And the HTML/PHP output should be something like that:
`
<?php
	$args = array( 
		'url' => admin_url( 'media-upload.php?post_id=0&button=' . rawurlencode('Use as Avatar') . '&TB_iframe=1&width=640&height=253' )
	);
?>
<p class='uc-container'>
	<label><?php echo _e( "Avatar:" ); ?></label><a target='_blank' class='uc-call' data='<?php echo json_encode( $args ); ?>'><small><?php _e( "Upload the Photo" ); ?></small></a>"; ?>
	<input class="uc-answer" type="text" value="<?php echo ( is_numeric( absint( $avatar ) ) ? absint( $avatar ) : esc_url($avatar) ); ?>" />
</p>
`

Having the `uc-call` for the link, `uc-answer` with the input field and `uc-container` for the box with both the link and the input field.

All the stuff is customizable by passing the variables in to the array `$args`, some stuff must be passed in the url, but later on I will add a easier way to do it.

== Backlog ==

= 0.0.4 =
* Older version of jQuery allowed and allowing non Image Media to be used

= 0.0.3 =
* Fixed some bugs and added internationalization

= 0.0.2 =
* Added the javascript to change the Insert to Post text on the thickbox

= 0.0.1 =
* Using the the thickbox with the uploader iFrame inside you can call this from any page that has the script enqueued


== Upgrade Notice ==

= 0.0.4 =
Older version jQuery allowed, nailed it!

= 0.0.3 =
Internationalization! Yipiii!

= 0.0.2 =
To add the possibility to change the Insert to Post button on the thickbox

= 0.0.1 =
This is the first version, give the plugin a try!


If you want you can check the plugin on GitHub, I will update there then I will commmit here.

https://github.com/webord/extend-upload