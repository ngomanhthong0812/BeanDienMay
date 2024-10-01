document.addEventListener('DOMContentLoaded', function () {
    // Lắng nghe sự kiện khi người dùng nhấn nút "Thêm vào giỏ hàng"
    document.addEventListener('click', function (event) {
        if (event.target.classList.contains('ajax_add_to_cart')) {
            document.getElementById('lcp-loading').style.display = 'block'; // Hiển thị biểu tượng loading
        }
    });

    // Ẩn loading khi giỏ hàng được làm mới
    document.body.addEventListener('added_to_cart', function () {
        document.getElementById('lcp-loading').style.display = 'none'; // Ẩn biểu tượng loading
    });
});
