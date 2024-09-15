<?php

/**
 * bean.dev functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package bean.dev
 */

if (! defined('_S_VERSION')) {
	// Replace the version number of the theme on each release.
	define('_S_VERSION', '1.0.0');
}

function my_theme_enqueue_theme()
{
	wp_enqueue_style('output', get_template_directory_uri() . './dist/output.css', array());
	wp_enqueue_style('custom-css', get_template_directory_uri() . '/custom.css');
}

add_action('wp_enqueue_scripts', 'my_theme_enqueue_theme');
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function bean_dev_setup()
{
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on bean.dev, use a find and replace
		* to change 'bean-dev' to the name of your theme in all the template files.
		*/
	load_theme_textdomain('bean-dev', get_template_directory() . '/languages');

	// Add default posts and comments RSS feed links to head.
	add_theme_support('automatic-feed-links');

	/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
	add_theme_support('title-tag');

	/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
	add_theme_support('post-thumbnails');

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'menu-1' => esc_html__('Primary', 'bean-dev'),
		)
	);

	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'bean_dev_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support('customize-selective-refresh-widgets');

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action('after_setup_theme', 'bean_dev_setup');

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function bean_dev_content_width()
{
	$GLOBALS['content_width'] = apply_filters('bean_dev_content_width', 640);
}
add_action('after_setup_theme', 'bean_dev_content_width', 0);

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function bean_dev_widgets_init()
{
	register_sidebar(
		array(
			'name'          => esc_html__('Sidebar', 'bean-dev'),
			'id'            => 'sidebar-1',
			'description'   => esc_html__('Add widgets here.', 'bean-dev'),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action('widgets_init', 'bean_dev_widgets_init');

/**
 * Enqueue scripts and styles.
 */
function bean_dev_scripts()
{
	wp_enqueue_style('bean-dev-style', get_stylesheet_uri(), array(), _S_VERSION);
	wp_style_add_data('bean-dev-style', 'rtl', 'replace');

	wp_enqueue_script('bean-dev-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true);

	if (is_singular() && comments_open() && get_option('thread_comments')) {
		wp_enqueue_script('comment-reply');
	}
}
add_action('wp_enqueue_scripts', 'bean_dev_scripts');

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

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
if (defined('JETPACK__VERSION')) {
	require get_template_directory() . '/inc/jetpack.php';
}

/**
 * Load WooCommerce compatibility file.
 */
if (class_exists('WooCommerce')) {
	require get_template_directory() . '/inc/woocommerce.php';
}

function tao_custom_post_type_san_pham()
{
	$labels = array(
		'name'               => _x('Sản phẩm', 'Post Type General Name', 'text_domain'),
		'singular_name'      => _x('Sản phẩm', 'Post Type Singular Name', 'text_domain'),
		'menu_name'          => __('Sản phẩm', 'text_domain'),
		'name_admin_bar'     => __('Sản phẩm', 'text_domain'),
		'archives'           => __('Lưu trữ sản phẩm', 'text_domain'),
		'attributes'         => __('Thuộc tính sản phẩm', 'text_domain'),
		'parent_item_colon'  => __('Sản phẩm cha:', 'text_domain'),
		'all_items'          => __('Tất cả sản phẩm', 'text_domain'),
		'add_new_item'       => __('Thêm mới sản phẩm', 'text_domain'),
		'add_new'            => __('Thêm sản phẩm', 'text_domain'),
		'new_item'           => __('Sản phẩm mới', 'text_domain'),
		'edit_item'          => __('Chỉnh sửa sản phẩm', 'text_domain'),
		'update_item'        => __('Cập nhật sản phẩm', 'text_domain'),
		'view_item'          => __('Xem sản phẩm', 'text_domain'),
		'view_items'         => __('Xem các sản phẩm', 'text_domain'),
		'search_items'       => __('Tìm kiếm sản phẩm', 'text_domain'),
		'not_found'          => __('Không tìm thấy', 'text_domain'),
		'not_found_in_trash' => __('Không tìm thấy trong thùng rác', 'text_domain'),
	);

	$args = array(
		'label'              => __('Sản phẩm', 'text_domain'),
		'description'        => __('Chứa các sản phẩm của bạn', 'text_domain'),
		'labels'             => $labels,
		'supports'           => array('title', 'editor', 'thumbnail', 'excerpt', 'revisions'),
		'hierarchical'       => false,
		'public'             => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'menu_position'      => 5,
		'show_in_admin_bar'  => true,
		'show_in_nav_menus'  => true,
		'can_export'         => true,
		'has_archive'        => true,
		'exclude_from_search' => false,
		'publicly_queryable' => true,
		'capability_type'    => 'post',
		'menu_icon'          => 'dashicons-portfolio', // Biểu tượng trên menu quản trị
		'rewrite'            => array('slug' => 'san-pham'), // Đường dẫn cho custom post type
	);

	register_post_type('san-pham', $args);
}

add_action('init', 'tao_custom_post_type_san_pham', 0);


function tao_taxonomy_danh_muc_san_pham()
{
	$labels = array(
		'name'              => _x('Danh mục sản phẩm', 'taxonomy general name', 'text_domain'),
		'singular_name'     => _x('Danh mục sản phẩm', 'taxonomy singular name', 'text_domain'),
		'search_items'      => __('Tìm kiếm danh mục sản phẩm', 'text_domain'),
		'all_items'         => __('Tất cả danh mục sản phẩm', 'text_domain'),
		'parent_item'       => __('Danh mục sản phẩm cha', 'text_domain'),
		'parent_item_colon' => __('Danh mục sản phẩm cha:', 'text_domain'),
		'edit_item'         => __('Chỉnh sửa danh mục sản phẩm', 'text_domain'),
		'update_item'       => __('Cập nhật danh mục sản phẩm', 'text_domain'),
		'add_new_item'      => __('Thêm mới danh mục sản phẩm', 'text_domain'),
		'new_item_name'     => __('Tên danh mục sản phẩm mới', 'text_domain'),
		'menu_name'         => __('Danh mục sản phẩm', 'text_domain'),
	);

	$args = array(
		'hierarchical'      => true, // Cho phép phân cấp như categories
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array('slug' => 'danh-muc-san-pham'),
	);

	register_taxonomy('danh-muc-san-pham', array('san-pham'), $args);
}
add_action('init', 'tao_taxonomy_danh_muc_san_pham', 0);

function my_theme_archive_title($title)
{
	if (is_category()) {
		$title = single_cat_title('', false);
	} elseif (is_tag()) {
		$title = single_tag_title('', false);
	} elseif (is_author()) {
		$title = '<span class="vcard">' . get_the_author() . '</span>';
	} elseif (is_post_type_archive()) {
		$title = post_type_archive_title('', false);
	} elseif (is_tax()) {
		$title = single_term_title('', false);
	}

	return $title;
}

add_filter('get_the_archive_title', 'my_theme_archive_title');
