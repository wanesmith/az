/*!
 * One Page
 *
 * Slikk 1.4.2
 */
/* jshint -W062 */
/* global SlikkParams */

var SlikkOnePage = (function ($) {
	"use strict";

	return {
		init : function() {
			if ( SlikkParams.isPage ) {
				this.menu();
			}
		},

		menu : function() {

			var menuMarkup, rowName, anchor,
				extensionPrefix = 'wvc-',
				scrollLinkClass = 'scroll';

			if ( SlikkParams.isWolfCore ) {
				extensionPrefix = 'wolf-core-';
			}

			if ( SlikkParams.fullPageAnimation ) {
				scrollLinkClass = extensionPrefix +'-fp-nav';
			}

			if ( $( '.' + extensionPrefix + 'parent-row' ).length ) {

				$( 'ul.nav-menu' ).hide();

				menuMarkup = "<div class='menu-one-page-menu-container'>";

				menuMarkup += "<ul class='nav-menu'>";

				$( '.' + extensionPrefix + 'parent-row' ).each( function() {

					if ( $( this ).data( 'row-name' ) && ! $( this ).hasClass( 'not-one-page-section' ) ) {
						rowName = $( this ).data( 'row-name' );
						anchor = rowName.replace( ' ', '-' ).toLowerCase();

						menuMarkup += "<li class='menu-item menu-item-type-custom menu-item-object-custom'>";
						menuMarkup += "<a href='#" + anchor + "' class='menu-link " + scrollLinkClass + "'>";
						menuMarkup += "<span class='menu-item-inner'>";
						menuMarkup += "<span class='menu-item-text-container' itemprop='name'>";
						menuMarkup += rowName;
						menuMarkup += "</span>";
						menuMarkup += "</span>";
						menuMarkup += "</a>";
						menuMarkup += "</li>";
					}
				} );

				menuMarkup += "</ul>";

				menuMarkup += "</div>";

				$( '#desktop-navigation' ).find(".menu-container").append( menuMarkup );
				$( '#mobile-menu-panel-inner' ).append( menuMarkup );

				$( '#desktop-navigation' ).find( 'ul.nav-menu' ).addClass( 'nav-menu-desktop' ).attr( 'id', 'site-navigation-primary-desktop' ).fadeIn();
				$( '#mobile-menu-panel-inner' ).find( 'ul.nav-menu' ).addClass( 'nav-menu-mobile' ).attr( 'id', 'site-navigation-primary-mobile' ).fadeIn();
			}
		}
	};

})(jQuery);

(function ($) {
	"use strict";

	$(window).on("load", function() {
		SlikkOnePage.init();
	});
})(jQuery);
