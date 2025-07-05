<?php
session_start();
$title = "Xác nhận đơn hàng";
include 'includes/header.php';

if (isset($_GET['MaDH'])) {
    $MaDH = $_GET['MaDH'];
}
?>

<div class="container mt-4">
    <h3 class="text-center text-success mb-4">Đơn hàng của bạn đã được đặt thành công!</h3>
    <p class="text-center">Chúng tôi sẽ liên hệ với bạn trong thời gian sớm nhất để xác nhận đơn hàng và tiến hành giao hàng.</p>

    <div class="text-center mt-3">
        <a href="index.php" class="btn btn-primary">Tiếp tục mua sắm</a>
    </div>
</div>

<?php
$content = ob_get_clean();
// include "includes/footer.php";
?>
