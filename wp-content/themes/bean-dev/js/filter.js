document.addEventListener('DOMContentLoaded', function () {
    const filters = this.querySelectorAll('.filter-item');
    const productList = Array.from(this.querySelectorAll('.product-item'));
    const filteItemCategories = this.querySelectorAll('#filte-category .filter-item_child_item');
    const filteItemPrice = this.querySelectorAll('#filte-price .filter-item_child_item');
    const infoFilter = this.querySelector('#info-filter');

    // mảng chứa các filter cha
    let arrFilter = {
        categories: [],
        prices: [],
    };

    // Xử lý khi người dùng click vào một filter cha
    filters.forEach(item => {
        item.addEventListener('click', (event) => {
            const currentIcon = item.querySelector('svg');
            event.stopPropagation();

            filters.forEach(i => {
                const icon = i.querySelector('svg');
                if (i !== item) i.classList.remove('active')
                if (icon !== currentIcon) icon.classList.remove('active')
            });

            currentIcon.classList.toggle('active');
            item.classList.toggle('active');
        })
    })

    // Xóa các class của filter khi click ra ngoài
    document.addEventListener('click', (event) => {
        filters.forEach(i => {
            i.classList.remove('active');
        });
    });

    // format giá vd: 1.000.000 => 1000000
    function formatPrice(price) {
        return price.replace(/\./g, '').replace('đ', '');
    }

    //Xử lý khi click vào filter item category
    filteItemCategories.forEach(item => {
        item.addEventListener('click', (event) => {
            const checkbox = item.querySelector('input');
            const dataSlug = item.getAttribute('slug');
            const name = item.textContent.trim();

            if (!arrFilter.categories.some(item => item.slug === dataSlug)) {
                arrFilter.categories = [...arrFilter.categories, { name: name, slug: dataSlug }];
                checkbox.checked = true;

                addFilterInfoItem(name, dataSlug, null, null);
            } else {
                const infoFilterByAtbName = document.querySelector(`#info-filter-item[slug="${dataSlug}"]`);
                infoFilterByAtbName.remove();

                arrFilter.categories = arrFilter.categories.filter(item => item.slug !== dataSlug);
                checkbox.checked = false;
            }
            applyFilters();
            handelUpdateFilter();
        });
    });

    //Xử lý khi click vào filter item price
    filteItemPrice.forEach(item => {
        item.addEventListener('click', (event) => {
            const checkbox = item.querySelector('input');
            const minPrice = item.getAttribute('min-price');
            const maxPrice = item.getAttribute('max-price');
            const name = item.textContent.trim();

            if (!arrFilter.prices.some(item => item.name === name)) {
                arrFilter.prices = [...arrFilter.prices, { name: name, minPrice: minPrice, maxPrice: maxPrice }];
                checkbox.checked = true;

                addFilterInfoItem(name, null, minPrice, maxPrice);
            } else {
                const infoFilterByAtbMinPrice = document.querySelector(`#info-filter-item[min-price="${minPrice}"]`);
                infoFilterByAtbMinPrice.remove();

                arrFilter.prices = arrFilter.prices.filter(item => item.name !== name);
                checkbox.checked = false;
            }
            applyFilters();
            handelUpdateFilter();
        });
    });

    //Thêm hiển thị giao diện cho các filter item đã chọn
    function addFilterInfoItem(name, slug = null, minPrice, maxPrice) {
        infoFilter.innerHTML += `
                <span id="info-filter-item" ${minPrice ? `min-price="${minPrice}" max-price="${maxPrice}"` : ""} ${slug ? `slug = "${slug}"` : ""}>${name}
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24">
                <path d="m16.192 6.344-4.243 4.242-4.242-4.242-1.414 1.414L10.535 12l-4.242 4.242 1.414 1.414 4.242-4.242 4.243 4.242 1.414-1.414L13.364 12l4.242-4.242z"></path>
                </svg>
                </span>`;
    }


    // Xử lý khi người dùng bấm vào các filter item của mục thông tin hiển thị ra giao diện
    function handelUpdateFilter() {
        const infoFilter = document.querySelectorAll('#info-filter-item');

        infoFilter.forEach(info => {
            info.addEventListener('click', (event) => {
                const dataSlug = info.getAttribute('slug');
                const minPrice = info.getAttribute('min-price');

                // cập nhật
                arrFilter.categories = arrFilter.categories.filter(item => item.slug !== dataSlug);
                arrFilter.prices = arrFilter.prices.filter(item => item.minPrice !== minPrice);

                // lấy ra các checkbox phù hợp vs filter item vừa nhấn -> thật hiện thay đổi checked
                const getCheckBoxByAtbSlug = document.querySelector(`#filte-category .filter-item_child_item[slug="${dataSlug}"] input`);
                const getCheckBoxByAtbMinPrice = document.querySelector(`#filte-price .filter-item_child_item[min-price="${minPrice}"] input`);

                if (getCheckBoxByAtbSlug) getCheckBoxByAtbSlug.checked = false;
                if (getCheckBoxByAtbMinPrice) getCheckBoxByAtbMinPrice.checked = false;

                info.remove();
                applyFilters();
            });
        })

    }

    // lọc sản phẩm
    //Cách lọc
    //- Lấy ra các sản phẩm thoả 1 trong các điều kiện của bộ lọc cha(bộ lọc cha -> arr.categories,arr.prices ....);
    function applyFilters() {
        let filteredProducts = productList;
        const productContainer = document.querySelector('.product-list');
        const notificationFilter = document.querySelector('.notification-filter');

        if (productContainer) {
            productContainer.innerHTML = '';

            if (arrFilter.categories.length > 0) {
                filteredProducts = filteredProducts.filter(product => {
                    let categories = Array.from(product.querySelectorAll('#category_item'));
                    categories = categories.map(category => category.textContent);

                    return categories.some(category => arrFilter.categories.some(arr => arr.slug === category));
                })
            }
            if (arrFilter.prices.length > 0) {
                filteredProducts = filteredProducts.filter(product => {
                    const price = formatPrice(product.querySelector('.product-item_price').textContent);

                    return arrFilter.prices.some(arr => {
                        let minPrice = parseFloat(arr.minPrice);
                        let maxPrice = parseFloat(arr.maxPrice);
                        let priceValue = parseFloat(price);

                        return priceValue >= minPrice && price <= maxPrice
                    });
                });
            }
            if (filteredProducts.length == 0) {
                notificationFilter.innerHTML = '<p class="woocommerce-notification">Không có sản phẩm nào trong danh mục này.</p>'
            } else {
                notificationFilter.innerHTML = '';
            }
            filteredProducts.forEach(product => productContainer.appendChild(product));

        }
    }

});