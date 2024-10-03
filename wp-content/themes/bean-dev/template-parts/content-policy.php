<?php

/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package bean.dev
 */

?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="layout_container py-[15px]" id="sidebar-container">
		<header class="entry-header">
			<?php
			if (is_singular()) :
				the_title('<h3 class="entry-title !text-xl">', '</h3>');
			else :
				the_title('<h3 class="entry-title"><a href="' . esc_url(get_permalink()) . '" rel="bookmark">', '</a></h3>');
			endif;

			if ('post' === get_post_type()) :
			?>
				<div class="entry-meta">
					<?php
					bean_dev_posted_on();
					bean_dev_posted_by();
					?>
				</div><!-- .entry-meta -->
			<?php endif; ?>
		</header><!-- .entry-header -->
		<div class="entry-content">
			<?php
			the_content(
				sprintf(
					wp_kses(
						/* translators: %s: Name of current post. Only visible to screen readers */
						__('Continue reading<span class="screen-reader-text"> "%s"</span>', 'bean-dev'),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					wp_kses_post(get_the_title())
				)
			);

			wp_link_pages(
				array(
					'before' => '<div class="page-links">' . esc_html__('Pages:', 'bean-dev'),
					'after'  => '</div>',
				)
			);
			?>
		</div><!-- .entry-content -->
	</div>
</article><!-- #post-<?php the_ID(); ?> -->