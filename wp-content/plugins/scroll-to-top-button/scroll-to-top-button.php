<?php
/*
Plugin Name: Scroll to Top Button
Description: Plugin đơn giản để thêm nút "Kéo lên đầu trang".
Version: 1.0
Author: Tên của bạn
*/

// Thêm nút và script
function add_scroll_to_top_button()
{
    echo '<button id="scrollTopBtn">
  <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" style="fill: white;"><path d="m6.293 13.293 1.414 1.414L12 10.414l4.293 4.293 1.414-1.414L12 7.586z"></path></svg>
     </button>';
}
add_action('wp_footer', 'add_scroll_to_top_button');

// Thêm JavaScript để xử lý sự kiện cuộn trang
function scroll_to_top_script()
{
?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var scrollToTopBtn = document.getElementById('scrollTopBtn');

            window.onscroll = function() {
                if (document.body.scrollTop > 200 || document.documentElement.scrollTop > 200) {
                    scrollToTopBtn.style.display = 'block';
                } else {
                    scrollToTopBtn.style.display = 'none';
                }
            };

            scrollToTopBtn.onclick = function() {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            };
        });
    </script>
<?php
}
add_action('wp_footer', 'scroll_to_top_script');


// Enqueue file CSS
function enqueue_scroll_to_top_styles()
{
    wp_enqueue_style('scroll-to-top-button-css', plugin_dir_url(__FILE__) . 'scroll-to-top-button.css');
}
add_action('wp_enqueue_scripts', 'enqueue_scroll_to_top_styles');
