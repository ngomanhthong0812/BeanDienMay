<?php

/**
 * template name: Trang chu
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package bean.dev
 */

get_header();
?>

<main id="primary" class="site-main">
    <div class="layout_container">
        <div class="banner py-[15px] gap-[15px] flex">
            <div class="w-[76%]">
                <?php
                echo do_shortcode('[smartslider3 slider="3"]');
                ?>
            </div>
            <div class="w-[24%] flex flex-col gap-[15px]">
                <?php
                $banners = [
                    get_field('banner_right_1', get_the_ID()),
                    get_field('banner_right_2', get_the_ID()),
                    get_field('banner_right_3', get_the_ID()),
                ];
                $contact_page = get_post_type_archive_link('san-pham');
                foreach ($banners as $banner) {
                    echo '<a class="banner-item" href="' . $contact_page . '">';
                    echo '<img src="' . esc_url($banner['url']) . '" alt="Banner Image">';
                    echo '</a>';
                }
                ?>
            </div>
        </div>
    </div>
</main><!-- #main -->

<?php
get_footer();
