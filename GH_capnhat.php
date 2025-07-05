<?php
session_start();

// Kiểm tra nếu có dữ liệu POST từ form
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['soluong'])) {
    foreach ($_POST['soluong'] as $id => $soluong) {
        // Kiểm tra xem sản phẩm có tồn tại trong giỏ hàng hay không
        if (isset($_SESSION['cart'][$id])) {
            // Đảm bảo số lượng hợp lệ (là số nguyên dương)
            $soluong = intval($soluong);
            if ($soluong > 0) {
                // Cập nhật số lượng mới cho sản phẩm
                $_SESSION['cart'][$id]['soluong'] = $soluong;
            } else {
                // Nếu số lượng bằng hoặc nhỏ hơn 0, xóa sản phẩm khỏi giỏ hàng
                unset($_SESSION['cart'][$id]);
            }
        }
    }

    // Nếu giỏ hàng trống sau khi cập nhật, xóa toàn bộ giỏ hàng
    if (empty($_SESSION['cart'])) {
        unset($_SESSION['cart']);
        // Hiển thị cảnh báo giỏ hàng trống rồi chuyển về trang giỏ hàng
        echo "<script>
                alert('Giỏ hàng của bạn hiện đang trống!');
                window.location.href = 'giohang.php';
              </script>";
        exit; // Dừng script sau khi chuyển hướng
    }
}

// Nếu giỏ hàng vẫn còn sản phẩm, chuyển hướng về trang giỏ hàng bình thường
header("Location: giohang.php");
exit;
?>
