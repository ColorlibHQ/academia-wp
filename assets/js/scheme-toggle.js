/**
 * Visitor colour-scheme toggle.
 *
 * The button flips data-academia-scheme on <html> and remembers the choice. The
 * initial value is applied by a tiny inline script in the head (see
 * inc/scheme.php) so the page never paints in the wrong scheme first.
 */
( function () {
	var KEY = 'academia-scheme';
	var root = document.documentElement;

	function apply( scheme ) {
		if ( scheme === 'dark' || scheme === 'light' ) {
			root.setAttribute( 'data-academia-scheme', scheme );
		} else {
			root.removeAttribute( 'data-academia-scheme' );
		}
		var isDark = current() === 'dark';
		var labels = window.academiaScheme || {};
		document.querySelectorAll( '.academia-scheme-toggle' ).forEach( function ( wrapper ) {
			// The core Button block renders the control as an <a> inside the
			// wrapper the class lands on, so the state belongs on the link.
			var control = wrapper.matches( 'a, button' ) ? wrapper : wrapper.querySelector( 'a, button' );
			if ( ! control ) {
				return;
			}
			// Applied here rather than stored in the pattern: core's button
			// save() does not emit these, and markup it did not produce
			// fails block validation.
			control.setAttribute( 'role', 'button' );
			control.setAttribute( 'aria-pressed', isDark ? 'true' : 'false' );

			// The visible word names what clicking will do, not what is
			// already on — "Dark" while the page is dark reads as a status.
			var next = isDark ? labels.light : labels.dark;
			if ( next ) {
				control.textContent = next;
				if ( labels.switchTo ) {
					control.setAttribute( 'aria-label', labels.switchTo.replace( '%s', next.toLowerCase() ) );
				}
			}
		} );
	}

	function current() {
		var set = root.getAttribute( 'data-academia-scheme' );
		if ( set ) {
			return set;
		}
		return window.matchMedia( '(prefers-color-scheme: dark)' ).matches ? 'dark' : 'light';
	}

	function bind( button ) {
		button.addEventListener( 'click', function ( event ) {
			if ( event.target.closest( 'a[href="#"]' ) ) {
				event.preventDefault();
			}
			var next = current() === 'dark' ? 'light' : 'dark';
			try {
				window.localStorage.setItem( KEY, next );
			} catch ( e ) {}
			apply( next );
		} );
	}

	function init() {
		document.querySelectorAll( '.academia-scheme-toggle' ).forEach( bind );
		apply( root.getAttribute( 'data-academia-scheme' ) );
	}

	if ( document.readyState === 'loading' ) {
		document.addEventListener( 'DOMContentLoaded', init );
	} else {
		init();
	}
}() );
