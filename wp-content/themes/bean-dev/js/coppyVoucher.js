document.querySelectorAll(".copy-coupon-btn").forEach(function (button) {
  var btn = document.querySelectorAll(".copy-coupon-btn button");

  document.querySelectorAll(".copy-coupon-btn").forEach(function (button) {
    var btn = button.querySelectorAll("button");

    btn.forEach(item => {
      item.addEventListener("click", () => {
        // Lấy phần tử chứa mã coupon tương ứng với button
        var couponCode = button.querySelector("span").innerText;

        // Tạo một thẻ input tạm thời để sao chép mã
        var tempInput = document.createElement("input");
        tempInput.value = couponCode;
        document.body.appendChild(tempInput);

        // Chọn và sao chép mã
        tempInput.select();
        tempInput.setSelectionRange(0, 99999); // Cho các thiết bị di động

        // Thực hiện sao chép
        document.execCommand("copy");

        // Xóa thẻ input tạm thời
        document.body.removeChild(tempInput);

      })
    })

  });


});
