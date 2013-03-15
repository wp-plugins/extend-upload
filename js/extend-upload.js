(function($) {
	$.fn.callUpload = function() {
		var	_methods = {
				'init' : function() {
					var	$this = this;

					$this.each(function ( k, e ) {
						var $_this = $(e),
							defaults = {
								selectors: {
									'field': '.uc-answer',
									'container': '.uc-container'
								},
								'$' : {},
								label: 'Upload a file',
								'send': function(html){
									var $html = $(html),
										$a = $html.filter( 'a' ),
										$img = $html.find( 'img' ),
										_data = $.parseJSON( $img.attr( 'data' ) );

									if (_data === null)
										_data = $.parseJSON( $a.attr( 'data' ) );
									data.$.field.val( _data.id );
									tb_remove();
									window.send_to_editor = window.original_send_to_editor;
								},
								'event': {
									'click': function(){
										tb_show( data.label, data.url );
										window.original_send_to_editor = window.send_to_editor;
										window.send_to_editor = data.send;
										$('#TB_overlay,#TB_closeWindowButton').on("click",function(){
											window.send_to_editor = window.original_send_to_editor;
										});
										$(document).keyup(function(e) {
											if (e.keyCode == 27) window.send_to_editor = window.original_send_to_editor;
										});
									}
								}
							},
							data = $.extend( true, $.parseJSON( $_this.attr( 'data' ) ), defaults );
							data.$.container = $_this.parents(data.selectors.container);
							data.$.field = data.$.container.find( data.selectors.field );
						$_this.data('callUpload', data);

						// Check if we are using an Older version of jQuery, check for the `on` method
						if ('on' in $) {
							$_this.on({
								'click': data.event.click
							});
						} else {
							$_this.bind({
								'click': data.event.click
							});
						}

					});
				}
			},
			methods = {};

		if ( typeof arguments[0] === 'object' || ! arguments[0] ) {
			return _methods.init.apply( this, arguments );
		} else if ( typeof arguments[0] === 'string' && ( _methods[arguments[0]] || methods[arguments[0]] ) ) {
			if( $.isFunction( _methods[arguments[0]] ) ) {
				return _methods[arguments[0]].apply( this, Array.prototype.slice.call( arguments, 1 ));
			} else {
				return methods[arguments[0]].apply( this, Array.prototype.slice.call( arguments, 1 ));
			}
		} else {
			$.error( 'Method ' +  arguments[0] + ' does not exist on jQuery.callUpload' );
		}
	};
})(jQuery);