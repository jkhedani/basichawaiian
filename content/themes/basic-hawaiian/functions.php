<?php
/**
 * Basic Hawaiian functions and definitions
 *
 * @package Basic Hawaiian
 */

if ( ! function_exists( 'basic_hawaiian_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function basic_hawaiian_setup() {

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on Basic Hawaiian, use a find and replace
	 * to change 'basic-hawaiian' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'basic-hawaiian', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary-menu' => esc_html__( 'Primary Menu', 'basic-hawaiian' ),
		'public-menu' => esc_html__( 'Public Menu', 'basic-hawaiian' ),
		'footer-menu' => esc_html__( 'Footer Menu', 'basic-hawaiian' ),
	) );


	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 * See http://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside', 'image', 'video', 'quote', 'link',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'basic_hawaiian_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );

	/**
	 * Remove Roles
	 */
	if ( !role_exists('subscriber') ) :
		remove_role( 'subscriber' );
	elseif ( role_exists('contributor') ) :
		remove_role( 'contributor' );
	elseif ( role_exists('teacher') ) :
		remove_role( 'teacher' );
	elseif ( role_exists('author') ) :
		remove_role( 'author' );
	elseif ( role_exists('editor') ) :
		remove_role( 'editor' );
	endif;

	/**
	 * Add User Roles
	 */
	 if ( !role_exists('nonpaid') ) :
 		$result = add_role(
 			'nonpaid',
 			__( 'Nonpaid' ),
 			array(
 					'read'         => true,  // true allows this capability
 			)
 		);
	elseif ( !role_exists('student') ) :
		$result = add_role(
			'student',
			__( 'Student' ),
			array(
					'read'         => true,  // true allows this capability
			)
		);
	elseif( !role_exists('teacher') ) :
		$result = add_role(
			'teacher',
			__( 'Teacher' ),
			array(
				'delete_posts',
				'delete_published_posts',
				'edit_posts',
				'edit_published_posts',
				'publish_posts',
				'read',
				'upload_files',
			)
		);
		elseif( !role_exists('employee') ) :
			$result = add_role(
				'employee',
				__( 'Employee' ),
				array(
					'delete_others_pages',
					'delete_others_posts',
					'delete_pages',
					'delete_posts',
					'delete_private_pages',
					'delete_private_posts',
					'delete_published_pages',
					'delete_published_posts',
					'edit_others_pages',
					'edit_others_posts',
					'edit_pages',
					'edit_posts',
					'edit_private_pages',
					'edit_private_posts',
					'edit_published_pages',
					'edit_published_posts',
					'manage_categories',
					'manage_links',
					'moderate_comments',
					'publish_pages',
					'publish_posts',
					'read',
					'read_private_pages',
					'read_private_posts',
					'unfiltered_html',
					'upload_files',
				)
			);
	endif;


}
endif; // basic_hawaiian_setup
add_action( 'after_setup_theme', 'basic_hawaiian_setup' );

/**
 * Helper: Does role exist?
 * @url http://www.hughlashbrooke.com/2015/02/wordpress-check-user-role-exists/
 */
function role_exists( $role ) {
  if( ! empty( $role ) ) {
    return $GLOBALS['wp_roles']->is_role( $role );
  }
  return false;
}

/**
 * Create Role
 */
function add_custom_role( $role_slug, $role_title, $role_caps ) {
	$result = add_role(
		'student',
		__( 'Student' ),
		array(
				'read'         => true,  // true allows this capability
		)
	);
	if ( null !== $result ) {
			error_log('Yay! New role created!');
	}
	else {
		error_log('Oh... the basic_contributor role already exists.');
	}
}

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function basic_hawaiian_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'basic_hawaiian_content_width', 640 );
}
add_action( 'after_setup_theme', 'basic_hawaiian_content_width', 0 );

/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function basic_hawaiian_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'basic-hawaiian' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
}
add_action( 'widgets_init', 'basic_hawaiian_widgets_init' );

/**
 * Add Custom Body Classes
 *
 */
function custom_body_classes( $classes ) {
  // Adds a class of group-blog to blogs with more than 1 published author
  if ( ! is_user_logged_in() ) {
    $classes[] = 'not-logged-in';
  }
  // global $post;
	//
  // // Instantiate body classes for kukuis and their descendants
  // $auntyAlohaID = '204';
  // $auntyAlohaDescendants = get_connected_descendants(
  //   $auntyAlohaID,
  //   'modules_to_units',
  //   'topics_to_modules',
  //   array(
  //     'instructional_lessons_to_topics',
  //     'video_lessons_to_topics',
  //     'listen_repeat_lessons_to_topics',
  //     'readings_to_topics',
  //     'vocabulary_lessons_to_topics',
  //     'phrases_lessons_to_topics',
  //     'pronoun_lessons_to_topics',
  //     'song_lessons_to_topics',
  //     'chants_lessons_to_topics',
  //   )
  // );
  // foreach ( $auntyAlohaDescendants as $auntyAlohaDescendant ) {
  //   if ( $auntyAlohaDescendant == $post->ID ) {
  //     $classes[] = 'aunty-aloha';
  //   }
  // }
  // if ( $auntyAlohaID == $post->ID )  {
  //   $classes[] = 'aunty-aloha';
  // }

  return $classes;
}
add_filter( 'body_class', 'custom_body_classes' );

/**
 * Stripe
 */
// require get_template_directory() . '/vendor/stripe/stripe-php/init.php';
require get_template_directory() . '/inc/stripe/stripe-process-payment.php';

/**
 * Enqueue scripts and styles.
 */
function basic_hawaiian_scripts() {

	$protocol='http:'; // discover the correct protocol to use
 	if(!empty($_SERVER['HTTPS'])) $protocol='https:';

	wp_enqueue_style( 'bootstrap', get_stylesheet_directory_uri() . '/bower_components/bootstrap/dist/css/bootstrap.min.css' );

	wp_enqueue_style( 'bootstrap', get_stylesheet_directory_uri() . '/bower_components/bootstrap/dist/css/bootstrap-theme.min.css' );

	wp_enqueue_style( 'font-awesome', get_stylesheet_directory_uri() . '/bower_components/font-awesome/css/font-awesome.min.css' );

	wp_enqueue_style( 'animate-css', get_stylesheet_directory_uri() . '/bower_components/animate.css/animate.min.css' );

	wp_enqueue_style( 'basic-hawaiian-style', get_stylesheet_uri() );

	wp_enqueue_script( 'bootstrap-js', get_stylesheet_directory_uri() . '/bower_components/bootstrap/dist/js/bootstrap.min.js', array('jquery'), '20120206', true );

	// Stripe
	if ( get_field('stripe_is_live','option') === false ) {
		$publishable = get_field('stripe_test_publishable','option');
	} elseif ( get_field('stripe_is_live','option') === true ) {
		$publishable = get_field('stripe_live_publishable','option');
	}
	wp_enqueue_script( 'stripe-js', 'https://js.stripe.com/v2/', array('jquery'), '20150713', true );
	wp_enqueue_script( 'stripe-processing', get_template_directory_uri() . '/js/stripe-processing.js', array('jquery'), '20150713', true );
	wp_localize_script('stripe-processing', 'stripe_vars', array(
		'publishable_key' => $publishable,
	));
	wp_enqueue_script( 'basic-hawaiian-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20120206', true );
	wp_enqueue_script( 'basic-hawaiian-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );

	// AJAX Calls
	wp_enqueue_script('user_interactions_scripts', get_stylesheet_directory_uri() . "/inc/user-interactions/user-interactions-scripts.js", array('jquery','json2','bootstrap-js'), true);
	wp_localize_script('user_interactions_scripts', 'user_interactions_scripts', array(
		'ajaxurl' => admin_url('admin-ajax.php',$protocol),
		'nonce' => wp_create_nonce('user_interactions_scripts_nonce'),
	));

	// Scene Generation Scripts
	// wp_enqueue_script('scene-scripts', get_stylesheet_directory_uri() . "/inc/scene-generator/scene-scripts.js", array( 'jquery','json2' ), true);
	// wp_localize_script('scene-scripts', 'scene_scripts', array(
	// 	'ajaxurl' => admin_url('admin-ajax.php',$protocol),
	// 	'nonce' => wp_create_nonce('scene_scripts_nonce')
	// ));

	wp_enqueue_script( 'basic-hawaiian-scripts', get_stylesheet_directory_uri() . '/js/scripts.js', array('jquery'), '20120206', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'basic_hawaiian_scripts' );

/**
 * Implement the Custom Header feature.
 */
//require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

/**
 * Custom Admin functions
 */
require get_template_directory() . '/inc/admin-tweaks/admin-tweaks.php';

/**
 * Custom User Interactions Plugin
 */
require get_template_directory() . '/inc/user-interactions/user-interactions-functions.php';

/**
 * Custom Game Functions
 */
// require get_template_directory() . '/inc/user-interactions/assessment/ajax-game-functions.php';

/**
 * Custom Scene Functions
 */
// require get_template_directory() . '/inc/scene-generator/scene-functions.php';


/**
 * Basic Hawaiian Custom Post Types
 */
function BASICHWN_post_types() {

  // Units
  $labels = array(
    'name' => __( 'Units' ),
    'singular_name' => __( 'Unit' ),
    'add_new' => __( 'Add New Unit' ),
    'add_new_item' => __( 'Add New Unit' ),
    'edit_name' => __( 'Edit This Unit' ),
    'view_item' => __( 'View This Unit' ),
    'search_items' => __('Search Units'),
    'not_found' => __('No Units found.'),
  );
  register_post_type( 'units',
    array(
    'menu_position' => 5,
    'public' => true,
    'supports' => array('title', 'editor', 'thumbnail','page-attributes'),
    'labels' => $labels,
    'rewrite' => array('slug' => 'unit'),
    )
  );

  // Modules
  $labels = array(
    'name' => __( 'Modules' ),
    'singular_name' => __( 'Module' ),
    'add_new' => __( 'Add New Module' ),
    'add_new_item' => __( 'Add New Module' ),
    'edit_name' => __( 'Edit This Module' ),
    'view_item' => __( 'View This Module' ),
    'search_items' => __('Search Modules'),
    'not_found' => __('No Modules found.'),
  );
  register_post_type( 'modules',
    array(
    'menu_position' => 6,
    'public' => true,
    'supports' => array('title', 'editor', 'thumbnail'),
    'labels' => $labels,
    'rewrite' => array('slug' => 'module'),
    )
  );

  // Topics
  $labels = array(
    'name' => __( 'Topics' ),
    'singular_name' => __( 'Topic' ),
    'add_new' => __( 'Add New Topic' ),
    'add_new_item' => __( 'Add New Topic' ),
    'edit_name' => __( 'Edit This Topic' ),
    'view_item' => __( 'View This Topic' ),
    'search_items' => __('Search Topics'),
    'not_found' => __('No Topics found.'),
  );
  register_post_type( 'topics',
    array(
    'menu_position' => 7,
    'public' => true,
    'supports' => array('title'),
    'labels' => $labels,
    'rewrite' => array('slug' => 'topic'),
    )
  );

  /**
   * Custom/AUX Post Types
   */
  // Testimonials
  $labels = array(
    'name' => __( 'Testimonials' ),
    'singular_name' => __( 'Testimonials' ),
    'add_new' => __( 'Add New Testimonial' ),
    'add_new_item' => __( 'Add New Testimonial' ),
    'edit_name' => __( 'Edit This Testimonial' ),
    'view_item' => __( 'View This Testimonial' ),
    'search_items' => __('Search Testimonials'),
    'not_found' => __('No Testimonials found.'),
  );
  register_post_type( 'testimonials',
    array(
    'menu_position' => 8,
    'public' => true,
    'supports' => array( 'title', 'editor', 'thumbnail' ),
    'labels' => $labels,
    'rewrite' => array('slug' => 'testimonials'),
    )
  );

  /**
   * Instructional Lessons
   */

  // Instructional Lessons
  $labels = array(
    'name' => __( 'Instructional Lessons' ),
    'singular_name' => __( 'Instructional Lesson' ),
    'add_new' => __( 'Add New Instructional Lesson' ),
    'add_new_item' => __( 'Add New Instructional Lesson' ),
    'edit_name' => __( 'Edit This Instructional Lesson' ),
    'view_item' => __( 'View This Instructional Lesson' ),
    'search_items' => __('Search Instructional Lessons'),
    'not_found' => __('No Instructional Lessons found.'),
  );
  register_post_type( 'instruction_lessons',
    array(
    'menu_position' => 11,
    'public' => true,
    'supports' => array( 'title', 'page-attributes'),
    'labels' => $labels,
    'rewrite' => array('slug' => 'instruction-lessons'),
    )
  );

  // Video Lessons
  $labels = array(
    'name' => __( 'Video Lessons' ),
    'singular_name' => __( 'Video Lesson' ),
    'add_new' => __( 'Add New Video Lesson' ),
    'add_new_item' => __( 'Add New Video Lesson' ),
    'edit_name' => __( 'Edit This Video Lesson' ),
    'view_item' => __( 'View This Video Lesson' ),
    'search_items' => __('Search Video Lessons'),
    'not_found' => __('No Video Lessons found.'),
  );
  register_post_type( 'video_lessons',
    array(
    'menu_position' => 11,
    'public' => true,
    'supports' => array( 'title', 'page-attributes' ),
    'labels' => $labels,
    'rewrite' => array('slug' => 'video-lessons'),
    )
  );

  // Listen and Repeat Lessons
  $labels = array(
    'name' => __( 'Listen and Repeat Lessons' ),
    'singular_name' => __( 'Listen and Repeat Lesson' ),
    'add_new' => __( 'Add New Listen and Repeat Lesson' ),
    'add_new_item' => __( 'Add New Listen and Repeat Lesson' ),
    'edit_name' => __( 'Edit This Listen and Repeat Lesson' ),
    'view_item' => __( 'View This Listen and Repeat Lesson' ),
    'search_items' => __('Search Listen and Repeat Lessons'),
    'not_found' => __('No Listen and Repeat Lessons found.'),
  );
  register_post_type( 'listenrepeat_lessons',
    array(
    'menu_position' => 11,
    'public' => true,
    'supports' => array( 'title' ),
    'labels' => $labels,
    'rewrite' => array('slug' => 'listen-repeat-lessons'),
    )
  );

  // Readings
  $labels = array(
    'name' => __( 'Readings' ),
    'singular_name' => __( 'Reading' ),
    'add_new' => __( 'Add New Reading' ),
    'add_new_item' => __( 'Add New Reading' ),
    'edit_name' => __( 'Edit This Reading' ),
    'view_item' => __( 'View This Reading' ),
    'search_items' => __('Search Readings'),
    'not_found' => __('No Readings found.'),
  );
  register_post_type( 'readings',
    array(
    'menu_position' => 11,
    'public' => true,
    'supports' => array('title', 'editor'),
    'labels' => $labels,
    'rewrite' => array('slug' => 'reading'),
    )
  );

  /**
   * Instructional Objects
   */

  // Vocabulary Terms
  $labels = array(
    'name' => __( 'Vocabulary Terms' ),
    'singular_name' => __( 'Vocabulary Term' ),
    'add_new' => __( 'Add New Vocabulary Term' ),
    'add_new_item' => __( 'Add New Vocabulary Term' ),
    'edit_name' => __( 'Edit This Vocabulary Term' ),
    'view_item' => __( 'View This Vocabulary Term' ),
    'search_items' => __('Search Vocabulary Terms'),
    'not_found' => __('No Vocabulary Terms found.'),
  );
  register_post_type( 'vocabulary_terms',
    array(
    'menu_position' => 16,
    'public' => true,
    'supports' => array('title', 'editor', 'thumbnail'),
    'labels' => $labels,
    'rewrite' => array('slug' => 'vocabulary'),
    'taxonomies' => array('vocabulary_categories'),
    )
  );

  // Phrases
  $labels = array(
    'name' => __( 'Phrases' ),
    'singular_name' => __( 'Phrase' ),
    'add_new' => __( 'Add New Phrase' ),
    'add_new_item' => __( 'Add New Phrase' ),
    'edit_name' => __( 'Edit This Phrase' ),
    'view_item' => __( 'View This Phrase' ),
    'search_items' => __('Search Phrases'),
    'not_found' => __('No Phrases found.'),
  );
  register_post_type( 'phrases',
    array(
    'menu_position' => 16,
    'public' => true,
    'supports' => array('title', 'editor', 'thumbnail'),
    'labels' => $labels,
    'rewrite' => array('slug' => 'phrase'),
    )
  );

  // Pronoun
  $labels = array(
    'name' => __( 'Pronouns' ),
    'singular_name' => __( 'Pronoun' ),
    'add_new' => __( 'Add New Pronoun' ),
    'add_new_item' => __( 'Add New Pronoun' ),
    'edit_name' => __( 'Edit This Pronoun' ),
    'view_item' => __( 'View This Pronoun' ),
    'search_items' => __('Search Pronouns'),
    'not_found' => __('No Pronouns found.'),
  );
  register_post_type( 'pronouns',
    array(
    'menu_position' => 16,
    'public' =>true,
    'supports' => array('title', 'editor', 'thumbnail'),
    'labels' => $labels,
    'rewrite' => array('slug' => 'pronoun'),

    // Hide Pronouns as they are not in use
    'show_ui' => false,

    )
  );

  // Song Lines
  $labels = array(
    'name' => __( 'Song Lines' ),
    'singular_name' => __( 'Song Line' ),
    'add_new' => __( 'Add New Song Line' ),
    'add_new_item' => __( 'Add New Song Line' ),
    'edit_name' => __( 'Edit This Song Line' ),
    'view_item' => __( 'View This Song Line' ),
    'search_items' => __('Search Song Lines'),
    'not_found' => __('No Song Lines found.'),
  );
  register_post_type( 'song_lines',
    array(
    'menu_position' => 16,
    'public' => true,
    'supports' => array('title'),
    'labels' => $labels,
    'rewrite' => array('slug' => 'song-line'),
    )
  );

  // Chant Lines
  $labels = array(
    'name' => __( 'Chant Lines' ),
    'singular_name' => __( 'Chant Line' ),
    'add_new' => __( 'Add New Chant Line' ),
    'add_new_item' => __( 'Add New Chant Line' ),
    'edit_name' => __( 'Edit This Chant Line' ),
    'view_item' => __( 'View This Chant Line' ),
    'search_items' => __('Search Chant Lines'),
    'not_found' => __('No Chant Lines found.'),
  );
  register_post_type( 'chant_lines',
    array(
    'menu_position' => 16,
    'public' => true,
    'supports' => array('title'),
    'labels' => $labels,
    'rewrite' => array('slug' => 'chant-line'),
    )
  );

  // Scenes
  $labels = array(
    'name' => __( 'Scenes' ),
    'singular_name' => __( 'Scene' ),
    'add_new' => __( 'Add New Scene' ),
    'add_new_item' => __( 'Add New Scene' ),
    'edit_name' => __( 'Edit This Scene' ),
    'view_item' => __( 'View This Scene' ),
    'search_items' => __('Search Scenes'),
    'not_found' => __('No Scenes found.'),
  );
  register_post_type( 'scenes',
    array(
    'menu_position' => 16,
    'public' => true,
    'supports' => array('title', 'editor', 'thumbnail','page-attributes'),
    'labels' => $labels,
    'rewrite' => array('slug' => 'scene'),
    )
  );

  /**
   * Assessment Objects
   */

   // Vocabulary Lesson
  $labels = array(
    'name' => __( 'Vocabulary Lessons' ),
    'singular_name' => __( 'Vocabulary Lesson' ),
    'add_new' => __( 'Add New Vocabulary Lesson' ),
    'add_new_item' => __( 'Add New Vocabulary Lesson' ),
    'edit_name' => __( 'Edit This Vocabulary Lesson' ),
    'view_item' => __( 'View This Vocabulary Lesson' ),
    'search_items' => __('Search Vocabulary Lessons'),
    'not_found' => __('No Vocabulary Lessons found.'),
  );
  register_post_type( 'vocabulary_lessons',
    array(
    'menu_position' => 25,
    'public' => true,
    'supports' => array('title'),
    'labels' => $labels,
    'rewrite' => array('slug' => 'vocabulary-lesson'),
    )
  );

  // Phrases Lesson
  $labels = array(
    'name' => __( 'Phrases Lessons' ),
    'singular_name' => __( 'Phrases Lesson' ),
    'add_new' => __( 'Add New Phrases Lesson' ),
    'add_new_item' => __( 'Add New Phrases Lesson' ),
    'edit_name' => __( 'Edit This Phrases Lesson' ),
    'view_item' => __( 'View This Phrases Lesson' ),
    'search_items' => __('Search Phrases Lesson'),
    'not_found' => __('No Phrases Lesson found.'),
  );
  register_post_type( 'phrases_lessons',
    array(
    'menu_position' => 25,
    'public' => true,
    'supports' => array('title'),
    'labels' => $labels,
    'rewrite' => array('slug' => 'phrases-lesson'),
    )
  );

  // Pronoun Lesson
  $labels = array(
    'name' => __( 'Pronoun Lessons' ),
    'singular_name' => __( 'Pronoun Lesson' ),
    'add_new' => __( 'Add New Pronoun Lesson' ),
    'add_new_item' => __( 'Add New Pronoun Lesson' ),
    'edit_name' => __( 'Edit This Pronoun Lesson' ),
    'view_item' => __( 'View This Pronoun Lesson' ),
    'search_items' => __('Search Pronoun Lesson'),
    'not_found' => __('No Pronoun Lesson found.'),
  );
  register_post_type( 'pronoun_lessons',
    array(
    'menu_position' => 25,
    'public' => true,
    'supports' => array('title'),
    'labels' => $labels,
    'rewrite' => array('slug' => 'pronoun-lesson'),
    )
  );

  // Songs Lesson
  $labels = array(
    'name' => __( 'Song Lessons' ),
    'singular_name' => __( 'Song Lesson' ),
    'add_new' => __( 'Add New Song Lesson' ),
    'add_new_item' => __( 'Add New Song Lesson' ),
    'edit_name' => __( 'Edit This Song Lesson' ),
    'view_item' => __( 'View This Song Lesson' ),
    'search_items' => __('Search Song Lessons'),
    'not_found' => __('No Song Lesson found.'),
  );
  register_post_type( 'song_lessons',
    array(
    'menu_position' => 25,
    'public' => true,
    'supports' => array('title'),
    'labels' => $labels,
    'rewrite' => array('slug' => 'songs-lesson'),
    )
  );

  // Chants Lesson
  $labels = array(
    'name' => __( 'Chants Lessons' ),
    'singular_name' => __( 'Chants Lesson' ),
    'add_new' => __( 'Add New Chants Lesson' ),
    'add_new_item' => __( 'Add New Chants Lesson' ),
    'edit_name' => __( 'Edit This Chants Lesson' ),
    'view_item' => __( 'View This Chants Lesson' ),
    'search_items' => __('Search Chants Lesson'),
    'not_found' => __('No Chants Lesson found.'),
  );
  register_post_type( 'chants_lessons',
    array(
    'menu_position' => 25,
    'public' => true,
    'supports' => array('title'),
    'labels' => $labels,
    'rewrite' => array('slug' => 'chants-lesson'),
    )
  );

}
add_action( 'init', 'BASICHWN_post_types' );


/**
 * Add Menu Pages
 * Used for Scoresheets, Classrooms, etc.
 * @url https://codex.wordpress.org/Function_Reference/add_menu_page
 * @params add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position );
 */

function my_custom_menu_page(){
	require get_template_directory() . '/inc/scoresheet/scoresheet.php';
}

add_action( 'admin_menu', 'register_scoresheet' );
function register_scoresheet() {
	add_menu_page( 'My Scoresheet', 'My Scoresheet', 'read', 'scoresheet', 'my_custom_menu_page', '', 81);
}









/**
 * Cruft To Be Upgraded Below
 */








add_action( 'p2p_init', 'BASICHWN_connections' );
function BASICHWN_connections() {

/*
   * Assessment IA Connections
   */
  // Connect Instructional Lessons to Topics
  p2p_register_connection_type(array(
    'name' => 'instructional_lessons_to_topics',
    'from' => 'instruction_lessons',
    'to' => 'topics',
    'sortable' => 'any',
    'cardinality' => 'many-to-one', // Many Lectures to One Module
  ));
  // Connect Video Lessons to Topics
  p2p_register_connection_type(array(
    'name' => 'video_lessons_to_topics',
    'from' => 'video_lessons',
    'to' => 'topics',
    'sortable' => 'any',
    'cardinality' => 'many-to-one', // Many Lectures to One Module
  ));
  // Connect Listen and Repeat Lessons to Topics
  p2p_register_connection_type(array(
    'name' => 'listen_repeat_lessons_to_topics',
    'from' => 'listenrepeat_lessons',
    'to' => 'topics',
    'sortable' => 'any',
    'cardinality' => 'many-to-one', // Many Lectures to One Module
  ));
  // Connect Readings to Topics
  p2p_register_connection_type(array(
    'name' => 'readings_to_topics',
    'from' => 'readings',
    'to' => 'topics',
    'sortable' => 'any',
    'cardinality' => 'many-to-one', // Many Readings to One Module
  ));
  // Connect Vocabulary Practice to Lessons
  p2p_register_connection_type(array(
    'name' => 'vocabulary_lessons_to_topics',
    'from' => 'vocabulary_lessons',
    'to' => 'topics',
    'sortable' => 'any',
    'cardinality' => 'many-to-one', // Many Vocab Games to One Module
  ));
  // Connect Phrases Practice to Lessons
  p2p_register_connection_type(array(
    'name' => 'phrases_lessons_to_topics',
    'from' => 'phrases_lessons',
    'to' => 'topics',
    'sortable' => 'any',
    'cardinality' => 'many-to-one', // Many Pron Practice to One Module
  ));
  // Connect Pronouns to Topics
  p2p_register_connection_type(array(
    'name' => 'pronoun_lessons_to_topics',
    'from' => 'pronoun_lessons',
    'to' => 'topics',
    'sortable' => 'any',
    'cardinality' => 'many-to-one', // Many Pron Practice to One Module
  ));
  // Connect Song Lessons to Topics
  p2p_register_connection_type(array(
    'name' => 'song_lessons_to_topics',
    'from' => 'song_lessons',
    'to' => 'topics',
    'sortable' => 'any',
    'cardinality' => 'many-to-one', // Many Pron Practice to One Module
  ));
  // Connect Chants Practice to Lessons
  p2p_register_connection_type(array(
    'name' => 'chants_lessons_to_topics',
    'from' => 'chants_lessons',
    'to' => 'topics',
    'sortable' => 'any',
    'cardinality' => 'many-to-one', // Many Pron Practice to One Module
  ));

  // Connect Vocabulary Terms to Vocabulary Lessons
  p2p_register_connection_type(array(
    'name' => 'vocabulary_terms_to_vocabulary_lessons',
    'from' => 'vocabulary_terms',
    'to' => 'vocabulary_lessons',
    'sortable' => 'any',
    'cardinality' => 'many-to-one', // Many Vocab Terms to One Module
  ));
  // Connect Phrases to Phrases Lessons
  p2p_register_connection_type(array(
    'name' => 'phrases_to_phrases_lessons',
    'from' => 'phrases',
    'to' => 'phrases_lessons',
    'sortable' => 'any',
    'cardinality' => 'many-to-one', // Many Phrases to One Lesson
  ));
  // Connect Pronouns to Pronoun Lessons
  p2p_register_connection_type(array(
    'name' => 'pronouns_to_pronoun_lessons',
    'from' => 'pronouns',
    'to' => 'pronoun_lessons',
    'sortable' => 'any',
    'cardinality' => 'many-to-one', // Many Phrases to One Lesson
  ));
  // Connect Song Lines to Song Lessons
  p2p_register_connection_type(array(
    'name' => 'song_lines_to_song_lessons',
    'from' => 'song_lines',
    'to' => 'song_lessons',
    'sortable' => 'any',
    'cardinality' => 'many-to-one', // Many Phrases to One Lesson
  ));
  // Connect Chant Lines to Chant Lessons
  p2p_register_connection_type(array(
    'name' => 'chant_lines_to_chant_lessons',
    'from' => 'chant_lines',
    'to' => 'chants_lessons',
    'sortable' => 'any',
    'cardinality' => 'many-to-one', // Many Phrases to One Lesson
  ));

  // Connect Vocabulary to Phrases
  p2p_register_connection_type(array(
    'name' => 'vocabulary_terms_to_phrases',
    'from' => 'vocabulary_terms',
    'to' => 'phrases',
    'sortable' => 'any',
    'cardinality' => 'one-to-many', // Many Phrases to One Lesson
  ));
  // Connect Phrases to Listen Repeat Lessons
  p2p_register_connection_type(array(
    'name' => 'phrases_to_listen_repeat_lessons',
    'from' => 'phrases',
    'to' => 'listenrepeat_lessons',
    'sortable' => 'any',
    'cardinality' => 'many-to-one', // Many Phrases to One Lesson
  ));

  /**
   *  Scene Selection Connections
   */
  p2p_register_connection_type(array(
    'name' => 'scenes_to_pages',
    'from' => 'scenes',
    'to' => 'page',
    'sortable' => 'any',
    'cardinality' => 'many-to-many',
    'fields' => array(
      'gender' => array(
        'title' => 'Gender',
        'type' => 'select',
        'values' => array( 'male', 'female', 'both' )
      ),
    ),
    'title' => array(
      'from' => __('Pages to Connect Scenes to', 'basichawaiian'),
      'to' => __('Connected Scenes', 'basichawaiian'),
    ),
  ));
  p2p_register_connection_type(array(
    'name' => 'scenes_to_units',
    'from' => 'scenes',
    'to' => 'units',
    'sortable' => 'any',
    'cardinality' => 'many-to-many',
    'fields' => array(
      'gender' => array(
        'title' => 'Gender',
        'type' => 'select',
        'values' => array( 'male', 'female', 'both' )
      ),
    ),
    'title' => array(
      'from' => __('Units to Connect Scenes to', 'basichawaiian'),
      'to' => __('Connected Scenes', 'basichawaiian'),
    ),
  ));
}

/**
 *	Function: Get Connected Object ID
 *  Retrieves ancestors on a many-to-one connection.
 *	@param int $postID The ID of the post you wish to find the parent ID of.
 *	@param int $parentConnectionType The p2p connection type of the current post to immediate parent
 *	@param int $grandparentConnectionType optional The p2p connection type of the immediate parent to grandparent
 *	@param int $grandparentConnectionType optional The p2p connection type of the grandparent to great grandparent
 *  Return the ID of a connected parent (currently only works for objects with one parent and/or one grandparent and/or one great grandparent ... poor child)
 *
 */
function get_connected_object_ID( $postID, $parentConnectionType = false, $grandparentConnectionType = false, $greatGrandparentConnectionType = false ) {
	global $post;
	$connectedParentID = false;
	$connectedGrandparentID = false;
	$connectedGreatGrandparentID = false;

	// Get connected parent if connection type exists to prevent direction error
	if ( p2p_connection_exists( $parentConnectionType ) ) :
	$connectedParent = new WP_Query( array(
	'connected_type' => $parentConnectionType,
	'connected_items' => $postID,
	'nopaging' => true,
	'orderby' => 'menu_order',
	'order' => 'ASC',
	));
	while( $connectedParent->have_posts() ) : $connectedParent->the_post();
		$connectedParentID = $post->ID;

		// Get connected grandparent if desired & check if connection type exists to prevent direction error
		if ( !empty( $grandparentConnectionType ) && ( p2p_connection_exists( $grandparentConnectionType ) ) ) :
			$connectedGrandparent = new WP_Query( array(
			'connected_type' => $grandparentConnectionType,
			'connected_items' => $connectedParentID,
			'nopaging' => true,
			'orderby' => 'menu_order',
			'order' => 'ASC',
			));
			while( $connectedGrandparent->have_posts() ) : $connectedGrandparent->the_post();
				$connectedGrandparentID = $post->ID;

				// Get connected greatgrandparent if desired & check if connection type exists to prevent direction error
				if ( !empty( $greatGrandparentConnectionType ) && ( p2p_connection_exists( $greatGrandparentConnectionType ) ) ) :
				$connectedGreatGrandparent = new WP_Query( array(
				'connected_type' => $greatGrandparentConnectionType,
				'connected_items' => $connectedGrandparentID,
				'nopaging' => true,
				'orderby' => 'menu_order',
				'order' => 'ASC',
				));
				while( $connectedGreatGrandparent->have_posts() ) : $connectedGreatGrandparent->the_post();
					$connectedGreatGrandparentID = $post->ID;
				endwhile;
				wp_reset_postdata();
				endif;

			endwhile;
			wp_reset_postdata();
		endif;

	endwhile;
	wp_reset_postdata();

	endif;

	// Return desired connections
	if ( !empty( $greatGrandparentConnectionType ) ) {
		return $connectedGreatGrandparentID;
	} elseif ( !empty( $grandparentConnectionType ) ) {
		return $connectedGrandparentID;
	} else {
		return $connectedParentID;
	}
}

/**
 *  Global Helper Functions
 */

/*
 * Split content by More Tags
 * Updated from: http://www.sitepoint.com/split-wordpress-content-into-multiple-sections/
 * NOTE: Needed to update regex as some more tags were not being converted into span tags.
 * This exists as a separate function so that the more tag may be used as intended on other pages.
 */
function split_the_content( $unfilteredcontent ) {
  global $more;
  $more = true;
  $content = preg_split('/<span id="more-\d+"><\/span>|<!--more-->/i', $unfilteredcontent);
  error_log(print_r($content,true));
  for($c = 0, $csize = count($content); $c < $csize; $c++) {
    $content[$c] = apply_filters('the_content', $content[$c]);
    $content[$c] = filter_links_rel_external( $content[$c] );
  }
  return $content;
}

// http://codex.wordpress.org/Function_Reference/get_the_excerpt
function the_excerpt_max_charlength ( $charlength ) {
  $excerpt = get_the_excerpt();
  $charlength++;

  if ( mb_strlen( $excerpt ) > $charlength ) {
    $subex = mb_substr( $excerpt, 0, $charlength - 5 );
    $exwords = explode( ' ', $subex );
    $excut = - ( mb_strlen( $exwords[ count( $exwords ) - 1 ] ) );
    if ( $excut < 0 ) {
      echo mb_substr( $subex, 0, $excut );
    } else {
      echo $subex;
    }
    echo '...';
  } else {
    echo $excerpt;
  }
}

/**
 * Convert cents to dollars
 */
function cents_to_dollars($cents) {
	$dollars  = '$';
	// $dollars .= number_format($cents/100,2,'.','');
	$dollars .= $cents/100;
	return $dollars;
}

/*
 * Filter external links and append rel="external"
 */
function filter_links_rel_external( $content ) {
  return preg_replace( '/\<a /i', '<a rel="external" ', $content );
}

/**
 * Redirect Users to Home Page If Not Logged In
 */
 function my_login_redirect( $redirect_to, $request, $user ) {
 	//is there a user to check?
 	global $user;
 	if ( isset( $user->roles ) && is_array( $user->roles ) ) {
 		//check for admins
 		if ( in_array( 'administrator', $user->roles ) ) {
 			// redirect them to the default place
 			// return $redirect_to;
			return $redirect_to;
 		} elseif ( in_array( 'nonpaid', $user->roles ) ) {
 			return home_url('/payment');
 		} else {
 			return home_url();
 		}
 	} else {
 		return $redirect_to;
 	}
 }
 add_filter( 'login_redirect', 'my_login_redirect', 10, 3 );

 /**
  * Custom Registration
  */

function custom_registration_form () { // B.1. Add a new form element...
    $first_name = ( isset( $_POST['first_name'] ) ) ? $_POST['first_name']: '';
    $last_name = ( isset( $_POST['last_name'] ) ) ? $_POST['last_name']: '';
    ?>
    <p>
        <label for="first_name"><?php _e('First Name','BASICHWN') ?><br />
        <input type="text" name="first_name" id="first_name" class="input" value="<?php echo esc_attr(stripslashes($first_name)); ?>" size="25" /></label>
    </p>
    <p>
        <label for="last_name"><?php _e('Last Name','BASICHWN') ?><br />
        <input type="text" name="last_name" id="last_name" class="input" value="<?php echo esc_attr(stripslashes($last_name)); ?>" size="25" /></label>
    </p>
    <p class="gender-select-container">
        <label for="gender"><?php _e( 'Gender', 'BASICHWN') ?><br />
        <?php if ( esc_attr( get_user_meta( $user->ID, 'gender', true ) ) === 'male' ) { ?>
        <input type="radio" name="gender" value="male" checked="checked" /><span>Male</span>
        <input type="radio" name="gender" value="female" /><span>Female</span>
        <?php } else { ?>
        <input type="radio" name="gender" value="male" /><span>Male</span>
        <input type="radio" name="gender" value="female" checked="checked" /><span>Female</span>
        <?php } ?>
        </label>
    </p>
    <?php
}
add_action( 'register_form','custom_registration_form' );

function custom_registration_errors ( $errors, $sanitized_user_login, $user_email ) { // B.2. Add validation. In this case, we make sure first_name is required.
    // First Name
    if ( empty( $_POST['first_name'] ) )
        $errors->add( 'first_name_error', __('<strong>ERROR</strong>: You must include a first name.','BASICHWN') );
    // Last Name
    if ( empty( $_POST['first_name'] ) )
        $errors->add( 'first_name_error', __('<strong>ERROR</strong>: You must include a first name.','BASICHWN') );
    return $errors;
}
add_filter('registration_errors', 'custom_registration_errors', 10, 3);

function custom_user_register ( $user_id ) { // B.3. Finally, save our extra registration user meta.
    if ( isset( $_POST['first_name'] ) )
        update_user_meta($user_id, 'first_name', $_POST['first_name']);
    if ( isset( $_POST['last_name'] ) )
        update_user_meta($user_id, 'last_name', $_POST['last_name']);
    /* Gender */
    update_user_meta( $user_id, 'gender', $_POST['gender'] );
}
add_action('user_register', 'custom_user_register');

/**
 * Extra Profile Fields
 * http://justintadlock.com/archives/2009/09/10/adding-and-using-custom-user-profile-fields
 */

function BASICHWN_create_extra_profile_fields( $user ) { ?>

	<h3><?php _e('Basic Hawaiian Profile Information'); ?></h3>

	<table class="form-table">
		<tr>
			<th><label for="gender">Gender</label></th>
			<td>
				<?php if ( esc_attr( get_user_meta( $user->ID, 'gender', true ) ) === 'male' ) { ?>
				<input type="radio" name="gender" value="male" checked="checked" /><label>Male</label>
				<input type="radio" name="gender" value="female" /><label>Female</label>
				<?php } else { ?>
				<input type="radio" name="gender" value="male" /><label>Male</label>
				<input type="radio" name="gender" value="female" checked="checked" /><label>Female</label>
				<?php } ?>
				<br />
				<span class="description">Please indicate the gender you associate with.</span>
			</td>
		</tr>
	</table>

<?php }
add_action( 'show_user_profile', 'BASICHWN_create_extra_profile_fields' );
add_action( 'edit_user_profile', 'BASICHWN_create_extra_profile_fields' );


function BASICHWN_update_extra_profile_fields( $user_id ) {
	if ( !current_user_can( 'edit_user', $user_id ) )
		return false;
	/* Gender */
	update_user_meta( $user_id, 'gender', $_POST['gender'] );
}
add_action( 'personal_options_update', 'BASICHWN_update_extra_profile_fields' );
add_action( 'edit_user_profile_update', 'BASICHWN_update_extra_profile_fields' );

?>
