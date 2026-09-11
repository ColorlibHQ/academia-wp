<?php
/**
 * Starter sites.
 *
 * Each starter site is a complete look for one kind of website: a colour
 * palette, a typography preset, a home page built from patterns, the supporting
 * pages and a matching menu. Applying one writes the style variation into
 * Global Styles, creates the pages and points Settings → Reading at them.
 *
 * Nothing is ever deleted. Applying a second starter creates a new home page
 * and leaves the previous one in the Pages list.
 *
 * @package Academia
 * @since   2.3.0
 */

defined( 'ABSPATH' ) || exit;

/** Option holding the slug of the starter site last applied. */
const ACADEMIA_STARTER_OPTION = 'academia_active_starter';

/** Transient holding the result of the last apply ("done" | "error"). */
const ACADEMIA_STARTER_RESULT = 'academia_starter_result';

/**
 * The starter site definitions.
 *
 * @return array[] Keyed by slug.
 */
function academia_get_starter_sites() {
	$sites = array(
		'academy'    => array(
			'title'    => __( 'Online academy', 'academia' ),
			'summary'  => __( 'The default: a course catalogue with levels and prices, the tutors who teach it, student results and enrolment.', 'academia' ),
			'cta'      => _x( 'Enrol now', 'Header call-to-action button', 'academia' ),
			'style'    => 'academy',
			'colors'   => 'colors-1-teal',
			'type'     => 'typography-1-academy',
			'swatches' => array( '#0f766e', '#b45309' ),
			'home'     => 'academia/demo-academy',
			'thumb'    => 'academy',
			'footer'   => 'academia/footer-academy',
			'pages'    => array(
				'courses'     => array(
					'title'    => __( 'Courses', 'academia' ),
					'patterns' => array( 'academia/page-courses' ),
				),
				'instructors' => array(
					'title'    => __( 'Instructors', 'academia' ),
					'patterns' => array( 'academia/page-instructors' ),
				),
				'pricing'     => array(
					'title'    => __( 'Pricing', 'academia' ),
					'patterns' => array( 'academia/page-pricing' ),
				),
				'about'       => array(
					'title'    => __( 'About', 'academia' ),
					'patterns' => array( 'academia/page-about' ),
				),
				'contact'     => array(
					'title'    => __( 'Contact', 'academia' ),
					'patterns' => array( 'academia/page-contact' ),
				),
			),
		),
		'university'  => array(
			'title'    => __( 'University & college', 'academia' ),
			'summary'  => __( 'A degree-awarding institution: faculties and programmes, admissions with its deadlines, research and campus life.', 'academia' ),
			'cta'      => _x( 'Apply now', 'Header call-to-action button', 'academia' ),
			'style'    => 'university',
			'colors'   => 'colors-2-indigo',
			'type'     => 'typography-2-editorial',
			'swatches' => array( '#4338ca', '#b45309' ),
			'home'     => 'academia/demo-university',
			'thumb'    => 'university',
			'footer'   => 'academia/footer-university',
			'pages'    => array(
				'programmes' => array(
					'title'    => __( 'Programmes', 'academia' ),
					'patterns' => array( 'academia/page-courses' ),
				),
				'admissions' => array(
					'title'    => __( 'Admissions', 'academia' ),
					'patterns' => array( 'academia/page-admissions' ),
				),
				'faculty'    => array(
					'title'    => __( 'Faculty', 'academia' ),
					'patterns' => array( 'academia/page-instructors' ),
				),
				'campus'     => array(
					'title'    => __( 'Campus', 'academia' ),
					'patterns' => array( 'academia/page-about' ),
				),
				'contact'    => array(
					'title'    => __( 'Contact', 'academia' ),
					'patterns' => array( 'academia/page-contact' ),
				),
			),
		),
		'school'      => array(
			'title'    => __( 'School & kindergarten', 'academia' ),
			'summary'  => __( 'A primary school: the classes by age group, the teaching team, the term calendar and how to arrange a visit.', 'academia' ),
			'cta'      => _x( 'Book a visit', 'Header call-to-action button', 'academia' ),
			'style'    => 'kindergarten',
			'colors'   => 'colors-6-ember',
			'type'     => 'typography-3-friendly',
			'swatches' => array( '#c2410c', '#0f766e' ),
			'home'     => 'academia/demo-school',
			'thumb'    => 'school',
			'footer'   => 'academia/footer-school',
			'pages'    => array(
				'classes'  => array(
					'title'    => __( 'Classes', 'academia' ),
					'patterns' => array( 'academia/page-courses' ),
				),
				'teachers' => array(
					'title'    => __( 'Teachers', 'academia' ),
					'patterns' => array( 'academia/page-instructors' ),
				),
				'admissions' => array(
					'title'    => __( 'Admissions', 'academia' ),
					'patterns' => array( 'academia/page-admissions' ),
				),
				'about'    => array(
					'title'    => __( 'Our school', 'academia' ),
					'patterns' => array( 'academia/page-about' ),
				),
				'contact'  => array(
					'title'    => __( 'Visit us', 'academia' ),
					'patterns' => array( 'academia/page-contact' ),
				),
			),
		),
		'bootcamp'    => array(
			'title'    => __( 'Coding bootcamp', 'academia' ),
			'summary'  => __( 'An intensive technical course: the syllabus week by week, the cohort dates, hiring outcomes and financing.', 'academia' ),
			'cta'      => _x( 'Join a cohort', 'Header call-to-action button', 'academia' ),
			'style'    => 'bootcamp',
			'colors'   => 'colors-4-slate',
			'type'     => 'typography-4-technical',
			'swatches' => array( '#334155', '#b45309' ),
			'home'     => 'academia/demo-bootcamp',
			'thumb'    => 'bootcamp',
			'footer'   => 'academia/footer-bootcamp',
			'pages'    => array(
				'syllabus' => array(
					'title'    => __( 'Syllabus', 'academia' ),
					'patterns' => array( 'academia/page-syllabus' ),
				),
				'outcomes' => array(
					'title'    => __( 'Outcomes', 'academia' ),
					'patterns' => array( 'academia/page-outcomes' ),
				),
				'mentors'  => array(
					'title'    => __( 'Mentors', 'academia' ),
					'patterns' => array( 'academia/page-instructors' ),
				),
				'pricing'  => array(
					'title'    => __( 'Financing', 'academia' ),
					'patterns' => array( 'academia/page-pricing' ),
				),
				'contact'  => array(
					'title'    => __( 'Contact', 'academia' ),
					'patterns' => array( 'academia/page-contact' ),
				),
			),
		),
		'language'    => array(
			'title'    => __( 'Language school', 'academia' ),
			'summary'  => __( 'Language courses by level, from A1 to C2: class sizes, native-speaker tutors, exam preparation and term fees.', 'academia' ),
			'cta'      => _x( 'Take the test', 'Header call-to-action button', 'academia' ),
			'style'    => 'campus',
			'colors'   => 'colors-3-forest',
			'type'     => 'typography-1-academy',
			'swatches' => array( '#15803d', '#a16207' ),
			'home'     => 'academia/demo-language',
			'thumb'    => 'language',
			'footer'   => 'academia/footer-academy',
			'pages'    => array(
				'courses' => array(
					'title'    => __( 'Courses', 'academia' ),
					'patterns' => array( 'academia/page-courses' ),
				),
				'tutors'  => array(
					'title'    => __( 'Tutors', 'academia' ),
					'patterns' => array( 'academia/page-instructors' ),
				),
				'fees'    => array(
					'title'    => __( 'Fees', 'academia' ),
					'patterns' => array( 'academia/page-pricing' ),
				),
				'contact' => array(
					'title'    => __( 'Contact', 'academia' ),
					'patterns' => array( 'academia/page-contact' ),
				),
			),
		),
		'studio'      => array(
			'title'    => __( 'Arts & music studio', 'academia' ),
			'summary'  => __( 'A creative academy: workshops and one-to-one tuition, the studio itself, student work and a booking form.', 'academia' ),
			'cta'      => _x( 'Book a lesson', 'Header call-to-action button', 'academia' ),
			'style'    => 'studio',
			'colors'   => 'colors-5-plum',
			'type'     => 'typography-5-neutral',
			'swatches' => array( '#9333ea', '#0f766e' ),
			'home'     => 'academia/demo-studio',
			'thumb'    => 'studio',
			'footer'   => 'academia/footer-academy',
			'pages'    => array(
				'workshops' => array(
					'title'    => __( 'Workshops', 'academia' ),
					'patterns' => array( 'academia/page-courses' ),
				),
				'teachers'  => array(
					'title'    => __( 'Teachers', 'academia' ),
					'patterns' => array( 'academia/page-instructors' ),
				),
				'about'     => array(
					'title'    => __( 'The studio', 'academia' ),
					'patterns' => array( 'academia/page-about' ),
				),
				'contact'   => array(
					'title'    => __( 'Book', 'academia' ),
					'patterns' => array( 'academia/page-contact' ),
				),
			),
		),
	);

	/**
	 * Filters the starter sites offered by the theme.
	 *
	 * @since 2.3.0
	 *
	 * @param array[] $sites Starter site definitions keyed by slug.
	 */
	return apply_filters( 'academia_starter_sites', $sites );
}

/**
 * Apply a starter site.
 *
 * @param string $slug Starter site slug.
 * @return array|WP_Error Array of created page IDs, or WP_Error.
 */
function academia_apply_starter_site( $slug ) {
	$sites = academia_get_starter_sites();

	if ( ! isset( $sites[ $slug ] ) ) {
		return new WP_Error( 'academia_unknown_starter', __( 'That starter site does not exist.', 'academia' ) );
	}

	$site    = $sites[ $slug ];
	$content = academia_lock_starter_sections( academia_get_pattern_markup( $site['home'] ) );

	if ( '' === $content ) {
		return new WP_Error( 'academia_missing_pattern', __( 'The starter site’s home page pattern could not be loaded.', 'academia' ) );
	}

	$kses_active = has_filter( 'content_save_pre', 'wp_filter_post_kses' );
	if ( $kses_active ) {
		kses_remove_filters();
	}

	$author_id = academia_starter_author_id();
	$created   = array();

	$home_id = wp_insert_post(
		array(
			'post_type'      => 'page',
			'post_status'    => 'publish',
			'post_title'     => $site['title'],
			'post_author'    => $author_id,
			'post_content'   => $content,
			'comment_status' => 'closed',
			'ping_status'    => 'closed',
			'page_template'  => 'page-no-title',
		),
		true
	);

	if ( is_wp_error( $home_id ) ) {
		if ( $kses_active ) {
			kses_init_filters();
		}
		return $home_id;
	}

	$created['home'] = $home_id;

	foreach ( $site['pages'] as $key => $page ) {
		// A page whose slug matches a registered archive is unreachable: the
		// archive wins the URL, so the page is orphaned and editing it changes
		// nothing on the front end. Link the menu at the archive instead.
		$archive = academia_starter_archive_url( $page['title'] );

		if ( $archive ) {
			$created[ $key . '_archive' ] = $archive;

			continue;
		}

		$markup = academia_get_starter_page_markup( $page );
		if ( '' === $markup ) {
			continue;
		}

		$page_id = wp_insert_post(
			array(
				'post_type'      => 'page',
				'post_status'    => 'publish',
				'post_title'     => $page['title'],
				'post_author'    => $author_id,
				'post_content'   => $markup,
				'comment_status' => 'closed',
				'ping_status'    => 'closed',
				'page_template'  => 'page-no-title',
			),
			true
		);

		if ( ! is_wp_error( $page_id ) ) {
			$created[ $key ] = $page_id;
		}
	}

	if ( $kses_active ) {
		kses_init_filters();
	}

	$blog_id = academia_starter_blog_page( $author_id );

	update_option( 'show_on_front', 'page' );
	update_option( 'page_on_front', $home_id );
	if ( $blog_id ) {
		update_option( 'page_for_posts', $blog_id );
		$created['blog'] = $blog_id;
	}

	academia_apply_starter_styles( $site );
	academia_build_starter_menu( $site, $created );
	academia_apply_starter_header( $site );
	academia_apply_starter_footer( $site );

	update_option( ACADEMIA_STARTER_OPTION, array( 'slug' => $slug, 'pages' => $created, 'time' => time() ) );
	update_option(
		ACADEMIA_SETUP_OPTION,
		array( 'home' => $home_id, 'blog' => $blog_id, 'version' => ACADEMIA_VERSION, 'time' => time() )
	);
	delete_option( ACADEMIA_OFFER_OPTION );

	return $created;
}

/**
 * Merge two style-variation arrays.
 *
 * Associative arrays merge key by key; lists are replaced outright, because a
 * palette is a list and merging two palettes item by item would interleave
 * them.
 *
 * @param array $base  Base array.
 * @param array $added Array to merge in.
 * @return array
 */
function academia_merge_variation( $base, $added ) {
	foreach ( $added as $key => $value ) {
		if ( is_array( $value ) && isset( $base[ $key ] ) && is_array( $base[ $key ] )
			&& ! wp_is_numeric_array( $value ) && ! wp_is_numeric_array( $base[ $key ] ) ) {
			$base[ $key ] = academia_merge_variation( $base[ $key ], $value );
			continue;
		}

		$base[ $key ] = $value;
	}

	return $base;
}

/**
 * Compose a style variation from a colour partial and a typography partial.
 *
 * @param string $colors Colour variation slug, e.g. colors-7-stone.
 * @param string $type   Typography variation slug, e.g. typography-3-editorial.
 * @return array|null Composed variation, or null when either part is missing.
 */
function academia_compose_variation( $colors, $type ) {
	if ( ! $colors || ! $type ) {
		return null;
	}

	$out = array();

	foreach ( array( 'colors/' . $colors, 'typography/' . $type ) as $relative ) {
		$path = get_theme_file_path( 'styles/' . $relative . '.json' );

		if ( ! file_exists( $path ) ) {
			return null;
		}

		$part = wp_json_file_decode( $path, array( 'associative' => true ) );

		if ( ! is_array( $part ) ) {
			return null;
		}

		unset( $part['$schema'], $part['title'], $part['slug'], $part['version'] );
		$out = academia_merge_variation( $out, $part );
	}

	return $out;
}

/**
 * Build the content of one starter page.
 *
 * A page is defined either as a single 'pattern' or as a 'patterns' list of
 * section slugs, which are concatenated in order. Missing patterns are skipped
 * so a page still renders on WordPress versions where one of its blocks is
 * unavailable.
 *
 * @param array $page Page definition from the starter registry.
 * @return string Block markup, or an empty string when nothing resolved.
 */
function academia_get_starter_page_markup( $page ) {
	$slugs = array();

	if ( ! empty( $page['patterns'] ) && is_array( $page['patterns'] ) ) {
		$slugs = $page['patterns'];
	} elseif ( ! empty( $page['pattern'] ) ) {
		$slugs = array( $page['pattern'] );
	}

	$parts = array();

	foreach ( $slugs as $slug ) {
		$markup = academia_get_pattern_markup( $slug );
		if ( '' !== $markup ) {
			$parts[] = $markup;
		}
	}

	return academia_lock_starter_sections( implode( "\n\n", $parts ) );
}

/**
 * Lock the structure of a starter page, leaving its text and images editable.
 *
 * A starter page is a stack of finished sections. Without this, opening one in
 * the editor exposes every group, column and spacer, and the usual result is a
 * layout pulled apart by accident. Marking each top-level section
 * 'contentOnly' turns the page into fields to fill in: headings, paragraphs,
 * images and buttons stay editable, the scaffolding does not move.
 *
 * A user who wants the structure back can unlock a section from the block
 * toolbar, so this is a default rather than a restriction.
 *
 * Note: core/cover accepts the attribute but does not pass it to its inner
 * blocks, so a Cover hero stays fully editable. Its children are a heading, a
 * paragraph and buttons — content rather than scaffolding — so little is lost.
 *
 * @param string $markup Serialized block markup.
 * @return string Markup with top-level sections locked.
 */
function academia_lock_starter_sections( $markup ) {
	$blocks = parse_blocks( $markup );
	$locked = array();

	foreach ( $blocks as $block ) {
		if ( in_array( $block['blockName'], array( 'core/group', 'core/cover', 'core/columns' ), true ) ) {
			$block['attrs']['templateLock'] = 'contentOnly';
		}
		$locked[] = $block;
	}

	return serialize_blocks( $locked );
}

/**
 * Author for starter content: the current user, or the first administrator.
 *
 * @return int User ID, or 0.
 */
function academia_starter_author_id() {
	$author_id = get_current_user_id();

	if ( ! $author_id ) {
		$admins    = get_users(
			array( 'role' => 'administrator', 'number' => 1, 'orderby' => 'ID', 'order' => 'ASC', 'fields' => 'ID' )
		);
		$author_id = $admins ? (int) $admins[0] : 0;
	}

	return $author_id;
}

/**
 * Find or create the posts page.
 *
 * @param int $author_id Author for a newly created page.
 * @return int Page ID, or 0.
 */
function academia_starter_blog_page( $author_id ) {
	$blog_id = absint( get_option( 'page_for_posts' ) );
	if ( $blog_id && 'publish' === get_post_status( $blog_id ) ) {
		return $blog_id;
	}

	$existing = get_page_by_path( 'blog' );
	if ( $existing instanceof WP_Post && 'publish' === $existing->post_status ) {
		return $existing->ID;
	}

	$blog_id = wp_insert_post(
		array(
			'post_type'      => 'page',
			'post_status'    => 'publish',
			'post_title'     => _x( 'Blog', 'Title of the posts page created on activation', 'academia' ),
			'post_name'      => 'blog',
			'post_author'    => $author_id,
			'post_content'   => '',
			'comment_status' => 'closed',
			'ping_status'    => 'closed',
		),
		true
	);

	return is_wp_error( $blog_id ) ? 0 : $blog_id;
}

/**
 * Write the starter's palette and typography into Global Styles.
 *
 * The theme's own style variation is merged into the user's global styles post,
 * which is exactly what choosing it in Appearance → Editor → Styles would do.
 *
 * @param array $site Starter site definition.
 */
function academia_apply_starter_styles( $site ) {
	// A starter names both a palette and a typeface. Composing the variation
	// from those two partials — rather than loading the curated look that pairs
	// them — is what lets the setup wizard swap either one independently. The
	// curated file remains the fallback for a starter that names only a look.
	$variation = academia_compose_variation(
		isset( $site['colors'] ) ? $site['colors'] : '',
		isset( $site['type'] ) ? $site['type'] : ''
	);

	if ( ! $variation ) {
		$path = get_theme_file_path( 'styles/' . $site['style'] . '.json' );

		if ( ! file_exists( $path ) ) {
			return;
		}

		$variation = wp_json_file_decode( $path, array( 'associative' => true ) );
	}

	if ( ! is_array( $variation ) ) {
		return;
	}

	unset( $variation['$schema'], $variation['title'], $variation['slug'] );
	$variation['version']                     = WP_Theme_JSON::LATEST_SCHEMA;
	$variation['isGlobalStylesUserThemeJSON'] = true;

	$user_cpt = WP_Theme_JSON_Resolver::get_user_data_from_wp_global_styles( wp_get_theme(), true );

	if ( empty( $user_cpt['ID'] ) ) {
		return;
	}

	// Core finds the global styles post through the `wp_theme` taxonomy, and
	// creates it with `tax_input` — which wp_insert_post() silently discards
	// when there is no logged-in user with permission to assign terms. Under
	// WP-CLI there is no such user, so the term never lands, the next lookup
	// finds nothing and creates *another* post, and the variation is written to
	// one the site never reads. Attaching the term ourselves is idempotent in
	// the browser and is what makes headless provisioning work at all.
	wp_set_object_terms( $user_cpt['ID'], wp_get_theme()->get_stylesheet(), 'wp_theme' );

	wp_update_post(
		array(
			'ID'           => $user_cpt['ID'],
			'post_content' => wp_slash( wp_json_encode( $variation ) ),
		)
	);

	// The resolver caches user data per request; a starter applied and then read
	// back in the same run would otherwise see the old styles.
	WP_Theme_JSON_Resolver::clean_cached_data();
}

/**
 * Build a navigation menu for the starter's pages and make it the site menu.
 *
 * @param array $site    Starter site definition.
 * @param array $created Created page IDs keyed by page key.
 */
/**
 * The archive URL a starter page would collide with, if any.
 *
 * The course archive lives at /courses/ when Academia Library is active, so a
 * starter that also wants a "Courses" page would create one WordPress can never
 * serve. This returns the archive URL in that case so the caller can link to it
 * rather than create a dead page.
 *
 * @param string $title Starter page title.
 * @return string Archive URL, or an empty string when there is no collision.
 */
function academia_starter_archive_url( $title ) {
	$slug = sanitize_title( $title );

	if ( '' === $slug ) {
		return '';
	}

	foreach ( get_post_types( array( 'has_archive' => true ), 'objects' ) as $type ) {
		$archive_slug = is_string( $type->has_archive ) ? $type->has_archive : $type->name;

		if ( isset( $type->rewrite['slug'] ) && is_string( $type->rewrite['slug'] ) ) {
			$archive_slug = $type->rewrite['slug'];
		}

		if ( $slug !== $archive_slug ) {
			continue;
		}

		$url = get_post_type_archive_link( $type->name );

		if ( $url ) {
			return $url;
		}
	}

	return '';
}

function academia_build_starter_menu( $site, $created ) {
	$items = '';

	foreach ( $site['pages'] as $key => $page ) {
		// An entry resolved to a post-type archive has a URL but no page ID, so
		// it is a custom link rather than a post-type link.
		if ( ! empty( $created[ $key . '_archive' ] ) ) {
			$items .= sprintf(
				'<!-- wp:navigation-link {"label":"%1$s","url":"%2$s","kind":"custom","isTopLevelLink":true} /-->' . "\n",
				esc_attr( $page['title'] ),
				esc_url( $created[ $key . '_archive' ] )
			);

			continue;
		}

		if ( empty( $created[ $key ] ) ) {
			continue;
		}
		$items .= sprintf(
			'<!-- wp:navigation-link {"label":"%1$s","url":"%2$s","kind":"post-type","type":"page","id":%3$d} /-->' . "\n",
			esc_attr( $page['title'] ),
			esc_url( get_permalink( $created[ $key ] ) ),
			absint( $created[ $key ] )
		);
	}

	if ( ! empty( $created['blog'] ) ) {
		$items .= sprintf(
			'<!-- wp:navigation-link {"label":"%1$s","url":"%2$s","kind":"post-type","type":"page","id":%3$d} /-->' . "\n",
			esc_attr__( 'Blog', 'academia' ),
			esc_url( get_permalink( $created['blog'] ) ),
			absint( $created['blog'] )
		);
	}

	if ( '' === $items ) {
		return;
	}

	$kses_active = has_filter( 'content_save_pre', 'wp_filter_post_kses' );
	if ( $kses_active ) {
		kses_remove_filters();
	}

	$existing = get_posts(
		array(
			'post_type'      => 'wp_navigation',
			'post_status'    => 'publish',
			'posts_per_page' => 1,
			'orderby'        => 'date',
			'order'          => 'DESC',
		)
	);

	$args = array(
		'post_type'    => 'wp_navigation',
		'post_status'  => 'publish',
		'post_title'   => __( 'Navigation', 'academia' ),
		'post_content' => wp_slash( trim( $items ) ),
	);

	if ( $existing ) {
		$args['ID'] = $existing[0]->ID;
		wp_update_post( $args );
	} else {
		wp_insert_post( $args );
	}

	if ( $kses_active ) {
		kses_init_filters();
	}
}

/**
 * A template part saved into the database by a starter site, if any.
 *
 * @param string $name Part slug: 'header' or 'footer'.
 * @return WP_Post|null
 */
function academia_get_customised_part( $name ) {
	$parts = get_posts(
		array(
			'post_type'      => 'wp_template_part',
			'post_status'    => 'publish',
			'name'           => $name,
			'posts_per_page' => 1,
			'tax_query'      => array(
				array(
					'taxonomy' => 'wp_theme',
					'field'    => 'name',
					'terms'    => get_stylesheet(),
				),
			),
		)
	);

	return $parts ? $parts[0] : null;
}

/**
 * The customised header template part saved by a starter site, if any.
 *
 * @return WP_Post|null
 */
function academia_get_customised_header() {
	return academia_get_customised_part( 'header' );
}

/**
 * Point a template part at one of the theme's own patterns.
 *
 * Starters swap the footer this way: the saved part is a single pattern
 * reference, exactly what parts/footer.html contains, so the wording stays
 * translatable and the user can still edit it in the Site Editor afterwards.
 *
 * @param string $name    Part slug: 'header' or 'footer'.
 * @param string $title   Part title.
 * @param string $pattern Pattern slug to reference, or '' to restore the theme file.
 */
function academia_set_part_to_pattern( $name, $title, $pattern ) {
	$existing = academia_get_customised_part( $name );

	if ( '' === $pattern ) {
		if ( $existing ) {
			wp_delete_post( $existing->ID, true );
		}
		return;
	}

	if ( ! WP_Block_Patterns_Registry::get_instance()->is_registered( $pattern ) ) {
		return;
	}

	$args = array(
		'post_type'    => 'wp_template_part',
		'post_status'  => 'publish',
		'post_title'   => $title,
		'post_name'    => $name,
		'post_content' => wp_slash( '<!-- wp:pattern {"slug":"' . $pattern . '"} /-->' ),
	);

	if ( $existing ) {
		$args['ID'] = $existing->ID;
		$part_id    = wp_update_post( $args );
	} else {
		$part_id = wp_insert_post( $args );
	}

	if ( $part_id && ! is_wp_error( $part_id ) ) {
		wp_set_object_terms( $part_id, get_stylesheet(), 'wp_theme' );
		wp_set_object_terms( $part_id, $name, 'wp_template_part_area' );
	}
}

/**
 * Give the footer the starter's own wording, links and contact details.
 *
 * @param array $site Starter site definition.
 */
function academia_apply_starter_footer( $site ) {
	$pattern = isset( $site['footer'] ) ? $site['footer'] : '';
	academia_set_part_to_pattern( 'footer', __( 'Footer', 'academia' ), $pattern );
}

/**
 * Give the header the starter's own call-to-action label.
 *
 * The header pattern ships with a SaaS label, which reads oddly on a church or
 * a gym. This saves a customised copy of the header template part with the
 * starter's wording — the same thing the user would get by editing the header
 * in the Site Editor.
 *
 * @param array $site Starter site definition.
 */
function academia_apply_starter_header( $site ) {
	$default  = _x( 'Get Premium', 'Header call-to-action button', 'academia' );
	$existing = academia_get_customised_header();

	// A starter that uses the theme's own wording needs no customised part. Remove
	// any left over from a previous starter so the header file takes over again.
	if ( empty( $site['cta'] ) || $site['cta'] === $default ) {
		if ( $existing ) {
			wp_delete_post( $existing->ID, true );
		}
		return;
	}

	$markup = academia_get_pattern_markup( 'academia/header' );
	if ( '' === $markup || false === strpos( $markup, $default ) ) {
		return;
	}

	$markup = str_replace( '>' . $default . '<', '>' . $site['cta'] . '<', $markup );

	$kses_active = has_filter( 'content_save_pre', 'wp_filter_post_kses' );
	if ( $kses_active ) {
		kses_remove_filters();
	}

	$args = array(
		'post_type'    => 'wp_template_part',
		'post_status'  => 'publish',
		'post_title'   => __( 'Header', 'academia' ),
		'post_name'    => 'header',
		'post_content' => wp_slash( $markup ),
	);

	if ( $existing ) {
		$args['ID'] = $existing->ID;
		$part_id    = wp_update_post( $args );
	} else {
		$part_id = wp_insert_post( $args );
	}

	if ( $kses_active ) {
		kses_init_filters();
	}

	if ( $part_id && ! is_wp_error( $part_id ) ) {
		wp_set_object_terms( $part_id, get_stylesheet(), 'wp_theme' );
		wp_set_object_terms( $part_id, 'header', 'wp_template_part_area' );
	}
}

/**
 * Register the starter sites screen under Appearance.
 */
function academia_starter_menu() {
	add_theme_page(
		__( 'Starter Sites', 'academia' ),
		__( 'Starter Sites', 'academia' ),
		'edit_theme_options',
		'academia-starter-sites',
		'academia_render_starter_screen'
	);
}
add_action( 'admin_menu', 'academia_starter_menu' );

/**
 * Handle the apply request.
 */
function academia_handle_starter_request() {
	check_admin_referer( 'academia_apply_starter' );

	if ( ! current_user_can( 'edit_theme_options' ) ) {
		wp_die( esc_html__( 'You are not allowed to change the site design.', 'academia' ), 403 );
	}

	$slug   = isset( $_POST['starter'] ) ? sanitize_key( wp_unslash( $_POST['starter'] ) ) : '';
	$result = academia_apply_starter_site( $slug );

	set_transient( ACADEMIA_STARTER_RESULT, is_wp_error( $result ) ? 'error' : 'done', HOUR_IN_SECONDS );
	wp_safe_redirect( admin_url( 'themes.php?page=academia-starter-sites' ) );
	exit;
}
add_action( 'admin_post_academia_apply_starter', 'academia_handle_starter_request' );

/**
 * Render the starter sites screen.
 */
function academia_render_starter_screen() {
	// phpcs:disable WordPress.Security.NonceVerification.Recommended -- read-only navigation between wizard steps.
	$step    = isset( $_GET['step'] ) ? sanitize_key( wp_unslash( $_GET['step'] ) ) : '';
	$starter = isset( $_GET['starter'] ) ? sanitize_key( wp_unslash( $_GET['starter'] ) ) : '';
	$sites   = academia_get_starter_sites();

	if ( 'done' === $step ) {
		echo '<div class="wrap academia-starters">';
		academia_wizard_render_done();
		academia_starter_styles();
		echo '</div>';
		return;
	}

	if ( isset( $sites[ $starter ] ) && in_array( $step, array( 'brand', 'plugins' ), true ) ) {
		echo '<div class="wrap academia-starters">';
		echo '<h1>' . esc_html__( 'Set up your site', 'academia' ) . '</h1>';
		academia_wizard_steps( $step );

		if ( 'brand' === $step ) {
			academia_wizard_render_brand( $starter );
		} else {
			academia_wizard_render_plugins(
				$starter,
				array(
					'title'   => isset( $_GET['site_title'] ) ? sanitize_text_field( wp_unslash( $_GET['site_title'] ) ) : '',
					'tagline' => isset( $_GET['tagline'] ) ? sanitize_text_field( wp_unslash( $_GET['tagline'] ) ) : '',
					'logo'    => isset( $_GET['logo_id'] ) ? absint( $_GET['logo_id'] ) : 0,
					'colors'  => isset( $_GET['colors'] ) ? sanitize_key( wp_unslash( $_GET['colors'] ) ) : '',
					'type'    => isset( $_GET['typography'] ) ? sanitize_key( wp_unslash( $_GET['typography'] ) ) : '',
				)
			);
		}

		academia_starter_styles();
		echo '</div>';
		return;
	}
	// phpcs:enable WordPress.Security.NonceVerification.Recommended

	$sites  = academia_get_starter_sites();
	$active = get_option( ACADEMIA_STARTER_OPTION, array() );
	$result = get_transient( ACADEMIA_STARTER_RESULT );

	if ( $result ) {
		delete_transient( ACADEMIA_STARTER_RESULT );
	}
	?>
	<div class="wrap academia-starters">
		<h1><?php esc_html_e( 'Academia starter sites', 'academia' ); ?></h1>
		<p class="academia-starters__intro">
			<?php esc_html_e( 'Each starter builds a complete site for one kind of business: a colour palette, a typeface, a home page and its supporting pages, and a matching menu. Setting one up takes three short steps — the starter, your name and look, then anything it needs installing. Your existing pages are never deleted.', 'academia' ); ?>
		</p>

		<?php if ( 'done' === $result ) : ?>
			<div class="notice notice-success"><p>
				<?php
				printf(
					/* translators: %s: link to the site front page. */
					wp_kses_post( __( 'Starter site applied. <a href="%s">View your site</a>.', 'academia' ) ),
					esc_url( home_url( '/' ) )
				);
				?>
			</p></div>
		<?php elseif ( 'error' === $result ) : ?>
			<div class="notice notice-error"><p><?php esc_html_e( 'That starter site could not be applied. Please try again.', 'academia' ); ?></p></div>
		<?php endif; ?>

		<div class="academia-starters__grid">
			<?php foreach ( $sites as $slug => $site ) : ?>
				<?php $is_active = isset( $active['slug'] ) && $active['slug'] === $slug; ?>
				<div class="academia-starter<?php echo $is_active ? ' is-active' : ''; ?>">
					<div class="academia-starter__preview"
						style="background:linear-gradient(135deg, <?php echo esc_attr( $site['swatches'][0] ); ?> 0%, <?php echo esc_attr( $site['swatches'][1] ); ?> 100%)">
						<?php
						// A starter added by a plugin carries its own thumbnail URL;
						// the theme's own starters name a bundled file.
						$academia_thumb = '';
						if ( ! empty( $site['thumb_url'] ) ) {
							$academia_thumb = $site['thumb_url'];
						} elseif ( ! empty( $site['thumb'] ) && file_exists( get_theme_file_path( 'assets/images/starters/' . $site['thumb'] . '.webp' ) ) ) {
							$academia_thumb = get_theme_file_uri( 'assets/images/starters/' . $site['thumb'] . '.webp' );
						}
						?>
						<?php if ( $academia_thumb ) : ?>
							<img src="<?php echo esc_url( $academia_thumb ); ?>"
								alt="<?php
								/* translators: %s: starter site name. */
								echo esc_attr( sprintf( __( 'The home page the %s starter builds', 'academia' ), $site['title'] ) );
								?>" loading="lazy" decoding="async" width="640" height="480">
						<?php else : ?>
							<span class="academia-starter__preview-card" aria-hidden="true"></span>
						<?php endif; ?>
					</div>
					<div class="academia-starter__body">
						<h2><?php echo esc_html( $site['title'] ); ?><?php echo $is_active ? ' <span class="academia-starter__badge">' . esc_html__( 'Applied', 'academia' ) . '</span>' : ''; ?></h2>
						<p class="academia-starter__swatches" aria-hidden="true">
							<?php foreach ( $site['swatches'] as $academia_swatch ) : ?>
								<span style="background:<?php echo esc_attr( $academia_swatch ); ?>"></span>
							<?php endforeach; ?>
						</p>
						<p><?php echo esc_html( $site['summary'] ); ?></p>
						<?php $academia_page_count = count( $site['pages'] ) + 1; ?>
						<p class="academia-starter__meta">
							<?php
							printf(
								/* translators: %d: number of pages the starter creates. */
								esc_html( _n( 'Creates %d page', 'Creates %d pages', $academia_page_count, 'academia' ) ),
								absint( $academia_page_count )
							);
							?>
						</p>
						<div class="academia-starter__buttons">
							<a class="button button-primary" href="<?php echo esc_url( add_query_arg( array( 'page' => 'academia-starter-sites', 'step' => 'brand', 'starter' => $slug ), admin_url( 'themes.php' ) ) ); ?>">
								<?php echo $is_active ? esc_html__( 'Set up again', 'academia' ) : esc_html__( 'Set up this starter', 'academia' ); ?>
							</a>
							<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
								<?php wp_nonce_field( 'academia_apply_starter' ); ?>
								<input type="hidden" name="action" value="academia_apply_starter">
								<input type="hidden" name="starter" value="<?php echo esc_attr( $slug ); ?>">
								<button type="submit" class="button-link academia-starter__skip">
									<?php esc_html_e( 'Apply without setup', 'academia' ); ?>
								</button>
							</form>
						</div>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
	<?php
	academia_starter_styles();
}

/**
 * The step indicator shown above every wizard step.
 *
 * @param string $current Current step key.
 */
function academia_wizard_steps( $current ) {
	$steps = array(
		'choose'  => __( 'Choose a starter', 'academia' ),
		'brand'   => __( 'Name and look', 'academia' ),
		'plugins' => __( 'Finish', 'academia' ),
	);
	$keys  = array_keys( $steps );
	$at    = array_search( $current, $keys, true );
	$at    = false === $at ? 0 : $at;
	$n     = 0;

	echo '<ol class="academia-steps">';
	foreach ( $steps as $key => $label ) {
		$state = $n === $at ? ' is-current' : ( $n < $at ? ' is-done' : '' );
		printf(
			'<li class="academia-step%s"><span class="academia-step__n">%d</span>%s</li>',
			esc_attr( $state ),
			absint( $n + 1 ),
			esc_html( $label )
		);
		++$n;
	}
	echo '</ol>';
}

/**
 * Styles for the starter screen and the wizard.
 */
function academia_starter_styles() {
	?>
	<style>
		.academia-starters__intro { max-width: 70ch; }
		.academia-starters__grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 20px; margin-top: 24px; }
		.academia-starter { background: #fff; border: 1px solid #dcdcde; border-radius: 8px; overflow: hidden; display: flex; flex-direction: column; }
		.academia-starter.is-active { border-color: #2271b1; box-shadow: 0 0 0 1px #2271b1; }
		.academia-starter__preview { height: 190px; display: flex; align-items: flex-end; justify-content: center; padding: 0 24px; overflow: hidden; }
		.academia-starter__preview img { display: block; width: 100%; height: 100%; object-fit: cover; object-position: top center; padding: 0; }
		.academia-starter__swatches { display: flex; gap: 4px; margin: 0 0 2px !important; }
		.academia-starter__swatches span { width: 13px; height: 13px; border-radius: 50%; box-shadow: inset 0 0 0 1px rgba(0,0,0,.12); }
		.academia-starter__preview-card { display: block; width: 100%; height: 62px; background: #fff; border-radius: 8px 8px 0 0; box-shadow: 0 -6px 18px rgba(0,0,0,.12); }
		.academia-starter__body { padding: 16px 20px 20px; display: flex; flex-direction: column; gap: 8px; flex: 1; }
		.academia-starter__body h2 { font-size: 15px; margin: 0; }
		.academia-starter__badge { display: inline-block; margin-inline-start: 6px; padding: 1px 8px; border-radius: 999px; background: #2271b1; color: #fff; font-size: 11px; vertical-align: middle; }
		.academia-starter__body p { margin: 0; color: #50575e; font-size: 13px; }
		.academia-starter__meta { color: #787c82 !important; font-size: 12px !important; }
		.academia-starter form { margin-top: 0; padding-top: 0; }
		.academia-starter__buttons { margin-top: auto; padding-top: 10px; display: flex; align-items: center; gap: 14px; flex-wrap: wrap; }
		.academia-starter__skip { color: #787c82 !important; font-size: 12px; text-decoration: underline; }
		.academia-steps { display: flex; flex-wrap: wrap; gap: 8px 28px; list-style: none; margin: 20px 0 26px; padding: 0; }
		.academia-step { display: flex; align-items: center; gap: 8px; color: #787c82; font-size: 13px; }
		.academia-step__n { display: inline-flex; align-items: center; justify-content: center; width: 22px; height: 22px; border-radius: 50%; background: #dcdcde; color: #50575e; font-size: 12px; font-weight: 600; }
		.academia-step.is-current { color: #1d2327; font-weight: 600; }
		.academia-step.is-current .academia-step__n { background: #2271b1; color: #fff; }
		.academia-step.is-done .academia-step__n { background: #00a32a; color: #fff; }
		.academia-wizard { max-width: 820px; }
		.academia-wizard h2 { margin-top: 0; font-size: 1.5rem; }
		.academia-wizard__lede { max-width: 68ch; color: #50575e; font-size: 14px; }
		.academia-wizard__hint { color: #787c82; font-size: 13px; margin-top: -6px; }
		.academia-wizard__panel { background: #fff; border: 1px solid #dcdcde; border-radius: 8px; padding: 18px 20px; margin: 18px 0; }
		.academia-wizard__panel h3 { margin-top: 0; font-size: 14px; }
		.academia-field { display: block; margin-bottom: 14px; }
		.academia-field label, .academia-field__label { display: block; font-weight: 600; font-size: 13px; margin-bottom: 4px; }
		.academia-field input[type="text"] { width: 100%; max-width: 420px; }
		.academia-logo { display: flex; align-items: center; gap: 12px; flex-wrap: wrap; }
		.academia-logo__preview { max-width: 140px; max-height: 60px; border: 1px solid #dcdcde; border-radius: 6px; padding: 4px; background: #fff; }
		.academia-swatches { display: grid; grid-template-columns: repeat(auto-fill, minmax(170px, 1fr)); gap: 10px; }
		.academia-swatches--type { grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); }
		.academia-swatch { display: flex; align-items: center; gap: 10px; padding: 10px 12px; border: 1px solid #dcdcde; border-radius: 8px; cursor: pointer; font-size: 13px; background: #fff; }
		.academia-swatch:has(input:checked) { border-color: #2271b1; box-shadow: 0 0 0 1px #2271b1; }
		.academia-swatch input { margin: 0; }
		.academia-swatch__dots { display: inline-flex; }
		.academia-swatch__dots span { width: 15px; height: 15px; border-radius: 50%; box-shadow: inset 0 0 0 1px rgba(0,0,0,.12); }
		.academia-swatch__dots span + span { margin-left: -5px; }
		.academia-plugin { display: flex; align-items: center; justify-content: space-between; gap: 20px; padding: 12px 0; border-bottom: 1px solid #f0f0f1; }
		.academia-plugin:last-child { border-bottom: 0; }
		.academia-plugin p { margin: 4px 0 0; color: #50575e; font-size: 13px; max-width: 60ch; }
		.academia-wizard__summary { background: #fff; border: 1px solid #dcdcde; border-radius: 8px; padding: 18px 20px; margin: 18px 0; }
		.academia-wizard__summary h3 { margin-top: 0; font-size: 14px; }
		.academia-wizard__summary ul { margin: 10px 0 0 18px; color: #50575e; font-size: 13px; list-style: disc; }
		.academia-wizard__actions { display: flex; align-items: center; gap: 10px; margin-top: 22px; }
		.academia-wizard--done { text-align: left; }
	</style>
	<?php
}
