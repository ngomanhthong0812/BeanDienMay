<?php

/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
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

global $product;

/**
 * Hook: woocommerce_before_single_product.
 *
 * @hooked woocommerce_output_all_notices - 10
 */
do_action('woocommerce_before_single_product');

if (post_password_required()) {
	echo get_the_password_form(); // WPCS: XSS ok.
	return;
}
?>
<?php wp_enqueue_script('coppyVoucher-js', get_template_directory_uri() . '/js/coppyVoucher.js', array(), 'v2', true); ?>
<div id="product-<?php the_ID(); ?>" <?php wc_product_class('', $product); ?>>
	<div class="flex gap-3">
		<?php
		/**
		 * Hook: woocommerce_before_single_product_summary.
		 *
		 * @hooked woocommerce_show_product_sale_flash - 10
		 * @hooked woocommerce_show_product_images - 20
		 */
		do_action('woocommerce_before_single_product_summary');
		?>

		<!-- <div class="summary entry-summary">
			<?php
			/**
			 * Hook: woocommerce_single_product_summary.
			 *
			 * @hooked woocommerce_template_single_title - 5
			 * @hooked woocommerce_template_single_rating - 10
			 * @hooked woocommerce_template_single_price - 10
			 * @hooked woocommerce_template_single_excerpt - 20
			 * @hooked woocommerce_template_single_add_to_cart - 30
			 * @hooked woocommerce_template_single_meta - 40
			 * @hooked woocommerce_template_single_sharing - 50
			 * @hooked WC_Structured_Data::generate_product_data() - 60
			 */
			do_action('woocommerce_single_product_summary');
			?>
		</div> -->
		<?php
		$getProduct = get_product_by_id($product->get_id())
		?>
		<div class="wc-detail-product">
			<h1 class="text-[22px]"><?php echo $getProduct['name'] ?></h1>
			<div class="text-[14px] border-b-[1px] pb-2">
				<span>
					Thương hiệu: <span class="text-[var(--main-color)]"><?php echo $getProduct['brand_name'] ?></span>
				</span>
				<span>
					Tình trạng: <span class="text-[var(--main-color)]"><?php echo $getProduct['status'] ?></span>
				</span>
			</div>
			<?php if ($getProduct['regular_price']): ?>
				<div class="price text-[22px] pt-1">
					Giá: <span class="text-[#cc2020] font-[600]"><?php echo $getProduct['sale_price'] ? number_format($getProduct['sale_price'], 0, '', '.') . 'đ' : 'Liên hệ' ?></span>
				</div>
				<div class="flex text-[13px] text-[#868686] gap-3 pb-2">
					<div class="regular_price">
						Giá thị trường: <span class="line-through"><?php echo $getProduct['regular_price'] ? number_format($getProduct['regular_price'], 0, '', '.') . 'đ' : '' ?></span>
					</div>
					<div class="regular_price">
						Tiết kiệm: <span><?php echo $getProduct['regular_price'] ? number_format((float) $getProduct['regular_price'] - (float) $getProduct['sale_price'], 0, '', '.') . 'đ' : '' ?> so với giá thị trường</span>
					</div>
				</div>
			<?php endif ?>
			<div class="sale_special border text-[14px] rounded-md">
				<div class="bg-[#f6f6f6] font-[500] p-2">Khuyến mãi đặc biệt !!!</div>
				<ul class="m-0">
					<li class="flex p-2 gap-2 center !justify-start"><span class="bg-[var(--main-color)] text-white rounded-full w-[10px] h-[10px] p-2 center text-[10px]">1</span>Giảm 100,000đ cho đơn hàng từ 10 triệu khi thanh toán quét mã SmartPay QR bằng ứng dụng ngân hàng</li>
					<li class="flex p-2 gap-2 center !justify-start"><span class="bg-[var(--main-color)] text-white rounded-full w-[10px] h-[10px] p-2 center text-[10px]">1</span>Giảm thêm 2% khi mua cùng sản phẩm bất kỳ có giá cao hơn</li>
					<li class="flex p-2 gap-2 center !justify-start"><span class="bg-[var(--main-color)] text-white rounded-full w-[10px] h-[10px] p-2 center text-[10px]">1</span>Giảm 10% gói Bảo hiểm rơi vỡ</li>
				</ul>
			</div>
			<?php if ($getProduct['regular_price'] && $getProduct['status'] === "Còn hàng") { ?>
				<div class="form-product">
					<div class="custom custom-btn-number">
						<label>Số lượng:</label>
						<div class="input_number_product">
							<button class="btn_num num_1 button button_qty" onclick="" type="button">−</button>
							<input type="text" id="qtym" name="quantity" value="1" maxlength="3" class="prd_quantity">
							<button class="btn_num num_2 button button_qty" onclick="" type="button"><span>+</span></button>
						</div>
					</div>

					<a href="<?php echo $product->add_to_cart_url() ?>"
						value="<?php echo esc_attr($product->get_id()); ?>"
						data-product_id="<?php echo get_the_ID(); ?>"
						aria-label="Add “<?php the_title_attribute() ?>” to your cart"
						id="btn-buy-now"
						class="ajax_add_to_cart add_to_cart_button flex flex-col mt-[10px] items-center bg-[var(--main-color)] hover:bg-[#0083bf] duration-200 !text-white border-none leading-5 text-[13px] p-2 rounded-md">
						<span class="uppercase font-[700]">Mua ngay</span>
						Giao hàng tận nơi hoặc nhận tại cửa hàng
					</a>

					<div class="flex gap-3 mt-[10px]">
						<a href="<?php echo $product->add_to_cart_url() ?>"
							value="<?php echo esc_attr($product->get_id()); ?>"
							class="ajax_add_to_cart add_to_cart_button flex flex-1 items-center justify-center border border-[var(--main-color)] hover:!text-[var(--main-hover-color)] hover:border-[var(--main-hover-color)] duration-200 !text-[var(--main-color)] text-[13px] p-2 rounded-md"
							data-product_id="<?php echo get_the_ID(); ?>"
							data-quantity="1"
							id="add-to-cart-button"
							aria-label="Add “<?php the_title_attribute() ?>” to your cart">
							<span class="uppercase font-[700]">Thêm vào giỏ hàng</span>
						</a>
						<?php echo do_shortcode('[loading_cart_icon]') ?>
						<div class="quick-view-add-to-cart">
							<div class="text-[14px] bg-white rounded-md w-[450px] mb-[100px]">
								<div class="p-2 font-[600] bg-[var(--main-color)] rounded-t-md text-white">
									Mua hàng thành công
								</div>
								<div class="px-2 pb-2 flex gap-2 font-[600]">
									<img src=" https://bizweb.dktcdn.net/thumb/compact/100/488/001/products/maylanhdaikininverter15hpfb8b0.jpg" alt="" class="w-[80px]">
									<div class="flex flex-col justify-center">
										<span id="name"><?php echo $getProduct['name'] ?></span>
										<p class="m-0 mt-2" id="price"><?php echo $getProduct['sale_price'] ? number_format($getProduct['sale_price'], 0, '', '.') . 'đ' : 'Liên hệ' ?></p>
									</div>
								</div>
								<div class="p-2 border border-t rounded-b-md">
									<div class="pb-2 text-[#535353]">Giỏ hàng của bạn hiện có <span id="quantity"></span> sản phẩm</div>
									<div class="flex gap-2">
										<button id="continue-buy" class="center flex-1 p-2 rounded-md !text-white bg-[#646464] hover:bg-[#535353] text-[14px]" onclick="unQuickView()">Tiếp tục mua hàng</button>
										<a href="<?php echo esc_url(wc_get_checkout_url()); ?>" class="center flex-1 p-2 rounded-md !text-white bg-[var(--main-color)] hover:bg-[var(--main-hover-color)]">Thanh toán ngay</a>
									</div>
								</div>
							</div>
						</div>

						<a href="#"
							class="flex flex-1 flex-col items-center border border-[var(--main-color)] hover:!text-[var(--main-hover-color)] hover:border-[var(--main-hover-color)] duration-200 !text-[var(--main-color)] leading-5 text-[13px] p-2 rounded-md">
							<span class="uppercase font-[700]">Mua trả góp</span>
							Duyệt hồ sơ trong 5 phút
						</a>
					</div>

					<div class="free-ship mt-[15px] bg-green-600 text-white text-[13px] center rounded-md font-[500]">
						Đơn hàng được miễn phí vận chuyển
					</div>
				</div>
			<?php } else { ?>
				<div class="price text-[22px] pt-1"><span class="text-[#cc2020] font-[600]">Liên hệ</span></div>
			<?php } ?>
		</div>
		<div class="wc-voucher-product">
			<?php
			get_woocommerce_coupons();
			productPolicies();
			?>
		</div>
	</div>

	<div class="flex gap-[15px] entry-content">
		<div class="product-tabs">
			<?php
			/**
			 * Hook: woocommerce_after_single_product_summary.
			 *
			 * @hooked woocommerce_output_product_data_tabs - 10
			 * @hooked woocommerce_upsell_display - 15
			 * @hooked woocommerce_output_related_products - 20
			 */
			remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);
			remove_action('woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15);
			do_action('woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs');
			?>
		</div>
		<?php do_action('my_custom_action_additional_information'); ?>


	</div>
	<?php

	do_action('my_custom_action_related_products');
	?>
</div>



<script>
	document.addEventListener('DOMContentLoaded', function() {
		const btn1 = document.querySelector('.num_1');
		const btn2 = document.querySelector('.num_2');
		const value = document.getElementById('qtym');
		const btnAddToCart = document.getElementById('add-to-cart-button');
		const btnBuyNow = document.getElementById('btn-buy-now');

		const quickViewCart = document.querySelector('.quick-view-add-to-cart');
		const eName = document.querySelector('.quick-view-add-to-cart #name');
		const ePrice = document.querySelector('.quick-view-add-to-cart #price');
		const eQuantity = document.querySelector('.quick-view-add-to-cart #quantity');

		const loading = document.querySelector('#lcp-loading');

		const checkoutUrl = "<?php echo esc_url(wc_get_checkout_url()); ?>";

		let quantity = 1;


		btn1.addEventListener('click', function() {
			if (quantity > 1) {
				quantity--;
				value.value = quantity;
			}
		})
		btn2.addEventListener('click', function() {
			quantity++;
			value.value = quantity;
		})

		// Thêm sản phẩm vào giỏ hàng và cập nhật số lượng sp trong giỏ hàng
		btnAddToCart.addEventListener('click', function(e) {
			e.preventDefault();
			btnAddToCart.setAttribute('data-quantity', quantity);

			loading.style.display = 'block';
			fetchCartCount().then(quantityCart => {
				loading.style.display = 'none';
				eQuantity.innerHTML = Number(quantityCart) + Number(quantity);
				quickViewCart.classList.add('active');
			});

		})

		// Kiểm tra khi đã thêm sản phẩm thành công vào giỏ hàng và chuyển hướng chức năng 'Mua Ngay'
		btnBuyNow.addEventListener('click', function() {
			quantity = value.value;
			event.preventDefault();
			console.log('Đang gửi AJAX để thêm sản phẩm vào giỏ hàng...');

			// Cập nhật số lượng sản phẩm cần thêm
			btnBuyNow.setAttribute('data-quantity', quantity);

			// Bắt đầu quá trình gửi AJAX của WooCommerce
			var ajaxUrl = btnBuyNow.getAttribute('href');

			ajaxUrl += '&quantity=' + quantity;

			// Gửi yêu cầu AJAX
			fetch(ajaxUrl)
				.then(function(response) {
					return response.text();
				})
				.then(function(data) {
					console.log('Sản phẩm đã được gửi qua AJAX');
					window.location.href = checkoutUrl; // Chuyển hướng tới trang giỏ hàng
				})
				.catch(function(error) {
					console.error('Có lỗi xảy ra khi thêm sản phẩm vào giỏ hàng:', error);
				});
		});

		// Hàm lấy số lượng sản phẩm trong giỏ hàng hiện tại
		function fetchCartCount() {
			return fetch('<?php echo admin_url('admin-ajax.php'); ?>?action=get_cart_count')
				.then(response => response.text())
				.then(count => {
					console.log("Số lượng sản phẩm trong giỏ hàng: ", count);
					return count; // Trả về giá trị số lượng
				})
				.catch(error => {
					console.error('Lỗi khi lấy số lượng giỏ hàng:', error);
					return 0; // Trả về 0 nếu có lỗi
				});
		}

	});

	// Hàm hiển thị bảng xem nhanh khi thêm vào giỏ hàng
	function unQuickView() {
		const quickViewCart = document.querySelector('.quick-view-add-to-cart');
		quickViewCart.classList.remove('active');
	}
</script>

<?php do_action('woocommerce_after_single_product'); ?>