/**
 * File navigation.js.
 *
 * Handles toggling the navigation menu for small screens and enables tab
 * support for dropdown menus.
 */
( function() {
	var siteNavigation = document.getElementById( 'site-navigation' );

	// Return early if the navigation doesn't exist.
	if ( ! siteNavigation ) {
		return;
	}

	var button = siteNavigation.getElementsByTagName( 'button' )[0];

	// Return early if the button doesn't exist.
	if ( ! button ) {
		return;
	}

	var menu = siteNavigation.getElementsByTagName( 'ul' )[0];

	// Hide menu toggle button if menu is empty and there's nothing to toggle.
	if ( ! menu || ! menu.children.length ) {
		button.style.display = 'none';
		return;
	}

	button.addEventListener( 'click', function() {
		siteNavigation.classList.toggle( 'toggled-on' );

		if ( button.getAttribute( 'aria-expanded' ) === 'true' ) {
			button.setAttribute( 'aria-expanded', 'false' );
		} else {
			button.setAttribute( 'aria-expanded', 'true' );
		}
	} );
} )();