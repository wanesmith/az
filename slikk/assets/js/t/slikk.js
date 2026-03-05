/*!
 * Additional Theme Methods
 *
 * Slikk 1.4.2
 */
/* jshint -W062 */

/* global SlikkParams, SlikkUi, WVC, Cookies, Event, WVCParams, CountUp */
var Slikk = function( $ ) {

	'use strict';

	return {
		initFlag : false,
		isEdge : ( navigator.userAgent.match( /(Edge)/i ) ) ? true : false,
		isWVC : 'undefined' !== typeof WVC,
		isMobile : ( navigator.userAgent.match( /(iPad)|(iPhone)|(iPod)|(Android)|(PlayBook)|(BB10)|(BlackBerry)|(Opera Mini)|(IEMobile)|(webOS)|(MeeGo)/i ) ) ? true : false,
		loaded : false,

		/**
		 * Init all functions
		 */
		init : function () {

			if ( this.initFlag ) {
				return;
			}

			var _this = this;

			this.quickView();
			this.loginPopup();
			this.stickyProductDetails();
			//this.tooltipsy();
			this.transitionCosmetic();
			this.startPercent();
			this.WCQuantity();

			this.isMobile = SlikkParams.isMobile;

			if ( this.isWVC ) {

			}

			$( window ).on( 'wwcq_product_quickview_loaded', function( event ) {
			} );

			$( window ).scroll( function() {
				var scrollTop = $( window ).scrollTop();
				_this.backToTopSkin( scrollTop );
			} );

			this.initFlag = true;
		},

		/**
		 * Product quickview
		 */
		quickView : function () {

			$( document ).on( 'added_to_cart', function( event, fragments, cart_hash, $button ) {
				if ( $button.hasClass( 'quickview-product-add-to-cart' ) ) {
					//console.log( 'good?' );
					$button.attr( 'href', SlikkParams.WooCommerceCartUrl );
					$button.find( 'span' ).html( SlikkParams.l10n.viewCart );
					$button.removeClass( 'ajax_add_to_cart' );
				}
			} );
		},

		/**
		 * Sticky product layout
		 */
		stickyProductDetails : function() {
			if ( $.isFunction( $.fn.stick_in_parent ) ) {
				if ( $( 'body' ).hasClass( 'sticky-product-details' ) ) {
					$( '.entry-single-product .summary' ).stick_in_parent( {
						offset_top : parseInt( SlikkParams.portfolioSidebarOffsetTop, 10 ) + 40
					} );
				}
			}
		},

		/**
		 * Tooltip
		 */
		tooltipsy : function () {
			if ( ! this.isMobile ) {

				var $tipspan,
					selectors = '.product-quickview-button, .wolf_add_to_wishlist:not(.no-tipsy), .quickview-product-add-to-cart-icon';

				$( selectors ).tooltipsy();

				$( document ).on( 'added_to_cart', function( event, fragments, cart_hash, $button ) {

					if ( $button.hasClass( 'wvc-ati-add-to-cart-button' ) || $button.hasClass( 'wpm-add-to-cart-button' ) || $button.hasClass( 'wolf-release-add-to-cart' ) || $button.hasClass( 'product-add-to-cart' ) ) {

						$tipspan = $button.find( 'span' );

						$tipspan.data( 'tooltipsy' ).hide();
						$tipspan.data( 'tooltipsy' ).destroy();

						$tipspan.attr( 'title', SlikkParams.l10n.addedToCart );

						$tipspan.tooltipsy();
						$tipspan.data( 'tooltipsy' ).show();

						setTimeout( function() {
							$tipspan.data( 'tooltipsy' ).hide();
							$tipspan.data( 'tooltipsy' ).destroy();
							$tipspan.attr( 'title', SlikkParams.l10n.addToCart );
							$tipspan.tooltipsy();

							$button.removeClass( 'added' );
						}, 4000 );

					} else if ( $button.hasClass( 'wvc-button' ) ) {
						$button.text( SlikkParams.l10n.addedToCart );

						setTimeout( function() {
							$button.text( SlikkParams.l10n.addToCart );
							$button.removeClass( 'added' );
						}, 4000 );
					}
				} );
			}
		},

		/**
		 * https://stackoverflow.com/questions/48953897/create-a-custom-quantity-field-in-woocommerce
		 */
		WCQuantity : function () {

			$( document ).on( 'click', '.wt-quantity-minus', function( event ) {

				event.preventDefault();
				var $input = $( this ).parent().find( 'input.qty' ),
					val = parseInt( $input.val(), 10 ),
					step = $input.attr( 'step' );
				step = 'undefined' !== typeof( step ) ? parseInt( step ) : 1;

				if ( val > 1 ) {
					$input.val( val - step ).change();
				}
			} );

			$( document ).on( 'click', '.wt-quantity-plus', function( event ) {
				event.preventDefault();

				var $input = $( this ).parent().find( 'input.qty' ),
					val = parseInt( $input.val(), 10),
					step = $input.attr( 'step' );
				step = 'undefined' !== typeof( step ) ? parseInt( step ) : 1;
				$input.val( val + step ).change();
			} );
		},

		/**
		 * Check back to top color
		 */
		backToTopSkin : function( scrollTop ) {

			if ( scrollTop < 550 ) {
				return;
			}

			$( '.wvc-row' ).each( function() {

				if ( $( this ).hasClass( 'wvc-font-light' ) && ! $( this ).hasClass( 'wvc-row-bg-transparent' ) ) {

						var $button = $( '#back-to-top' ),
						buttonOffset = $button.position().top + $button.width() / 2 ,
						sectionTop = $( this ).offset().top - scrollTop,
						sectionBottom = sectionTop + $( this ).outerHeight();

					if ( sectionTop < buttonOffset && sectionBottom > buttonOffset ) {
						$button.addClass( 'back-to-top-light' );
					} else {
						$button.removeClass( 'back-to-top-light' );
					}
				}
			} );
		},

		/**
		 * WC login popup
		 */
		loginPopup: function () {
			var $body = $("body"),
				clicked = false;

			$(document).on(
				"click",
				".account-item-icon-user-not-logged-in, .close-loginform-button",
				function (event) {
					event.preventDefault();

					if ($body.hasClass("loginform-popup-toggle")) {

						$body.removeClass("loginform-popup-toggle");

					} else {

						$body.removeClass("overlay-menu-toggle");

						if ( $(".wvc-login-form").length || $(".wolf-core-login-form").length ) {

							$body.addClass("loginform-popup-toggle");

						} else if ( ! clicked ) {
							/* AJAX call */
							$.post(
								SlikkParams.ajaxUrl,
								{ action: "slikk_ajax_get_wc_login_form" },
								function (response) {
									console.log(response);

									if (response) {
										$("#loginform-overlay-content").append(
											response
										);

										$body.addClass(
											"loginform-popup-toggle"
										);
									}
								}
							);
						}
					}
				}
			);

			if (!this.isMobile) {
				$(document).mouseup(function (event) {
					if (1 !== event.which) {
						return;
					}

					var $container = $("#loginform-overlay-content");

					if (
						!$container.is(event.target) &&
						$container.has(event.target).length === 0
					) {
						$body.removeClass("loginform-popup-toggle");
					}
				});
			}
		},

		/**
		 * Overlay transition
		 */
		transitionCosmetic : function() {

			$( document ).on( 'click', '.internal-link:not(.disabled)', function( event ) {

				if ( ! event.ctrlKey ) {

					event.preventDefault();

					var $link = $( this );

					$( 'body' ).removeClass( 'mobile-menu-toggle overlay-menu-toggle offcanvas-menu-toggle loginform-popup-toggle' );
					$( 'body' ).addClass( 'loading transitioning' );

					Cookies.set( SlikkParams.themeSlug + '_session_loaded', true, { expires: null } );

					if ( $( '.slikk-loader-overlay' ).length ) {
						$( '.slikk-loader-overlay' ).one( SlikkUi.transitionEventEnd(), function() {
							Cookies.remove( SlikkParams.themeSlug + '_session_loaded' );
							window.location = $link.attr( 'href' );
						} );
					} else {
						window.location = $link.attr( 'href' );
					}
				}
			} );
		},

		/**
		 * Star counter loader
		 */
		startPercent : function() {

			if ( $( '#slikk-percent' ).length ) {

				var _this = this,
					progressNumber = 'slikk-percent',
					$progressNumber = $( '#' + progressNumber ),
					duration = 3,
					numAnimText,
					options = {
						useEasing: true,
						useGrouping: true,
						separator: ',',
						decimal: '.',
						suffix: '%'
					};

				$progressNumber.addClass( 'slikk-percent-show' ).one( SlikkUi.transitionEventEnd(), function() {

					numAnimText = new CountUp( progressNumber, 0, 100, 0, duration, options );

					numAnimText.start( function() {
						$progressNumber
							.removeClass( 'slikk-percent-show' )
							.addClass( 'slikk-percent-hide' )
							.one( SlikkUi.transitionEventEnd(), function() {
								_this.reveal();
							} );
					} );
				} );
			}
		},

		reveal : function() {

			var _this = this;

			$( 'body' ).addClass( 'loaded reveal' );
			_this.fireContent();
		},

		/**
		* Page Load
		*/
		loadingAnimation : function () {

			var _this = this,
				delay = 50;

		    	if ( $( '#slikk-percent' ).length ) {
		    		return;
		    	}

			setTimeout( function() {

				$( 'body' ).addClass( 'loaded' );

				if ( $( '.slikk-loader-overlay' ).length ) {

					$( 'body' ).addClass( 'reveal' );

					$( '.slikk-loader-overlay' ).one( SlikkUi.transitionEventEnd(), function() {

						_this.fireContent();

						setTimeout( function() {

							$( 'body' ).addClass( 'one-sec-loaded' );

						}, 100 );
					} );

				} else {

					$( 'body' ).addClass( 'reveal' );

					_this.fireContent();

					setTimeout( function() {

						$( 'body' ).addClass( 'one-sec-loaded' );

					}, 100 );
				}
			}, delay );
 		},

		fireContent : function () {

			var _this = this;

			// Animate
			$( window ).trigger( 'page_loaded' );
			SlikkUi.wowAnimate();
			window.dispatchEvent( new Event( 'resize' ) );
			window.dispatchEvent( new Event( 'scroll' ) ); // Force WOW effect
			$( window ).trigger( 'just_loaded' );
			$( 'body' ).addClass( 'one-sec-loaded' );
		}
	};

}( jQuery );

( function( $ ) {

	'use strict';

	$( document ).ready( function() {
		Slikk.init();
	} );

	$( window ).load( function() {
		Slikk.loadingAnimation();
	} );

} )( jQuery );
