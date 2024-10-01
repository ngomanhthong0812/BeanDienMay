<?php
/*
Plugin Name: Loading Cart Plugin
Description: Hiển thị biểu tượng loading khi thêm sản phẩm vào giỏ hàng.
Version: 1.0
Author: BeanDienMay
*/

function lcp_enqueue_scripts()
{
    wp_enqueue_style('lcp-styles', plugin_dir_url(__FILE__) . 'css/lcp-styles.css');
    wp_enqueue_script('lcp-scripts', plugin_dir_url(__FILE__) . 'js/lcp-scripts.js', array('jquery'), '1.0', true);
}
add_action('wp_enqueue_scripts', 'lcp_enqueue_scripts');

// Thêm HTML cho biểu tượng loading vào trang
function lcp_add_loading_icon()
{
    echo '<div id="lcp-loading" style="display:none;">
            <div class="lcp-spinner"></div>
          </div>';
}
add_action('wp_footer', 'lcp_add_loading_icon');

function lcp_loading_icon()
{
    return '<div id="lcp-loading" style="display:none;">
                <div class="lcp-spinner"></div>
            </div>';
}
add_shortcode('loading_cart_icon', 'lcp_loading_icon');
