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
    <?php $upload_dir = wp_get_upload_dir(); ?>
    <div class="layout_container home-page-container">
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
                $category_slug = 'all';
                $category = get_term_by('slug', $category_slug, 'product_cat');
                $category_link = get_term_link($category);
                foreach ($banners as $banner) {
                    echo '<a class="banner-item" href="' . $category_link . '">';
                    echo '<img src="' . esc_url($banner['url']) . '" alt="Banner Image">';
                    echo '</a>';
                }
                ?>
            </div>
        </div>
        <div>
            <?php echo do_shortcode('[sp_wpcarousel id="204"]'); ?>
        </div>

        <?php
        $slug_khuyen_mai = 'san-pham-khuyen-mai';
        $category = get_term_by('slug', $slug_khuyen_mai, 'product_cat');
        ?>
        <div class="flash_sale">
            <div class="bg-[var(--main-color)] p-3 rounded-md">
                <div class="flex items-center pb-3 gap-4 ">
                    <a href="<?php echo get_category_link($category) ?>" class="center z-10 bg-[var(--main-color)] !justify-start !text-[#ffe645] text-[22px] font-[700] gap-2">
                        FLASH SALE
                        <img class="icon-flash-sale" src="<?php echo $upload_dir['baseurl']; ?>/2024/10/flash.webp" alt="" style="width: 25px; height: 25px;">
                    </a>
                    <div class="text-white text-[13px] moving-text flex-1">Giảm ngay 120k (áp dụng cho các đơn hàng trên 500k)</div>
                </div>
                <div class="bg-white px-2 rounded-md">
                    <?php GetProductByCategory($slug_khuyen_mai, null, true, true) ?>
                </div>
            </div>
        </div>

        <div class="container_product_list_home_page">
            <?php GetProductByCategory('may-lanh', 8, false, false, true); ?>
            <?php GetProductByCategory('tu-lanh', 8, false, false, true); ?>
            <?php GetProductByCategory('may-giat', 8, false, false, true); ?>
        </div>



        <div class="news-container">
            <div class="home-title_child">
                <div>Tin nổi bật</div>
                <a href="<?php echo get_permalink(get_page_by_path('tin-tuc')); ?>">
                    Xem tất cả
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" style="fill: var(--main-color);margin-top: 3.5px;">
                        <path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z"></path>
                    </svg>
                </a>
            </div>
            <div class=" news-hot flex gap-[15px]">
                <?php $posts = get_post_per_page(7);
                $last_posts = array_slice($posts, 1);
                $boxs = array(
                    get_field('widget_1', get_the_ID()),
                    get_field('widget_2', get_the_ID()),
                    get_field('widget_3', get_the_ID()),
                    get_field('widget_4', get_the_ID()),
                ); ?>

                <div class="post-item" style="width: 40%;">
                    <?php if (isset($posts[0])): ?>
                        <a href="<?php echo esc_html($posts[0]['permalink']); ?>">
                            <img src="<?php echo esc_html($posts[0]['thumbnail']); ?>" alt="">
                            <div class="post-item_title" style="font-size: 15px;">
                                <div><?php echo esc_html($posts[0]['title']); ?></div>
                            </div>
                        </a>
                    <?php endif; ?>
                </div>

                <div class="hot_news-right" style="width: 60%;">
                    <?php if (!empty($last_posts)) { ?>
                        <?php foreach ($last_posts as $post) { ?>
                            <div class="post-item">
                                <a href="<?php echo esc_html($post['permalink']); ?>">
                                    <img src="<?php echo esc_html($post['thumbnail']); ?>" alt="">
                                    <div class="post-item_title">
                                        <div><?php echo esc_html($post['title']); ?></div>
                                    </div>
                                </a>
                            </div>
                        <?php } ?>
                    <?php } ?>
                </div>
            </div>
        </div>




        <div class="promo-box flex gap-[15px] py-[15px]">
            <?php
            foreach ($boxs as $box) {
                if ($box) {
                    echo '<div class="promo-item">' . $box . '</div>';
                }
            }
            ?>
        </div>

    </div>
</main><!-- #main -->

<?php
get_footer();
