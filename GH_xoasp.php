<?php
session_start();

// Kiểm tra nếu có tham số id được truyền qua URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Nếu sản phẩm tồn tại trong giỏ hàng thì xóa
    if (isset($_SESSION['cart'][$id])) {
        unset($_SESSION['cart'][$id]);
    }

    // Nếu sau khi xóa mà giỏ hàng rỗng thì xóa luôn session 'cart'
    if (empty($_SESSION['cart'])) {
        unset($_SESSION['cart']);
    }
}

// Quay lại trang giỏ hàng
header("Location: giohang.php");
exit();
?>
