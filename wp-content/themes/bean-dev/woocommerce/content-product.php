<?php

/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 */


defined('ABSPATH') || exit;
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> class="category_page">
    <header class="entry-header">
        <?php
        if (is_singular()) :
            the_title('<h1 class="entry-title">', '</h1>');
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

    <div class="entry-content !m-0">
        <?php
        $term = get_queried_object();
        $slug = $term->slug;

        if ($slug === 'all') {
            GetProductByCategory();
        } else {
            GetProductByCategory($slug);
        }
        ?>
    </div><!-- .entry-content -->

    <footer class="entry-footer">
        <?php bean_dev_entry_footer(); ?>
    </footer><!-- .entry-footer -->
</article><!-- #post-<?php the_ID(); ?> -->