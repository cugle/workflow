(function( $ ) {
	$.fn.scrollLoad = function( options ) {
	
		var defaults = {
			url : '',
			data : '',
			ScrollAfterHeight : 90,
			onload : function( data, itsMe ) {
				alert( data );
			},
			start : function( itsMe ){},
			continueWhile : function() {
				return true;
			},
			getData : function( itsMe ) {
				return '';
			}
		};

		for( var eachProperty in defaults ) {
			if( options[ eachProperty ] ) {
				defaults[ eachProperty ] = options[ eachProperty ];
			}
		}

		return this.each( function() {			
			this.scrolling = false;
			this.scrollPrev = this.onscroll ? this.onscroll : null;
			$(this).bind('scroll',function ( e ) {
				//console.log('go');
				if( this.scrollPrev ) {
					this.scrollPrev();
				}
				if( this.scrolling ) return;				
				var scroll_percent=$(this).scrollTop()/document.documentElement.clientHeight*10;			
				if(scroll_percent> defaults.ScrollAfterHeight ) {
					defaults.start.call( this, this );
					this.scrolling = true;
					$this = $( this );
					
					$.ajax( { url : defaults.url, data : defaults.getData.call( this, this ), type : 'post', success : function( data ) {
						$this[ 0 ].scrolling = false;
						defaults.onload.call( $this[ 0 ], data, $this[ 0 ] );
						if( !defaults.continueWhile.call( $this[ 0 ], data ) ) {
							$this.unbind( 'scroll' );
						}
					}});
				}
			});
		});
	}
})( jQuery );