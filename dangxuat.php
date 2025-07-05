<?php
session_start();

// Giữ lại giỏ hàng
$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];

// Chỉ xóa thông tin đăng nhập (user)
unset($_SESSION['username']); // hoặc 'user' nếu bạn dùng key đó

// Khôi phục lại giỏ hàng sau khi xóa phiên
$_SESSION = []; // reset lại session
$_SESSION['cart'] = $cart; // gán lại giỏ hàng

?>

<script>
    alert("Bạn đã đăng xuất thành công!");
    window.location.href = 'index.php';
</script>
