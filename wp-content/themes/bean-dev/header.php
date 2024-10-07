<?php

/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package beandev
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<script>
	// Kiểm tra xem categoryData đã có trong localStorage chưa
	let categoryData = localStorage.getItem('categoryData');

	// Khởi tạo một đối tượng categoryData
	if (!categoryData) {
		categoryData = {
			<?php
			$categories = get_terms(array(
				'taxonomy' => 'product_cat',
				'hide_empty' => false,
			));
			?>

			<?php
			// Kiểm tra nếu có danh mục
			if (!empty($categories) && !is_wp_error($categories)) {
				foreach ($categories as $category) {
					$thumbnail_id = get_term_meta($category->term_id, 'thumbnail_id', true);
					$thumbnail_url = wp_get_attachment_url($thumbnail_id);
					$name = addslashes($category->name); // Thêm dấu gạch chéo ngược tránh lỗi js
					echo "'$name': { 'thumbnail_url': '$thumbnail_url' },";
				}
			}
			?>

		};
		localStorage.setItem('categoryData', JSON.stringify(categoryData));
	} else {
		categoryData = JSON.parse(categoryData);
	}

	// Ví dụ sử dụng categoryData trong JavaScript
	document.addEventListener('DOMContentLoaded', function() {
		const menuItems = document.querySelectorAll('#mega-menu-menu-1 > .mega-menu-item');
		const subMenus = document.querySelectorAll('#mega-menu-menu-1 > .mega-menu-item >.mega-sub-menu');

		menuItems.forEach(menu_item => {
			const menuItemChild = menu_item.querySelector('.mega-menu-link');
			const name = menuItemChild.textContent.trim(); // Lấy tên danh mục
			const subMenu = menu_item.querySelector('.mega-sub-menu');

			// Kiểm tra nếu tên danh mục có trong categoryData
			if (categoryData[name]) {
				const thumbnail_url = categoryData[name].thumbnail_url;

				// Cập nhật HTML với ảnh đại diện và tên danh mục
				menuItemChild.innerHTML = `
                    <div class="center gap-1 active_menu">
                        <img src="${thumbnail_url}" alt="${name}">
                        <div>
                            <span>${name}</span>
                           ${subMenu ? `
                                      <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" style="fill: rgba(255, 255, 255, 1);">
                                      <path d="M16.293 9.293 12 13.586 7.707 9.293l-1.414 1.414L12 16.414l5.707-5.707z"></path>
                                      </svg>
                                      ` : ''}
                        </div>
                    </div>`;
			} else {
				menuItemChild.innerHTML = `
                    <div class="center gap-1 active_menu">
                        <div>
                            <span>${name}</span>
                           ${subMenu ? `
                                      <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" style="fill: rgba(255, 255, 255, 1);">
                                      <path d="M16.293 9.293 12 13.586 7.707 9.293l-1.414 1.414L12 16.414l5.707-5.707z"></path>
                                      </svg>
                                      ` : ''}
                        </div>
                    </div>`;
			}
		});

		subMenus.forEach(subMenu => {
			const subMenuItemChild = subMenu.querySelectorAll('.mega-menu-item');

			subMenuItemChild.forEach(subMenu => {
				const menuItem = subMenu.querySelector('.mega-menu-link');
				const subMenuChild = subMenu.querySelector('.mega-sub-menu');

				if (subMenuChild) {
					menuItem.innerHTML =
						menuItem.textContent +
						`
						<svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" style="fill: #666;">
						<path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z"></path>
						</svg>
                        `
				}

			})

		})
	});
</script>

<body <?php body_class(); ?>>
	<?php wp_body_open(); ?>
	<?php $upload_dir = wp_get_upload_dir(); ?>
	<div id="page" class="site">
		<header id="masthead" class="site-header">
			<div class="site-branding layout_container ">
				<div class="header-top flex !py-[8.5px] items-center justify-between">
					<div class="w-[178px] logo h-[100%]">
						<?php
						the_custom_logo();
						?>
					</div>
					<div class="container-search w-[50%] flex items-center gap-[15px]">
						<div class="flex chinhanh flex-col btn bg-[var(--main-color)]">
							Hệ thống cửa hàng
							<strong>(8 chi nhánh)</strong>
						</div>
						<div class="search">
							<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="absolute left-2 top-[7px]" style="fill: var(--main-color);">
								<path d="M10 18a7.952 7.952 0 0 0 4.897-1.688l4.396 4.396 1.414-1.414-4.396-4.396A7.952 7.952 0 0 0 18 10c0-4.411-3.589-8-8-8s-8 3.589-8 8 3.589 8 8 8zm0-14c3.309 0 6 2.691 6 6s-2.691 6-6 6-6-2.691-6-6 2.691-6 6-6z"></path>
							</svg>
							<input type="text" placeholder="Bạn muốn tìm gì?">
						</div>
					</div>

					<div class="select w-[28%] flex justify-between">
						<a href="#" class="select-item">
							<img src="<?php
										echo $upload_dir['baseurl']; ?>/2024/09/hea_phone.webp" alt="">
							<div class="flex flex-col leading-4">Hotline <strong>1900 6750</strong></div>
						</a>
						<?php $wishList = get_page_by_path('danh-sach-yeu-thich'); ?>
						<a href="<?php echo get_permalink($wishList->ID); ?>" class="select-item flex">
							<div class="icon-header">
								<svg viewBox="0 0 471.701 471.701" style="fill: var(--main-color);">
									<path d=" M433.601,67.001c-24.7-24.7-57.4-38.2-92.3-38.2s-67.7,13.6-92.4,38.3l-12.9,12.9l-13.1-13.1
									c-24.7-24.7-57.6-38.4-92.5-38.4c-34.8,0-67.6,13.6-92.2,38.2c-24.7,24.7-38.3,57.5-38.2,92.4c0,34.9,13.7,67.6,38.4,92.3
									l187.8,187.8c2.6,2.6,6.1,4,9.5,4c3.4,0,6.9-1.3,9.5-3.9l188.2-187.5c24.7-24.7,38.3-57.5,38.3-92.4
									C471.801,124.501,458.301,91.701,433.601,67.001z M414.401,232.701l-178.7,178l-178.3-178.3c-19.6-19.6-30.4-45.6-30.4-73.3
									s10.7-53.7,30.3-73.2c19.5-19.5,45.5-30.3,73.1-30.3c27.7,0,53.8,10.8,73.4,30.4l22.6,22.6c5.3,5.3,13.8,5.3,19.1,0l22.4-22.4
									c19.6-19.6,45.7-30.4,73.3-30.4c27.6,0,53.6,10.8,73.2,30.3c19.6,19.6,30.3,45.6,30.3,73.3
									C444.801,187.101,434.001,213.101,414.401,232.701z"></path>
								</svg>
							</div>
							<?php
							global $wpdb;
							$user_id = get_current_user_id();
							$wishlist_items = $wpdb->get_results(
								$wpdb->prepare("SELECT * FROM wp_yith_wcwl WHERE user_id = %d", $user_id)
							);
							$count = count($wishlist_items);

							?>
							<div class="leading-4">
								Yêu thích
								<strong class="center gap-1">
									<p class="select-item-count"><?php echo $count ?></p>sản phẩm
								</strong>
							</div>
						</a>
						<a href="<?php echo wc_get_page_permalink('myaccount'); ?>" class="select-item">
							<div class="icon-header">
								<img src="<?php
											echo $upload_dir['baseurl']; ?>/2024/09/account.webp" alt="">
							</div>
						</a>
						<a href="<?php echo wc_get_cart_url() ?>" class="select-item relative">
							<div class="icon-header">
								<img src="<?php
											echo $upload_dir['baseurl']; ?>/2024/09/icon-cart.webp" alt="">
							</div>
							<p class="select-item-count absolute top-[-7px] right-0" style="width: 16px; height: 16px;"><?php echo WC()->cart->get_cart_contents_count() ?></p>
						</a>

					</div>
				</div>
			</div><!-- .site-branding -->

			<nav id="site-navigation" class="main-navigation bg-[var(--main-color)] text-white" style="display: flex;">
				<div class="z-10 bg-[var(--main-color)] menu-left" style="flex-grow: 1; padding-right: 10px;"></div>
				<div class="container-menu flex justify-between z-1" style=" max-width: 1190px; margin: auto;">
					<?php
					wp_nav_menu(
						array(
							'theme_location' => 'menu-1',
							'menu_id'        => 'primary-menu',
						)
					);
					?>
					<div class="z-10 bg-[var(--main-color)] center" style="padding-right: 10px;">
						<div class="center pr-3">
							<svg id="btn-prev-menu" xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" style="fill: rgba(255, 255, 255, 1); cursor: pointer;">
								<path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z"></path>
							</svg>
							<svg id="btn-next-menu" xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" style="fill: rgba(255, 255, 255, 1);cursor: pointer;">
								<path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z"></path>
							</svg>
						</div>
						<?php $sale_link_page = get_page_by_path('khuyen-mai') ?>
						<a href="<?php echo get_permalink($sale_link_page) ?>" class="py-1 center btn-sale pr-3">
							<div class="center bg-white text-[var(--main-hover-color)] py-1 px-3 rounded-md font-[600] uppercase gap-1">
								<img src="<?php
											echo $upload_dir['baseurl']; ?>/2024/09/gift.webp" alt="" width="18" height="18">
								<span style="font-size: 11px;">
									Khuyến mãi
								</span>
							</div>
						</a>
					</div>
				</div>
				<div class="z-10 bg-[var(--main-color)] menu-right" style="flex-grow: 1;"></div>
			</nav><!-- #site-navigation -->
			<?php if (!is_front_page()) { ?>
				<div class="navigation py-3 bg-[#f5f5f5]">
					<div class="layout_container lou-2 text-[14px] center !justify-start gap-1">
						<a href="<?php echo get_home_url() ?>" class="!text-black">Trang chủ</a>
						<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" style="fill: rgba(0, 0, 0, 1);margin-top: 2px;">
							<path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z"></path>
						</svg>
						<?php
						if (single_term_title('', false)) {
							echo '<span class="text-[var(--main-hover-color)] ">' . single_term_title('', false) . '</span>';
						} else {
							echo '<span class="text-[var(--main-hover-color)] ">' . get_the_title() . '</span>';
						}
						?>
					</div>
				</div>
			<?php }
			?>


		</header><!-- #masthead -->