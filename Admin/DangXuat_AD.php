<?php
    session_start();
    session_destroy();
    header("Location: DangNhap_AD.php"); // Chuyển hướng về trang đăng nhập
    exit();
?>