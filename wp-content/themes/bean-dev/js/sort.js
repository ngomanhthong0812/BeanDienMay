document.addEventListener('DOMContentLoaded', function () {
    const sortItems = this.querySelectorAll('.sort-item');
    const selected = this.getElementById('selected');
    const initialProductList = Array.from(this.querySelectorAll('.product-item'));
    const productList = Array.from(this.querySelectorAll('.product-item'));

    sortItems.forEach(item => (
        item.addEventListener('click', () => {
            if (productList.length > 0) {
                sort(item.textContent);
            }
            selected.textContent = item.textContent;
        })
    ))

    function formatPrice(price) {
        return price.replace(/\./g, '').replace('đ', '');
    }

    //productList.sort sort làm thay đổi mảng ban đầu
    function sort(type) {
        let sortedProducts;

        switch (type) {
            case 'Mặc định':
                sortedProducts = initialProductList;
                break;
            case 'A → Z':
                sortedProducts = productList.sort((a, b) => {
                    const nameA = a.querySelector('.product-item_name a').textContent.toLowerCase();
                    const nameB = b.querySelector('.product-item_name a').textContent.toLowerCase();
                    return nameA.localeCompare(nameB);
                })
                break;
            case 'Z → A':
                sortedProducts = productList.sort((a, b) => {
                    const nameA = a.querySelector('.product-item_name a').textContent.toLowerCase();
                    const nameB = b.querySelector('.product-item_name a').textContent.toLowerCase();
                    return nameB.localeCompare(nameA);
                })
                break;
            case 'Giá tăng dần':
                sortedProducts = productList.sort((a, b) => {
                    const priceA = formatPrice(a.querySelector('.product-item_price').textContent);
                    const priceB = formatPrice(b.querySelector('.product-item_price').textContent);
                    return priceA - priceB;
                })
                break;
            case 'Giá giảm dần':
                sortedProducts = productList.sort((a, b) => {
                    const priceA = formatPrice(a.querySelector('.product-item_price').textContent);
                    const priceB = formatPrice(b.querySelector('.product-item_price').textContent);
                    return priceB - priceA;
                })
                break;
            default:
                break;
        }
        // Cập nhật lại DOM sau khi sắp xếp
        const productContainer = document.querySelector('.product-list'); // Container
        productContainer.innerHTML = '';
        sortedProducts.forEach(product => {
            productContainer.appendChild(product);
        });
    }


});
