<?php

/**
 * bean.dev functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package bean.dev
 */

use Google\Api\FieldInfo\Format;

if (! defined('_S_VERSION')) {
	// Replace the version number of the theme on each release.
	define('_S_VERSION', '1.0.0');
}

function my_theme_enqueue_theme()
{
	wp_enqueue_style('output', get_template_directory_uri() . './dist/output.css', array(), '1.5');
	wp_enqueue_style('custom-css', get_template_directory_uri() . '/custom.css', array(), '1.1');
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

function custom_pagination($wp_query)
{
	$big = 999999999; // cần một số lớn để thay thế
	echo paginate_links(array(
		'base'      => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
		'format'    => '?paged=%#%',
		'current'   => max(1, get_query_var('paged')),
		'total'     => $wp_query->max_num_pages,
		'prev_text' => __('«'), // Tùy chỉnh văn bản nút trước
		'next_text' => __('»'),      // Tùy chỉnh văn bản nút tiếp theo
		'before_page_number' => '<span class="page-number">', // Thêm lớp CSS trước số trang
		'after_page_number'  => '</span>', // Thêm lớp CSS sau số trang
	));
}


function get_post_per_page($posts_per_page)
{
	$args = array(
		'post_type' => 'post',
		'posts_per_page' => $posts_per_page,
	);
	$query = new WP_Query($args);
	if ($query->have_posts()) {
		$posts = array();
		while ($query->have_posts()) {
			$query->the_post();
			// /$query->the_post();: Thiết lập bài viết hiện tại trong vòng lặp. 
			//Mỗi lần gọi hàm này, con trỏ sẽ di chuyển đến bài viết tiếp theo trong danh sách kết quả của WP_Query.
			$posts[] = array(
				'title'   => get_the_title(),
				'excerpt' => get_the_excerpt(),
				'thumbnail' => get_the_post_thumbnail_url(null, 'thumbnail'),
				'permalink' => get_permalink(),
				'time' => get_the_time('Y-m-d H:i:s'),
			);
		}
		// Reset lại WP_Query sau khi sử dụng
		wp_reset_postdata();


		return $posts;
	}

	return array();
}


function get_product_info_by_category($category_slug, $limit)
{
	$products = get_posts(array(
		'post_type' => 'product',
		'numberposts' => -1,
		'posts_per_page' => $limit,
		'post_status' => 'publish',
		'tax_query' => array(
			array(
				'taxonomy' => 'product_cat',
				'field' => 'slug',
				'terms' => $category_slug,
				'operator' => 'IN',
			)
		),
	));

	$product_info = array();

	foreach ($products as $product) {
		$product_info[] = get_product_by_id($product->ID);
	}

	return $product_info;
}
function get_all_product_info($limit)
{
	$products = get_posts(array(
		'post_type' => 'product',
		'numberposts' => -1,
		'posts_per_page' => $limit,
		'post_status' => 'publish'
	));

	$product_info = array();
	foreach ($products as $product) {
		$product_info[] = get_product_by_id($product->ID);
	}

	return $product_info;
}

function get_product_by_id($product_id)
{
	// Lấy sản phẩm dựa trên ID
	$product_obj = wc_get_product($product_id);
	// Lấy danh mục của sản phẩm
	$category_ids = $product_obj->get_category_ids();
	$categories = array();
	$brand_photo = '';
	$brand_name = '';


	foreach ($category_ids as $cat_id) {
		$thumbnail_id = get_term_meta($cat_id, 'thumbnail_id', true);
		$thumbnail_url = wp_get_attachment_url($thumbnail_id);

		$term = get_term($cat_id, 'product_cat');
		$categories[] = array(
			'id' => $term->term_id,
			'name' => $term->name,
			'slug' => $term->slug,
			'thumbnail' => $thumbnail_url ? $thumbnail_url : null
		);

		$pattern = "/thuonghieu/";
		if (preg_match($pattern, $thumbnail_url)) {
			$brand_photo = $thumbnail_url;
			$brand_name = $term->name;
		}
	}

	$stock_status = '';

	if ($product_obj->get_stock_status() === 'instock') {
		$stock_status = 'Còn hàng';
	} elseif ($product_obj->get_stock_status() === 'outofstock') {
		$stock_status = 'Hết hàng';
	} elseif ($product_obj->get_stock_status() === 'onbackorder') {
		$stock_status = 'Đặt hàng trước';
	}

	$product_image_id = $product_obj->get_image_id();
	$product_image_url = wp_get_attachment_url($product_image_id);
	$product_info = array(
		'id' => $product_obj->get_id(),
		'name' => $product_obj->get_name(),
		'type' => $product_obj->get_type(),
		'regular_price' => $product_obj->get_regular_price(),
		'sale_price' => $product_obj->get_sale_price(),
		'image' => $product_image_url,
		'categories' => $categories,
		'brand_photo' => $brand_photo,
		'brand_name' => $brand_name,
		'link' => $product_obj->get_permalink(),
		'status' => $stock_status,
	);

	return $product_info;
}


function GetProductByCategory($category_slug = "", $limit = null, $slider = false, $sale = false)
{
	$productList = get_all_product_info($limit);

	if ($category_slug !== "") {
		$productList = get_product_info_by_category($category_slug, $limit);
	}
	$banners = array();
	switch ($category_slug) {
		case 'may-lanh':
			$banners = array(
				get_field('banner_category_may_lanh_1', get_the_ID()),
				get_field('banner_category_may_lanh_2', get_the_ID()),
			);

			break;
		case 'tu-lanh':
			$banners = array(
				get_field('banner_category_tu_lanh_1', get_the_ID()),
				get_field('banner_category_tu_lanh_2', get_the_ID()),
			);

			break;
		case 'do-a-dung':
			$banners = array(
				get_field('banner_category_do_gia_dung_1', get_the_ID()),
				get_field('banner_category_do_gia_dung_2', get_the_ID()),
			);

			break;
	}

	echo '<div>';
	if ($limit != null) {
		echo '<div class="title-container"><div class="title">';
		$category = get_term_by('slug', $category_slug, 'product_cat');
		$thumbnail_id = get_term_meta($category->term_id, 'thumbnail_id', true);
		$thumbnail_url = wp_get_attachment_url($thumbnail_id);

		echo '<img src="' . esc_url($thumbnail_url) . '" alt="' . esc_attr($category->name) . '">';
		echo '<a href="' . esc_url(get_category_link($category)) . '"><span>' . esc_html($category->name) . '</span></a>';
		echo '</div>';

		echo '<div class="children_category">';
		$args = array(
			'taxonomy'   => 'product_cat',
			'parent'   => $category->term_id,
			'hide_empty' => false,
		);
		$child_categories = get_terms($args);

		if (!empty($child_categories) && !is_wp_error($child_categories)) {
			foreach ($child_categories as $child_category) {
				echo '<a href="' . esc_url(get_category_link($child_category)) . '">' . esc_html($child_category->name) . '</a>';
			}
		}
		echo '</div></div>';
	}
	if ($slider) {
		ProductSlider($productList, $sale);
	} else {
		ProductList($productList, $banners);
	}
	echo '</div>';
}

function enqueue_swiper_assets()
{
	// Thêm CSS của Swiper
	wp_enqueue_style('swiper-css', 'https://unpkg.com/swiper/swiper-bundle.min.css');

	// Thêm JS của Swiper
	wp_enqueue_script('swiper-js', 'https://unpkg.com/swiper/swiper-bundle.min.js', array(), null, true);
}
add_action('wp_enqueue_scripts', 'enqueue_swiper_assets');

function ProductList($productList, $banners)
{
	$category_slug_to_link = 'all';
	$category_to_link = get_term_by('slug', $category_slug_to_link, 'product_cat');
	$category_link = get_term_link($category_to_link);

	if (!empty($banners[0])) {
		echo '<a  class="banner-item" href="' . $category_link . '"><img src="' . $banners[0]['url'] . '"/></a>';
	}
	echo '<div class="product-list">';
	foreach ($productList as $product) {
		$regular_price = (float) $product['regular_price'];
		$sale_price = (float) $product['sale_price'];
		$format_regular_price = $product['regular_price'] ? number_format($product['regular_price'], 0, '', '.') . 'đ' : '';
		$format_sale_price = $product['sale_price'] ? number_format($product['sale_price'], 0, '', '.') . 'đ' : 'Liên hệ';

		$discount_percentage = 0;
		if ($regular_price > 0) {
			$discount_percentage = (($regular_price - $sale_price) / $regular_price) * 100;
		}
		echo '<div class="product-item">';
		echo '<img src="' . esc_url($product['brand_photo']) . '" alt="' . esc_html($product['name']) . '" class="brand_photo"/>';
		echo '<div class="product-item_image">';
		echo '<a href=' . $product['link'] . '><img src="' . esc_url($product['image']) . '" alt="' . esc_html($product['name']) . '" />';
		echo '<div class="product-item_icon-container">
		     <a href="' . esc_url(wc_get_cart_url()) . '?add-to-cart=' . esc_attr($product['id']) . '" class="add_to_cart_button product-item_icon">
			 <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" viewBox="0 0 24 24">
			 <path d="M21 4H2v2h2.3l3.521 9.683A2.004 2.004 0 0 0 9.7 17H18v-2H9.7l-.728-2H18c.4 0 .762-.238.919-.606l3-7A.998.998 0 0 0 21 4z">
			 </path><circle cx="10.5" cy="19.5" r="1.5"></circle><circle cx="16.5" cy="19.5" r="1.5"></circle>
			 </svg>
			 </a>
			   <a href="javascript:void(0)" class="yith-wcqv-button product-item_icon" data-product_id="' . esc_attr($product['id']) . '">
			 <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" viewBox="0 0 24 24">
			 <path d="M12 5c-7.633 0-9.927 6.617-9.948 6.684L1.946 12l.105.316C2.073 12.383 4.367 19 12 19s9.927-6.617 9.948-6.684l.106-.316-.105-.316C21.927 11.617 19.633 5 12 5zm0 11c-2.206 0-4-1.794-4-4s1.794-4 4-4 4 1.794 4 4-1.794 4-4 4z">
			 </path><path d="M12 10c-1.084 0-2 .916-2 2s.916 2 2 2 2-.916 2-2-.916-2-2-2z"></path></svg>
			 </a>
			    <a href="" class="add_to_cart_button product-item_icon">
			 <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" viewBox="0 0 24 24">
			 <path d="M20.205 4.791a5.938 5.938 0 0 0-4.209-1.754A5.906 5.906 0 0 0 12 4.595a5.904 5.904 0 0 0-3.996-1.558 5.942 5.942 0 0 0-4.213 1.758c-2.353 2.363-2.352 6.059.002 8.412L12 21.414l8.207-8.207c2.354-2.353 2.355-6.049-.002-8.416z"></path>
			 </svg>
			 </a>
		     </div>';
		echo '</div>';
		echo '</a>';
		echo '<div class="product-item_content">';
		echo '<h2 class="product-item_name"><a href=' . $product['link'] . '>' . esc_html($product['name']) . '</a></h2>';
		echo '<p class="product-item_price">' . $format_sale_price . '</p>';
		echo '<div class="flex gap-2 item-center ">';
		echo '<p class="product-item_regular_price center"> ' . $format_regular_price . '</p>';
		echo '<p class="text-[#c40025] text-[15px]">(-' . esc_html(number_format($discount_percentage, 0)) . '%)</p>';
		echo '</div>';
		echo '</div>';
		foreach ($product['categories'] as $category) {
			echo '<span id="category_item">' . esc_attr($category['slug']) . '</span>';
		}
		echo '</div>';
	}
	echo '</div>';
	if (!empty($banners[1])) {
		echo '<a  class="banner-item" href="' . $category_link . '"><img src="' . $banners[1]['url'] . '"/></a>';
	}
}


function ComponentSort()
{
	echo '<div class="center text-[14px] gap-2 ">
        <div class="center font-[550] text-[#696969]">
            <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" viewBox="0 0 24 24">
                <path d="m6 20 4-4H7V4H5v12H2zm5-12h9v2h-9zm0 4h7v2h-7zm0-8h11v2H11zm0 12h5v2h-5z"></path>
            </svg>
            <span>Sắp xếp:</span>
        </div>
        <div class="relative sort-container">
            <span class="center cursor-pointer">
                <span id="selected">Mặc định</span>
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" style="fill: rgba(0, 0, 0, 1);">
                    <path d="M16.293 9.293 12 13.586 7.707 9.293l-1.414 1.414L12 16.414l5.707-5.707z"></path>
                </svg>
            </span>
            <div class="absolute top-6 right-0 flex flex-col bg-[#f6f6f6] border selected-container" style="z-index: 30;">
                <div class="sort-item">Mặc định</div>
                <div class="sort-item">A → Z</div>
                <div class="sort-item">Z → A</div>
                <div class="sort-item">Giá tăng dần</div>
                <div class="sort-item">Giá giảm dần</div>
            </div>
        </div>
    </div>';
}

/** 
 * start custom hook woocommerce 
 * **/
add_action('my_custom_action_related_products', 'custom_related_products', 10);

add_action('my_custom_action_additional_information', 'my_custom_product_additional_information', 10);
function custom_related_products()
{
	global $product;
	$replate_products = wc_get_related_products($product->get_id(), 8);
	$product_list = array();
	foreach ($replate_products as $product_id) {
		$product_list[] = get_product_by_id($product_id);
	}
	echo '<div class="title">Sản phẩm liên quan</div>';
	ProductSlider($product_list);
}

function my_custom_product_additional_information()
{
	global $product;
	$custom_fields = get_fields($product->get_id());
	$index = 0;
	echo '<div class="detailed-information-container sidebar-menu">';
	echo '<div class="title_information">Thông tin chi tiết</div>';
	echo '<table>';
	foreach ($custom_fields as $key => $value) {
		if ($value) {
			$index++;
			$field_details = acf_get_field($key);
			$label = $field_details['label'];

			echo '<tr class="detailed-information-child_item" style="' . ($index % 2 != 0 ? 'background-color: #f1f1f1;' : '') . '">';
			echo '<th>' . $label . '</th>';
			echo '<th>' . $value . '</th>';
			echo '</tr>';
		}
	}
	echo '</table>';
	echo '</div>';
}


/** 
 * end custom hook woocommerce 
 * **/


function ProductSlider($productList, $sale = false)
{
	echo '<div class="swiper-container">'; // Thêm container của Swiper
	echo '<div class="swiper-wrapper">'; // Thêm lớp này để chứa các sản phẩm

	foreach ($productList as $product) {
		echo '<div class="swiper-slide">'; // Thay đổi lớp sản phẩm thành swiper-slide
		$regular_price = (float) $product['regular_price'];
		$sale_price = (float) $product['sale_price'];
		$format_regular_price = $product['regular_price'] ? number_format($product['regular_price'], 0, '', '.') . 'đ' : '';
		$format_sale_price = $product['sale_price'] ? number_format($product['sale_price'], 0, '', '.') . 'đ' : 'Liên hệ';
		$discount_percentage = 0;
		if ($regular_price > 0) {
			$discount_percentage = (($regular_price - $sale_price) / $regular_price) * 100;
		}

		echo '<div class="product-item">';
		echo '<img src="' . esc_url($product['brand_photo']) . '" alt="' . esc_html($product['name']) . '" class="brand_photo"/>';
		echo $sale ? '<p class="result-label temp1"><img width="15" height="15" alt="Giảm sốc" src="http://localhost/beanDienMay/wp-content/uploads/2024/10/icon_gs.webp"><span>Giảm sốc</span></p>' : '';
		echo '<div class="product-item_image">';
		echo '<a href="' . $product['link'] . '"><img src="' . esc_url($product['image']) . '" alt="' . esc_html($product['name']) . '" />';
		echo '<div class="product-item_icon-container">
		     <a href="' . esc_url(wc_get_cart_url()) . '?add-to-cart=' . esc_attr($product['id']) . '" class="add_to_cart_button product-item_icon">
			 <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" viewBox="0 0 24 24">
			 <path d="M21 4H2v2h2.3l3.521 9.683A2.004 2.004 0 0 0 9.7 17H18v-2H9.7l-.728-2H18c.4 0 .762-.238.919-.606l3-7A.998.998 0 0 0 21 4z">
			 </path><circle cx="10.5" cy="19.5" r="1.5"></circle><circle cx="16.5" cy="19.5" r="1.5"></circle>
			 </svg>
			 </a>
			  <a href="javascript:void(0)" class="yith-wcqv-button product-item_icon" data-product_id="' . esc_attr($product['id']) . '">
			 <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" viewBox="0 0 24 24">
			 <path d="M12 5c-7.633 0-9.927 6.617-9.948 6.684L1.946 12l.105.316C2.073 12.383 4.367 19 12 19s9.927-6.617 9.948-6.684l.106-.316-.105-.316C21.927 11.617 19.633 5 12 5zm0 11c-2.206 0-4-1.794-4-4s1.794-4 4-4 4 1.794 4 4-1.794 4-4 4z">
			 </path><path d="M12 10c-1.084 0-2 .916-2 2s.916 2 2 2 2-.916 2-2-.916-2-2-2z"></path></svg>
			 </a>
			    <a href="" class="add_to_cart_button product-item_icon">
			 <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" viewBox="0 0 24 24">
			 <path d="M20.205 4.791a5.938 5.938 0 0 0-4.209-1.754A5.906 5.906 0 0 0 12 4.595a5.904 5.904 0 0 0-3.996-1.558 5.942 5.942 0 0 0-4.213 1.758c-2.353 2.363-2.352 6.059.002 8.412L12 21.414l8.207-8.207c2.354-2.353 2.355-6.049-.002-8.416z"></path>
			 </svg>
			 </a>
		     </div>';
		echo '</div>';
		echo '</a>';
		echo '<div class="product-item_content">';
		echo '<h2 class="product-item_name"><a href="' . $product['link'] . '">' . esc_html($product['name']) . '</a></h2>';
		echo '<p class="product-item_price">' . $format_sale_price . '</p>';
		echo '<div class="flex gap-2 item-center ">';
		echo '<p class="product-item_regular_price center"> ' . $format_regular_price . '</p>';
		echo '<p class="text-[#c40025] text-[15px]">(-' . esc_html(number_format($discount_percentage, 0)) . '%)</p>';
		echo '</div>';
		echo '</div>';
		echo '</div>';
		echo '</div>'; // Kết thúc swiper-slide
	}

	echo '</div>'; // Kết thúc swiper-wrapper
	echo '<div class="swiper-button-next"></div>'; // Nút Next
	echo '<div class="swiper-button-prev"></div>'; // Nút Prev
	echo '</div>'; // Kết thúc swiper-container

	// Khởi tạo Swiper
	echo '<script>
    document.addEventListener("DOMContentLoaded", function () {
        var swiper = new Swiper(".swiper-container", {
            slidesPerView: 4,
            spaceBetween: 20,
            loop: false,
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
            autoplay: {
                delay: 5000,
            },
			 breakpoints: {
               400: {
                slidesPerView: 2, // Hiển thị 1 slide khi chiều rộng màn hình nhỏ hơn 640px
                spaceBetween: 10,
            },
            600: {
                slidesPerView: 2, // Hiển thị 2 slide khi chiều rộng màn hình từ 900px đến 1199px
                spaceBetween: 10,
            },
            900: {
                slidesPerView: 3, // Hiển thị 3 slide khi chiều rộng màn hình từ 640px đến 899px
                spaceBetween: 20,
            },
            }
        });
    });
    </script>';
}


function get_woocommerce_coupons()
{
	$args = array(
		'post_type' => 'shop_coupon',
		'posts_per_page' => 3,
	);

	$coupons = get_posts($args);

	echo '<div class="p-3 flex flex-col gap-3 rounded-[4px] border-dashed border-[1px] border-[var(--main-color)]">';
	foreach ($coupons as $coupon) {
		$coupon_code = get_the_title($coupon->ID); // Lấy mã voucher
		$discount_type = get_post_meta($coupon->ID, 'discount_type', true); // Loại giảm giá
		$amount = get_post_meta($coupon->ID, 'coupon_amount', true); // Số tiền giảm giá
		$excerpt = get_the_excerpt($coupon->ID);
		echo '<div class="voucher-item text-[14px] p-2 rounded-md">';
		echo '<div class="font-[700] text-[var(--main-color)]">' . $excerpt . '</div>';
		echo sprintf('<div>Nhập mã %s giảm ngay %s </div>', $coupon_code, $excerpt);
		echo '<div class="copy-coupon-btn flex justify-between bg-[#f5f5f5]  p-1 mt-2 rounded-[2px]">
		<span id="coupon-code" class="font-[600]">' . $coupon_code . '</span>
		<button class="bg-[var(--main-color)] text-white center p-3 text-[12px] hover:bg-[var(--main-hover-color)] duration-200" style="line-height: 0; border:none;">Copy</button>
		</div>';
		echo '</div>';
	}
	echo '</div>';
}
add_shortcode('show_vouchers', 'get_woocommerce_coupons');

function productPolicies()
{
	$upload_dir = wp_get_upload_dir();

	$policies = array(
		array(
			'imgUrl' => $upload_dir['baseurl'] . '/2024/09/policy_image_1.webp',
			'content' => 'Miễn phí vận chuyển tại Huế'
		),
		array(
			'imgUrl' => $upload_dir['baseurl'] . '/2024/09/policy_image_2.webp',
			'content' => 'Bảo hành chính hãng toàn quốc'
		),
		array(
			'imgUrl' => $upload_dir['baseurl'] . '/2024/09/policy_image_3.webp',
			'content' => 'Cam kết chính hãng 100%'
		),
		array(
			'imgUrl' => $upload_dir['baseurl'] . '/2024/09/policy_image_4.webp',
			'content' => 'Hỗ trợ sửa chữa, bảo hành'
		)
	);
	echo '<div class="product-policies">';
	foreach ($policies as $piloce) {
		echo '<div class="policy-item">';
		echo '<img src="' . $piloce['imgUrl'] . '" alt="Policy">';
		echo '<div class="policy-content">' . $piloce['content'] . '</div>';
		echo '</div>';
	}
	echo '</div>';
}


add_action('wp_ajax_get_cart_count', 'get_cart_count');
add_action('wp_ajax_nopriv_get_cart_count', 'get_cart_count');

function get_cart_count()
{
	echo WC()->cart->get_cart_contents_count();
	wp_die(); // Ngăn chặn việc xuất thêm thông tin
}


//custom post type
function create_policy_post_type()
{
	$labels = array(
		'name'                  => 'Chính sách',
		'singular_name'         => 'Chính sách',
		'menu_name'             => 'Chính sách',
		'name_admin_bar'        => 'Chính sách',
		'add_new'               => 'Thêm mới',
		'add_new_item'          => 'Thêm chính sách mới',
		'new_item'              => 'Chính sách mới',
		'edit_item'             => 'Chỉnh sửa chính sách',
		'view_item'             => 'Xem chính sách',
		'all_items'             => 'Tất cả chính sách',
		'search_items'          => 'Tìm chính sách',
		'not_found'             => 'Không tìm thấy chính sách',
		'not_found_in_trash'    => 'Không tìm thấy chính sách trong thùng rác',
	);

	$args = array(
		'labels'                => $labels,
		'public'                => true,
		'publicly_queryable'    => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'query_var'             => true,
		'rewrite'               => array('slug' => '', 'with_front' => false), // Xóa slug
		'capability_type'       => 'post',
		'has_archive'           => true,
		'hierarchical'          => false,
		'menu_position'         => null,
		'supports'              => array('title', 'editor', 'thumbnail'),
	);

	register_post_type('policy', $args);
}

add_action('init', 'create_policy_post_type');
