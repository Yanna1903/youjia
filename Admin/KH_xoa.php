<?php
include '../includes/youjia_connect.php';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $maKH = (int)$_GET['id'];

    // Kiểm tra KH có tồn tại
    $check = mysqli_query($conn, "SELECT * FROM khachhang WHERE MaKH = $maKH");
    if (mysqli_num_rows($check) == 0) {
        echo "<script>
            alert('❌ Không tìm thấy khách hàng!');
            window.location.href = 'QL_KH.php';
        </script>";
        exit;
    }

    // Thử xoá
    $sql = "DELETE FROM khachhang WHERE MaKH = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $maKH);

    if (mysqli_stmt_execute($stmt)) {
        echo "<script>
            alert('✅ XÓA THÀNH CÔNG!');
            window.location.href = 'QL_KH.php';
        </script>";
    } else {
        echo "<script>
            alert('❌ Xóa thất bại! Khách hàng có thể đang có đơn hàng liên quan.');
            window.location.href = 'QL_KH.php';
        </script>";
    }

    mysqli_stmt_close($stmt);
} else {
    echo "<script>
        alert('⚠️ Không tìm thấy ID khách hàng!');
        window.location.href = 'QL_KH.php';
    </script>";
}

mysqli_close($conn);
?>
