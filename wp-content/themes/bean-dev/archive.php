<?php

/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package bean.dev
 */

get_header();
?>
<main id="primary" class="site-main ">
	<div class="navigation py-3 bg-[#f5f5f5]">
		<div class="layout_container text-[14px] center !justify-start gap-1">
			<a href="<?php echo get_home_url() ?>" class="!text-black">Trang chủ</a>
			<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" style="fill: rgba(0, 0, 0, 1);margin-top: 2px;">
				<path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z"></path>
			</svg>
			<?php the_archive_title('<span class="text-[var(--main-hover-color)] ">', '</span>'); ?>
		</div>
	</div>
	<div class="layout_container !py-[15px]">
		<div class="center gap-[15px]">
			<?php
			$page_id = get_page_by_path('feild-product-page');
			$bannerProduct = [
				get_field('banner_product_1', $page_id),
				get_field('banner_product_2', $page_id),
				get_field('banner_product_3', $page_id),
			];

			$contact_page = get_post_type_archive_link('san-pham');
			foreach ($bannerProduct as $banner) {
				echo '<a class="banner-item" href="' . $contact_page . '">';
				echo '<img src="' . esc_url($banner['url']) . '" alt="Banner Image">';
				echo '</a>';
			}
			?>
		</div>
		<div>
			<div class="pt-[15px] pb-[10px] uppercase font-[600]">Thương hiệu</div>
			<?php echo do_shortcode('[sp_wpcarousel id="204"]'); ?>
		</div>
		<?php if (have_posts()) : ?>

			<header class="page-header">
				<?php
				the_archive_title('<h1 class="page-title">', '</h1>');
				the_archive_description('<div class="archive-description">', '</div>');
				?>
			</header><!-- .page-header -->

		<?php
			/* Start the Loop */
			while (have_posts()) :
				the_post();

				/*
				 * Include the Post-Type-specific template for the content.
				 * If you want to override this in a child theme, then include a file
				 * called content-___.php (where ___ is the Post Type name) and that will be used instead.
				 */
				get_template_part('template-parts/content-san-pham', get_post_type());
			endwhile;

			the_posts_navigation();

		else :

			get_template_part('template-parts/content', 'none');

		endif;
		?>
	</div>

</main><!-- #main -->

<?php
get_sidebar();
get_footer();
