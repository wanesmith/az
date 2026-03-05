/**
 *  Searchable dropdown
 */
 /* global SlikkAdminParams */
;( function( $ ) {

	'use strict';

	$( '.slikk-searchable' ).chosen( {
		no_results_text: SlikkAdminParams.noResult,
		width: '100%'
	} );

	$( document ).on( 'hover', '#menu-to-edit .pending', function() {
		if ( ! $( this ).find( '.chosen-container' ).length && $( this ).find( '.slikk-searchable' ).length ) {
			$( this ).find( '.slikk-searchable' ).chosen( {
				no_results_text: SlikkAdminParams.noResult,
				width: '100%'
			} );
		}
	} );

} )( jQuery );