<?php

/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 8.6.0
 */

defined('ABSPATH') || exit;

get_header('shop');
?>

<main id="primary" class="site-main ">
	<!-- Add your JavaScript here -->
	<?php
	wp_enqueue_script('sort-js', get_template_directory_uri() . '/js/sort.js', array(), 'v2', true);
	wp_enqueue_script('filter-js', get_template_directory_uri() . '/js/filter.js', array(), 'v2', true);
	?>
	<!-- End JavaScript -->

	<div class="layout_container" style="padding: 15px 0;">
		<div class="center gap-[15px]">
			<?php
			$page_id = get_page_by_path('feild-product-page');
			$bannerProduct = [
				get_field('banner_product_1', $page_id),
				get_field('banner_product_2', $page_id),
				get_field('banner_product_3', $page_id),
			];

			$category_slug = 'all';
			$category = get_term_by('slug', $category_slug, 'product_cat');
			$category_link = get_term_link($category);
			foreach ($bannerProduct as $banner) {
				echo '<a class="banner-item" href="' . $category_link . '">';
				echo '<img src="' . esc_url($banner['url']) . '" alt="Banner Image">';
				echo '</a>';
			}
			?>
		</div>

		<div>
			<div class="uppercase font-[600]" style="padding: 10px 0;">Thương hiệu</div>
			<?php echo do_shortcode('[sp_wpcarousel id="204"]'); ?>
		</div>

		<?php
		// lấy slug của page hiển tại trong trang archive
		$term = get_queried_object();
		$slug = isset($term->slug) ? $term->slug : 'all';

		?>

		<div class="filter-container">
			<div id="info-filter"></div>
			<div class="content-filter">
				<?php
				$parent_category  = get_term_by('slug', $slug, 'product_cat');
				if ($parent_category) {
					$child_categories = get_terms(array(
						'taxonomy' => 'product_cat',
						'parent' => $parent_category->term_id,
						'hide_empty' => false,
					));
				}
				if (count($child_categories) > 0) { ?>
					<div class="filter-item">
						<span class="center">
							Loại sản phẩm
							<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" style="fill: rgba(0, 0, 0, 1);">
								<path d="M16.293 9.293 12 13.586 7.707 9.293l-1.414 1.414L12 16.414l5.707-5.707z"></path>
							</svg>
						</span>
						<div class="filter-item_child" id="filte-category">
							<?php
							if (!empty($child_categories)) {
								foreach ($child_categories as $child_category) {
									echo sprintf('
								<div class="filter-item_child_item" slug="%s">
						          <span class="center">
							        %s
							       <input type="checkbox" />
					        	  </span>
					            </div>', $child_category->slug, $child_category->name);
								}
							}
							?>
						</div>
					</div>
				<?php } ?>
				<div class="filter-item">
					<span class="center">
						Chọn mức giá
						<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" style="fill: rgba(0, 0, 0, 1);">
							<path d="M16.293 9.293 12 13.586 7.707 9.293l-1.414 1.414L12 16.414l5.707-5.707z"></path>
						</svg>
					</span>
					<div class="filter-item_child" id="filte-price">
						<div class="filter-item_child_item" min-price="0" max-price="2000000">
							<span class="center">
								Dưới 2 triệu
								<input type="checkbox" />
							</span>
						</div>
						<div class="filter-item_child_item" min-price="2000000" max-price="4000000">
							<span class="center">
								Từ 2 triệu - 4 triệu
								<input type="checkbox" />
							</span>
						</div>
						<div class="filter-item_child_item" min-price="4000000" max-price="7000000">
							<span class="center">
								Từ 4 triệu - 7 triệu
								<input type="checkbox" />
							</span>
						</div>
						<div class="filter-item_child_item" min-price="7000000" max-price="13000000">
							<span class="center">
								Từ 7 triệu - 13 triệu
								<input type="checkbox" />
							</span>
						</div>
						<div class="filter-item_child_item" min-price="13000000" max-price="Infinity">
							<span class="center">
								Trên 13 triệu
								<input type="checkbox" />
							</span>
						</div>
					</div>
				</div>
			</div>
		</div>

		<header class="page-header flex items-center justify-between">
			<?php
			the_archive_title('<h1 class="page-title uppercase font-[600]">', '</h1>');
			ComponentSort();
			?>

		</header><!-- .page-header -->
		<div class="notification-filter"></div>

		<?php if (woocommerce_product_loop() || $slug === 'all') : ?>
			<?php wc_get_template_part('content', 'product'); ?>

		<?php else : ?>
			<p class="woocommerce-notification">Sản phẩm đang được cập nhật.</p>
		<?php endif; ?>
	</div>

</main><!-- #main -->

<?php
get_footer('shop');
?>