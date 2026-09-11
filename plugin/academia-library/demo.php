<?php
/**
 * One-click demo courses.
 *
 * A course catalogue is the one thing a new Academia site cannot fake: the
 * grids are dynamic, so an empty install shows empty states everywhere and the
 * theme looks broken rather than new. This creates nine real courses across
 * three subjects and three levels so every course section has something to
 * render from the first minute.
 *
 * It never overwrites. Running it twice creates nothing new, because each
 * course is matched on its slug first.
 *
 * @package Academia_Library
 */

defined( 'ABSPATH' ) || exit;

/** Option recording that the demo content was created. */
const ACADEMIA_LIBRARY_DEMO_DONE = 'academia_library_demo_courses';

/**
 * The demo catalogue.
 *
 * @return array[]
 */
function academia_library_demo_courses() {
	return array(
		array(
			'slug'     => 'foundations-of-interface-design',
			'image'    => 'course-1.avif',
			'title'    => __( 'Foundations of interface design', 'academia-library' ),
			'excerpt'  => __( 'Grids, type and colour — the decisions behind interfaces people trust.', 'academia-library' ),
			'subject'  => __( 'Design', 'academia-library' ),
			'level'    => __( 'Beginner', 'academia-library' ),
			'duration' => __( '8 weeks', 'academia-library' ),
			'lessons'  => 24,
			'price'    => '149',
			'tutor'    => __( 'Dana Okoye', 'academia-library' ),
			'rating'   => '4.9',
			'reviews'  => 128,
		),
		array(
			'slug'     => 'typography-for-screens',
			'image'    => 'course-2.avif',
			'title'    => __( 'Typography for screens', 'academia-library' ),
			'excerpt'  => __( 'Choosing, pairing and setting type that stays readable at every size.', 'academia-library' ),
			'subject'  => __( 'Design', 'academia-library' ),
			'level'    => __( 'Intermediate', 'academia-library' ),
			'duration' => __( '6 weeks', 'academia-library' ),
			'lessons'  => 18,
			'price'    => '129',
			'tutor'    => __( 'Dana Okoye', 'academia-library' ),
			'rating'   => '4.8',
			'reviews'  => 64,
		),
		array(
			'slug'     => 'accessible-by-default',
			'image'    => 'course-3.avif',
			'title'    => __( 'Accessible by default', 'academia-library' ),
			'excerpt'  => __( 'Build interfaces that work for everyone, and prove that they do.', 'academia-library' ),
			'subject'  => __( 'Design', 'academia-library' ),
			'level'    => __( 'Advanced', 'academia-library' ),
			'duration' => __( '5 weeks', 'academia-library' ),
			'lessons'  => 15,
			'price'    => '',
			'tutor'    => __( 'Priya Raman', 'academia-library' ),
			'rating'   => '5.0',
			'reviews'  => 41,
		),
		array(
			'slug'     => 'javascript-for-the-web',
			'image'    => 'course-4.avif',
			'title'    => __( 'JavaScript for the web', 'academia-library' ),
			'excerpt'  => __( 'From the language itself to shipping an app people can actually use.', 'academia-library' ),
			'subject'  => __( 'Development', 'academia-library' ),
			'level'    => __( 'Intermediate', 'academia-library' ),
			'duration' => __( '12 weeks', 'academia-library' ),
			'lessons'  => 36,
			'price'    => '249',
			'tutor'    => __( 'Marcus Hale', 'academia-library' ),
			'rating'   => '4.9',
			'reviews'  => 212,
		),
		array(
			'slug'     => 'html-and-css-from-scratch',
			'image'    => 'course-5.avif',
			'title'    => __( 'HTML and CSS from scratch', 'academia-library' ),
			'excerpt'  => __( 'The two languages the whole web is built from, properly this time.', 'academia-library' ),
			'subject'  => __( 'Development', 'academia-library' ),
			'level'    => __( 'Beginner', 'academia-library' ),
			'duration' => __( '10 weeks', 'academia-library' ),
			'lessons'  => 30,
			'price'    => '179',
			'tutor'    => __( 'Marcus Hale', 'academia-library' ),
			'rating'   => '4.7',
			'reviews'  => 189,
		),
		array(
			'slug'     => 'building-for-performance',
			'image'    => 'course-6.avif',
			'title'    => __( 'Building for performance', 'academia-library' ),
			'excerpt'  => __( 'Measure what is slow, fix the part that matters, and keep it fixed.', 'academia-library' ),
			'subject'  => __( 'Development', 'academia-library' ),
			'level'    => __( 'Advanced', 'academia-library' ),
			'duration' => __( '6 weeks', 'academia-library' ),
			'lessons'  => 16,
			'price'    => '199',
			'tutor'    => __( 'Marcus Hale', 'academia-library' ),
			'rating'   => '4.8',
			'reviews'  => 57,
		),
		array(
			'slug'     => 'analysis-with-python',
			'image'    => 'course-1.avif',
			'title'    => __( 'Analysis with Python', 'academia-library' ),
			'excerpt'  => __( 'Clean a messy dataset, ask it a question, and defend the answer.', 'academia-library' ),
			'subject'  => __( 'Data & analytics', 'academia-library' ),
			'level'    => __( 'Intermediate', 'academia-library' ),
			'duration' => __( '10 weeks', 'academia-library' ),
			'lessons'  => 30,
			'price'    => '199',
			'tutor'    => __( 'Priya Raman', 'academia-library' ),
			'rating'   => '4.9',
			'reviews'  => 143,
		),
		array(
			'slug'     => 'statistics-without-fear',
			'image'    => 'course-2.avif',
			'title'    => __( 'Statistics without fear', 'academia-library' ),
			'excerpt'  => __( 'The handful of ideas that make the rest of statistics make sense.', 'academia-library' ),
			'subject'  => __( 'Data & analytics', 'academia-library' ),
			'level'    => __( 'Beginner', 'academia-library' ),
			'duration' => __( '8 weeks', 'academia-library' ),
			'lessons'  => 22,
			'price'    => '159',
			'tutor'    => __( 'Priya Raman', 'academia-library' ),
			'rating'   => '4.6',
			'reviews'  => 78,
		),
		array(
			'slug'     => 'telling-the-story-in-the-data',
			'image'    => 'course-3.avif',
			'title'    => __( 'Telling the story in the data', 'academia-library' ),
			'excerpt'  => __( 'Charts that answer a question, and the judgement to pick which one.', 'academia-library' ),
			'subject'  => __( 'Data & analytics', 'academia-library' ),
			'level'    => __( 'Advanced', 'academia-library' ),
			'duration' => __( '5 weeks', 'academia-library' ),
			'lessons'  => 14,
			'price'    => '139',
			'tutor'    => __( 'Tomas Bergström', 'academia-library' ),
			'rating'   => '4.9',
			'reviews'  => 33,
		),
	);
}

/**
 * Create the demo courses.
 *
 * @return array{created:int, skipped:int}
 */
function academia_library_create_demo() {
	$created = 0;
	$skipped = 0;

	foreach ( academia_library_demo_courses() as $course ) {
		$existing = get_page_by_path( $course['slug'], OBJECT, 'academia_course' );

		if ( $existing ) {
			++$skipped;

			continue;
		}

		$post_id = wp_insert_post( array(
			'post_type'    => 'academia_course',
			'post_status'  => 'publish',
			'post_title'   => $course['title'],
			'post_name'    => $course['slug'],
			'post_excerpt' => $course['excerpt'],
			'post_content' => academia_library_demo_body( $course ),
		), true );

		if ( is_wp_error( $post_id ) ) {
			continue;
		}

		academia_library_attach_image( $post_id, $course['image'] );

		wp_set_object_terms( $post_id, $course['subject'], 'academia_course_category' );
		wp_set_object_terms( $post_id, $course['level'], 'academia_course_level' );

		update_post_meta( $post_id, '_academia_duration', $course['duration'] );
		update_post_meta( $post_id, '_academia_lessons', (int) $course['lessons'] );
		update_post_meta( $post_id, '_academia_instructor', $course['tutor'] );
		update_post_meta( $post_id, '_academia_rating', (float) $course['rating'] );
		update_post_meta( $post_id, '_academia_reviews', (int) $course['reviews'] );

		if ( '' !== $course['price'] ) {
			update_post_meta( $post_id, '_academia_price', $course['price'] );
		}

		++$created;
	}

	update_option( ACADEMIA_LIBRARY_DEMO_DONE, time() );

	return array( 'created' => $created, 'skipped' => $skipped );
}

/**
 * Block markup for a demo course body.
 *
 * @param array $course Course definition.
 * @return string
 */
function academia_library_demo_body( $course ) {
	$intro = sprintf(
		/* translators: %s: course excerpt. */
		__( '%s This page is demo content — replace it with your own syllabus.', 'academia-library' ),
		$course['excerpt']
	);

	$out  = '<!-- wp:paragraph -->' . "\n" . '<p>' . esc_html( $intro ) . '</p>' . "\n" . '<!-- /wp:paragraph -->' . "\n\n";
	$out .= '<!-- wp:heading -->' . "\n" . '<h2 class="wp-block-heading">' . esc_html__( 'What you will learn', 'academia-library' ) . '</h2>' . "\n" . '<!-- /wp:heading -->' . "\n\n";
	$out .= '<!-- wp:list {"className":"is-style-academia-checklist"} -->' . "\n";
	$out .= '<ul class="wp-block-list is-style-academia-checklist">' . "\n";

	foreach ( array(
		__( 'The core ideas, in the order they build on each other', 'academia-library' ),
		__( 'A weekly workshop applying them to your own work', 'academia-library' ),
		__( 'An assessed piece you can show an employer', 'academia-library' ),
	) as $item ) {
		$out .= '<!-- wp:list-item -->' . "\n" . '<li>' . esc_html( $item ) . '</li>' . "\n" . '<!-- /wp:list-item -->' . "\n";
	}

	$out .= '</ul>' . "\n" . '<!-- /wp:list -->' . "\n\n";
	$out .= '<!-- wp:pattern {"slug":"academia/course-curriculum"} /-->';

	return $out;
}


/**
 * Attach one of the theme's own course images as a featured image.
 *
 * The plugin ships no images of its own: it copies from whichever theme is
 * active, so the demo matches the design and the plugin stays small. A theme
 * without that file simply gets a course with no image, which the card already
 * handles.
 *
 * The copy is deliberate rather than pointing the attachment at the theme
 * directory: an attachment has to live in the uploads folder to survive a theme
 * switch, and to be croppable and replaceable like any other media item.
 *
 * @param int    $post_id Course ID.
 * @param string $file    File name inside the theme's assets/images directory.
 * @return int Attachment ID, or 0.
 */
function academia_library_attach_image( $post_id, $file ) {
	$file = basename( (string) $file );

	if ( '' === $file ) {
		return 0;
	}

	$source = get_theme_file_path( 'assets/images/' . $file );

	if ( ! file_exists( $source ) ) {
		return 0;
	}

	// Reuse the attachment if a previous run already imported this file.
	$existing = get_posts( array(
		'post_type'      => 'attachment',
		'post_status'    => 'inherit',
		'posts_per_page' => 1,
		'fields'         => 'ids',
		'meta_key'       => '_academia_demo_source',
		'meta_value'     => $file,
	) );

	if ( $existing ) {
		set_post_thumbnail( $post_id, (int) $existing[0] );

		return (int) $existing[0];
	}

	require_once ABSPATH . 'wp-admin/includes/file.php';
	require_once ABSPATH . 'wp-admin/includes/image.php';
	require_once ABSPATH . 'wp-admin/includes/media.php';

	$temp = wp_tempnam( $file );

	if ( ! $temp || ! copy( $source, $temp ) ) {
		return 0;
	}

	$attachment_id = media_handle_sideload(
		array( 'name' => $file, 'tmp_name' => $temp ),
		$post_id,
		null,
		array( 'post_title' => __( 'Course image', 'academia-library' ) )
	);

	// media_handle_sideload deletes the temp file on success only.
	if ( is_wp_error( $attachment_id ) ) {
		if ( file_exists( $temp ) ) {
			wp_delete_file( $temp );
		}

		return 0;
	}

	update_post_meta( $attachment_id, '_academia_demo_source', $file );
	set_post_thumbnail( $post_id, $attachment_id );

	return (int) $attachment_id;
}

/**
 * The Tools screen entry.
 */
function academia_library_demo_menu() {
	add_management_page(
		__( 'Academia demo courses', 'academia-library' ),
		__( 'Academia courses', 'academia-library' ),
		'manage_options',
		'academia-demo-courses',
		'academia_library_demo_screen'
	);
}
add_action( 'admin_menu', 'academia_library_demo_menu' );

/**
 * Render the Tools screen.
 */
function academia_library_demo_screen() {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( esc_html__( 'You are not allowed to do that.', 'academia-library' ), '', array( 'response' => 403 ) );
	}

	$done  = get_option( ACADEMIA_LIBRARY_DEMO_DONE );
	$count = (int) wp_count_posts( 'academia_course' )->publish;

	echo '<div class="wrap">';
	echo '<h1>' . esc_html__( 'Academia demo courses', 'academia-library' ) . '</h1>';

	if ( isset( $_GET['academia_demo'] ) ) {
		$created = isset( $_GET['created'] ) ? absint( wp_unslash( $_GET['created'] ) ) : 0;

		echo '<div class="notice notice-success"><p>' . esc_html( sprintf(
			/* translators: %d: number of courses created. */
			_n( '%d course created.', '%d courses created.', $created, 'academia-library' ),
			$created
		) ) . '</p></div>';
	}

	echo '<p>' . esc_html__( 'Academia\'s course sections are dynamic, so a site with no courses shows empty states. This creates nine example courses across three subjects and three levels, so every section has something to render while you build.', 'academia-library' ) . '</p>';
	echo '<p>' . esc_html( sprintf(
		/* translators: %d: number of published courses. */
		_n( 'You currently have %d published course.', 'You currently have %d published courses.', $count, 'academia-library' ),
		$count
	) ) . '</p>';

	if ( $done ) {
		echo '<p><em>' . esc_html__( 'Demo courses have been created before. Running this again only fills in any that are missing — nothing you have edited is overwritten.', 'academia-library' ) . '</em></p>';
	}

	echo '<p><a class="button button-primary" href="' . esc_url( wp_nonce_url(
		admin_url( 'admin-post.php?action=academia_create_demo' ),
		'academia_create_demo'
	) ) . '">' . esc_html__( 'Create demo courses', 'academia-library' ) . '</a></p>';
	echo '</div>';
}

/**
 * Handle the button.
 */
function academia_library_handle_demo() {
	check_admin_referer( 'academia_create_demo' );

	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( esc_html__( 'You are not allowed to do that.', 'academia-library' ), '', array( 'response' => 403 ) );
	}

	$result = academia_library_create_demo();

	wp_safe_redirect( add_query_arg(
		array( 'academia_demo' => 'done', 'created' => $result['created'] ),
		admin_url( 'tools.php?page=academia-demo-courses' )
	) );
	exit;
}
add_action( 'admin_post_academia_create_demo', 'academia_library_handle_demo' );
