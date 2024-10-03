<?php

/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package bean.dev
 */

?>

<footer id="colophon" class="site-footer">
	<?php $upload_dir = wp_get_upload_dir(); ?>
	<div class="site-info layout_container">
		<div class="footer-container">
			<div class="footer-section w-[33%]">
				<h3>THÔNG TIN CHUNG</h3>
				<p>Với sứ mệnh "Khách hàng là ưu tiên số 1" chúng tôi luôn mang lại giá trị tốt nhất</p>
				<p><strong>Địa chỉ:</strong> 70 Lữ Gia, Phường 15, Quận 11, TP. Hồ Chí Minh</p>
				<p><strong>Điện thoại: <a href="#"> <span class="highlight"> 1900 6750</span></a></strong></p>
				<p><strong>Email: <a href="#"> <span class="highlight"> suport@gmail.com</span></a></strong></p>
			</div>

			<div class="footer-section w-[20%]">
				<h3>CHÍNH SÁCH</h3>
				<?php
				$args = array(
					'post_type' => 'policy', // Tên CPT của bạn
					'posts_per_page' => 5, // lấy 5 bài viết
				);

				$policy_posts = get_posts($args);

				if (!empty($policy_posts)) {
					foreach ($policy_posts as $post) {
						setup_postdata($post); // Thiết lập dữ liệu cho bài viết
						printf('<a href="%s"><li>%s</li></a>', get_permalink($post->ID), get_the_title($post->ID));
					}
					wp_reset_postdata(); // Đặt lại dữ liệu bài viết
				} else {
					echo 'Không có bài viết nào.';
				}
				?>
			</div>

			<div class="footer-section w-[20%]">
				<h3>HỖ TRỢ</h3>
				<li>Kinh doanh: <a href="#"> <strong class="highlight"> 1900 800 111</strong></a></li>
				<li>Bảo hành: <a href="#"> <strong class="highlight"> 1900 800 222</strong></a></li>
				<li>Kiếu nại: <a href="#"> <strong class="highlight"> 1900 800 333</strong></a></li>
				<?php $contact_page = get_page_by_path('lien-he'); ?>
				<a href="<?php echo get_permalink($contact_page->ID) ?>">
					<li>Liên hệ</li>
				</a>
			</div>

			<div class="footer-section w-[27%]">
				<h3>PHƯƠNG THỨC THANH TOÁN</h3>
				<div class="payment-methods">
					<div><img src="<?php echo $upload_dir['baseurl']; ?>/2024/09/payment-1.webp" alt="Mastercard"></div>
					<div><img src="<?php echo $upload_dir['baseurl']; ?>/2024/09/payment-2.webp" alt="Visa"></div>
					<div><img src="<?php echo $upload_dir['baseurl']; ?>/2024/09/payment-3.webp" alt="JCB"></div>
					<div><img src="<?php echo $upload_dir['baseurl']; ?>/2024/09/payment-4.webp" alt="ZaloPay"></div>
				</div>
			</div>
		</div>

		<div class="footer-bottom">
			© Bản quyền thuộc về <strong>Mr. Bean</strong> | Cung cấp bởi <strong>Bean</strong>
		</div>
	</div><!-- .site-info -->
</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>

</html>