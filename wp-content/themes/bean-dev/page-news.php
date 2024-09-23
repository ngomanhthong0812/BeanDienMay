<?php

/**
 * Template name: Tin tuc
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package bean.dev
 */

get_header();
?>
<main id="primary" class="site-main py-[15px]">
    <div class="layout_container flex gap-[15px]">
        <div class="w-[76%] news-container">
            <div class="title">
                <?php
                echo get_the_title();
                ?>
            </div>
            <div class="list_post flex flex-col center">
                <?php
                $args = array(
                    'post_type'      => 'post',
                    'posts_per_page' => 5,
                    'paged'          => get_query_var('paged') ? get_query_var('paged') : 1,
                );
                $custom_query = new WP_Query($args);

                if ($custom_query->have_posts()) {
                    $posts = array();
                    while ($custom_query->have_posts()) {
                        $custom_query->the_post();
                        $posts[] = array(
                            'title'   => get_the_title(),
                            'excerpt' => get_the_excerpt(),
                            'thumbnail' => get_the_post_thumbnail_url(null, 'thumbnail'),
                            'permalink' => get_permalink(),
                            'time' => get_the_time('Y-m-d H:i:s'),
                        );
                    }
                    $last_posts = array_slice($posts, 2);
                ?>
                    <div class="content py-[15px] flex flex-col gap-[20px]" style="width: 100%;">
                        <div class="flex gap-[15px]">
                            <div class="post-item" style="width: 68%;">
                                <?php if (isset($posts[0])): ?>
                                    <a href="<?php echo esc_html($posts[0]['permalink']); ?>">
                                        <img src="<?php echo esc_html($posts[0]['thumbnail']); ?>" alt="">
                                        <div class="post-item_title"><?php echo esc_html($posts[0]['title']); ?></div>
                                    </a>
                                <?php endif; ?>
                            </div>
                            <div class="flex flex-col gap-[10px]" style="width: 32%;">
                                <div class="post-item">
                                    <?php if (isset($posts[1])): ?>
                                        <a href="<?php echo esc_html($posts[1]['permalink']); ?>">
                                            <img src="<?php echo esc_html($posts[1]['thumbnail']); ?>" alt="">
                                            <div class="post-item_title"><?php echo esc_html($posts[1]['title']); ?></div>
                                        </a>
                                    <?php endif; ?>
                                </div>
                                <div class="post-item">
                                    <?php if (isset($posts[2])): ?>
                                        <a href="<?php echo esc_html($posts[2]['permalink']); ?>">
                                            <img src="<?php echo esc_html($posts[2]['thumbnail']); ?>" alt="">
                                            <div class="post-item_title"><?php echo esc_html($posts[2]['title']); ?></div>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <div>
                            <?php foreach ($last_posts as $post) {
                            ?><div class="post-item flex gap-[15px] mb-[20px]">
                                    <div style="width: 28%;">
                                        <a href="<?php echo esc_html($post['permalink']); ?>">
                                            <img src="<?php echo esc_html($post['thumbnail']); ?>" alt="" style="height: 157px;">
                                        </a>
                                    </div>
                                    <div class=" text-[14px] flex flex-col gap-[5px]" style="width: 72%;">
                                        <a class="post-item_title-last" href="<?php echo esc_html($post['permalink']); ?>">
                                            <?php echo esc_html($post['title']); ?>
                                        </a>
                                        <div class="text-[#8f8f8f]"><?php echo esc_html($post['time']); ?></div>
                                        <div class="post-item-content"><?php echo esc_html($post['excerpt']); ?></div>
                                    </div>
                                </div>
                            <?php } ?>

                        </div>
                    </div>
                <?php
                    echo '<div class="navigation-post">';
                    custom_pagination($custom_query);
                    echo '</div>';

                    wp_reset_postdata();
                } else {
                    echo 'No posts found';
                } ?>
            </div>
        </div>
        <div class="w-[24%] sidebar-container" id="secondary-container">
            <?php
            get_sidebar();
            ?>
        </div>
    </div>

</main><!-- #main -->

<?php
get_sidebar();
get_footer();
