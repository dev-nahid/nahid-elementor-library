( function( $ ) {
	'use strict';

	/**
	 * Nahid Feature Box Handler
	 * 
	 * This function runs when the Feature Box widget is loaded on the live frontend,
	 * AND every time it is modified or added in the Elementor Editor live preview.
	 */
	var WidgetFeatureBoxHandler = function( $scope, $ ) {
		// $scope represents the widget wrapper in the DOM
		var $featureBox = $scope.find( '.nahid-feature-box' );

		if ( ! $featureBox.length ) {
			return; // Exit if the specific element isn't found
		}

		// Example Interactive JS: Add a simple console log to prove it works in the live editor preview
		console.log( 'Nahid Feature Box successfully initialized for live review!' );

		// You can initialize sliders, carousels, or dynamic height calculations here.
	};

	// Make sure you run this code under Elementor's init event.
	$( window ).on( 'elementor/frontend/init', function() {
		
		// Hook our handler to the 'nahid_feature_box' widget.
		// The `.default` indicates it runs for the default skin (standard usage).
		elementorFrontend.hooks.addAction( 'frontend/element_ready/nahid_feature_box.default', WidgetFeatureBoxHandler );
		
		// If you create more widgets that require JS, add their hooks here:
		// elementorFrontend.hooks.addAction( 'frontend/element_ready/nahid_hero_section.default', WidgetHeroSectionHandler );

	} );

} )( jQuery );
