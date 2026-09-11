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
		document.querySelectorAll( '.academia-scheme-toggle' ).forEach( function ( control ) {
			control.setAttribute( 'aria-pressed', isDark ? 'true' : 'false' );

			// The label names what clicking will do, not what is already on.
			// It is an aria-label only: the visible control is two icons, and
			// CSS shows whichever matches the current scheme.
			var next = isDark ? labels.light : labels.dark;

			if ( next && labels.switchTo ) {
				control.setAttribute( 'aria-label', labels.switchTo.replace( '%s', next.toLowerCase() ) );
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
		button.addEventListener( 'click', function () {
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
