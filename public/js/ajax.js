////// xử lý ajax cập nhật số lượng sản phẩm trong giỏ hàng
$(document).ready(function () {
    $(".changeQuantity").click(function (e) {
        e.preventDefault();

        var qty_input = $(this).closest(".quantity").find("#num_order").val();
        var product_id = $(this)
            .closest(".quantity")
            .find("#num_order")
            .attr("data-id");
        var token = $('meta[name="csrf-token"]').attr("content"); /// nếu dung POST

        var data = {
            quantity: qty_input,
            product_id: product_id,
            _token: token,
        };
        console.log(data);
        // Gửi yêu cầu AJAX
        $.ajax({
            url: `update`,
            method: "POST",
            data: data,
            dataType: "text",
            success: function (data) {
                // window.location.reload(); // giúp refresh lại page ngay lập tức
                // $(".sub-total").html(data.sub_total);
                // $("#total-price span").html(data.totalPrice);
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status);
                alert(thrownError);
            },
        });
    });
});
///////// xử lý ajax trong phần detail product
$(document).ready(function () {
    $("#add_product").on("click", function (e) {
        e.preventDefault();
        // alert("aloo");
        var qty_input = $(this)
            .closest("#add-to-cart")
            .find("#num-order")
            .val();
        var product_id = $(this)
            .closest("#add-to-cart")
            .find("#num-order")
            .attr("data-id");   
        var token = $('meta[name="csrf-token"]').attr("content"); /// nếu dung POST

        var data = {
            quantity: qty_input,
            product_id: product_id,
            _token: token,
        };
        console.log(data);
        // Gửi yêu cầu AJAX
        $.ajax({
            url: `add/${data.product_id}`,
            method: "GET",
            data: data,
            dataType: "text",
            success: function (data) {
                // console.log(data);
                window.location.reload(); // giúp refresh lại page ngay lập tức
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status);
                alert(thrownError);
            },
        });
    });
});
/////////////// xử lý ajax select box
$(document).ready(function () {
    //listen for changes in the 'province' select box
    $("#province").on("change", function (e) {
        e.preventDefault();

        var province_id = $(this).val();
        // var token = $('meta[name="csrf-token"]').attr("content"); /// nếu dung POST

        var data = {
            province_id: province_id,
            // _token: token, /// nếu dung POST
        };

        // console.log(data);
        if (province_id) {
            $.ajax({
                url: `checkout/get_district_data`,
                method: "GET",
                data: data,
                dataType: "json", // Đảm bảo đúng kiểu dữ liệu trả về là JSON
                success: function (data) {
                    // console.log(data);
                    // xóa tất cả selection hiện có trong select box
                    $("#district").empty();
                    // thêm mới options theo province
                    $.each(data, function (i, district) {
                        // console.log(district);
                        $("#district").append(
                            $("<option>", {
                                Value: district.id,
                                text: district.name,
                            })
                        );
                    });
                    // xóa các option của ward có trong select box
                    $("#ward").empty();
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert("error:" + thrownError);
                },
            });
        } else {
            // xóa tất cả selection hiện có trong select box nếu không tồn tại
            $("#district").empty();
        }
    });
});

$(document).ready(function () {
    //listen for changes in the 'province' select box
    $("#district").on("change", function (e) {
        e.preventDefault();

        var district_id = $(this).val();
        // var token = $('meta[name="csrf-token"]').attr("content"); /// nếu dung POST

        var data = {
            district_id: district_id,
            // _token: token, /// nếu dung POST
        };

        // console.log(data);
        if (district_id) {
            $.ajax({
                url: `checkout/get_ward_data`,
                method: "GET",
                data: data,
                dataType: "json", // Đảm bảo đúng kiểu dữ liệu trả về là JSON
                success: function (data) {
                    // console.log(data);
                    // xóa tất cả selection hiện có trong select box
                    $("#ward").empty();
                    // thêm mới options theo province
                    $.each(data, function (i, ward) {
                        // console.log(district);
                        $("#ward").append(
                            $("<option>", {
                                Value: ward.id,
                                text: ward.name,
                            })
                        );
                    });
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert("error:" + thrownError);
                },
            });
        } else {
            // xóa tất cả selection hiện có trong select box nếu không tồn tại
            $("#ward").empty();
        }
    });
});
