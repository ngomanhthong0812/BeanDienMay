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
post
<main id="primary" class="site-main ">
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
				get_template_part('template-parts/content', get_post_type());
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
