/**
 * Course browser enhancement.
 *
 * The server has already rendered the correct result for whatever is in the
 * query string. This only removes the page load: intercept the form, fetch the
 * same URL, and swap the results region.
 *
 * Nothing here is required for the filter to work — without it the form
 * submits normally — so every step fails back to a real navigation rather than
 * leaving the page in a half-filtered state.
 */
( function () {
	'use strict';

	var browser = document.querySelector( '[data-academia-browser]' );

	if ( ! browser ) {
		return;
	}

	var form = browser.querySelector( '[data-academia-form]' );
	var results = browser.querySelector( '[data-academia-results]' );

	if ( ! form || ! results ) {
		return;
	}

	// Only now that the script is running is the submit button redundant.
	browser.classList.add( 'is-enhanced' );

	var pending = null;
	var debounce = null;

	function urlFor() {
		var data = new FormData( form );
		var params = new URLSearchParams();

		data.forEach( function ( value, key ) {
			if ( '' !== String( value ).trim() ) {
				params.append( key, value );
			}
		} );

		var query = params.toString();

		return form.action + ( query ? '?' + query : '' );
	}

	function swap( html, url ) {
		var parsed = new DOMParser().parseFromString( html, 'text/html' );
		var fresh = parsed.querySelector( '[data-academia-results]' );

		// A response without the region means something other than this page
		// came back (a login wall, an error page). Hand over to the browser.
		if ( ! fresh ) {
			window.location.assign( url );

			return;
		}

		results.replaceWith( fresh );
		results = fresh;
		window.history.pushState( {}, '', url );
	}

	function load( url ) {
		if ( pending ) {
			pending.abort();
		}

		pending = new AbortController();
		results.setAttribute( 'aria-busy', 'true' );
		results.classList.add( 'is-loading' );

		window
			.fetch( url, {
				signal: pending.signal,
				headers: { 'X-Requested-With': 'academia-course-filter' },
				credentials: 'same-origin',
			} )
			.then( function ( response ) {
				if ( ! response.ok ) {
					throw new Error( 'HTTP ' + response.status );
				}

				return response.text();
			} )
			.then( function ( html ) {
				swap( html, url );
			} )
			.catch( function ( error ) {
				if ( 'AbortError' === error.name ) {
					return;
				}

				// Never strand the user on a stale list.
				window.location.assign( url );
			} )
			.finally( function () {
				if ( results ) {
					results.setAttribute( 'aria-busy', 'false' );
					results.classList.remove( 'is-loading' );
				}

				pending = null;
			} );
	}

	form.addEventListener( 'submit', function ( event ) {
		event.preventDefault();
		load( urlFor() );
	} );

	// Selects apply at once; typing waits until it stops.
	form.addEventListener( 'change', function ( event ) {
		if ( 'SELECT' === event.target.tagName ) {
			load( urlFor() );
		}
	} );

	form.addEventListener( 'input', function ( event ) {
		if ( 'search' !== event.target.type ) {
			return;
		}

		window.clearTimeout( debounce );
		debounce = window.setTimeout( function () {
			load( urlFor() );
		}, 350 );
	} );

	// Pagination and the clear-filters link live inside the swapped region, so
	// the listener is on the container that survives.
	browser.addEventListener( 'click', function ( event ) {
		var link = event.target.closest( '[data-academia-results] a' );

		if ( ! link || ! link.href || link.target ) {
			return;
		}

		// Course links must navigate; only in-page filter links are fetched.
		if ( ! link.matches( '.page-numbers, .academia-chip' ) ) {
			return;
		}

		if ( new URL( link.href ).origin !== window.location.origin ) {
			return;
		}

		event.preventDefault();
		load( link.href );
	} );

	// Back and forward have to re-fetch, or the list disagrees with the URL.
	window.addEventListener( 'popstate', function () {
		load( window.location.href );
	} );
}() );
