<?php
/**
 * Studio Snap Theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Studio_Snap_Theme
 */

if ( ! function_exists( 'studio_snap_theme_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function studio_snap_theme_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Studio Snap Theme, use a find and replace
		 * to change 'studio-snap-theme' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'studio-snap-theme', get_template_directory() . '/languages' );

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
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'menu-1' => esc_html__( 'Primary', 'studio-snap-theme' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'studio_snap_theme_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/custom-logo/
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		) );
	}
endif;
add_action( 'after_setup_theme', 'studio_snap_theme_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function studio_snap_theme_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'studio_snap_theme_content_width', 640 );
}
add_action( 'after_setup_theme', 'studio_snap_theme_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function studio_snap_theme_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'studio-snap-theme' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'studio-snap-theme' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Left Sidebar', 'studio-snap-theme' ),
		'id'            => 'sidebar-2',
		'description'   => esc_html__( 'Add widgets here for the left sidebar.', 'studio-snap-theme' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'studio_snap_theme_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function studio_snap_theme_scripts() {
	wp_enqueue_style( 'studio-snap-theme-style', get_stylesheet_uri(), array(), '1.0.0' );

	wp_enqueue_script( 'studio-snap-theme-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '1.0.0', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'studio_snap_theme_scripts' );

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

/**
 * Set comments to unapproved by default.
 *
 * @param array $commentdata Comment data.
 * @return array
 */
function studio_snap_theme_set_comment_to_unapproved( $commentdata ) {
    if ( ! current_user_can( 'moderate_comments' ) ) {
        $commentdata['comment_approved'] = 0;
    }
    return $commentdata;
}
add_filter( 'preprocess_comment', 'studio_snap_theme_set_comment_to_unapproved' );

/**
 * Remove the website field from the comment form.
 *
 * @param array $fields The default comment form fields.
 * @return array
 */
function studio_snap_theme_disable_comment_url_field( $fields ) {
    if ( isset( $fields['url'] ) ) {
        unset( $fields['url'] );
    }
    return $fields;
}
add_filter( 'comment_form_default_fields', 'studio_snap_theme_disable_comment_url_field' );

/**
 * Modify the comment consent checkbox text.
 *
 * @param array $defaults The default comment form arguments.
 * @return array
 */
function studio_snap_theme_modify_comment_consent_text( $defaults ) {
    $commenter = wp_get_current_commenter();
    $consent   = empty( $commenter['comment_author_email'] ) ? '' : ' checked="checked"';

    $defaults['fields']['cookies'] = '<p class="comment-form-cookies-consent"><input id="wp-comment-cookies-consent" name="wp-comment-cookies-consent" type="checkbox" value="yes"' . $consent . ' />' .
        '<label for="wp-comment-cookies-consent">' . __( 'Save my name and email in this browser for the next time I comment.', 'studio-snap-theme' ) . '</label></p>';

    return $defaults;
}
add_filter( 'comment_form_defaults', 'studio_snap_theme_modify_comment_consent_text' );