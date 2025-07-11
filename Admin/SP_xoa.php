<?php
include '../includes/youjia_connect.php';

if (isset($_GET['MaSP']) && !empty($_GET['MaSP'])) {
    $masp = $_GET['MaSP'];

    // kiểm tra có tồn tại sp ko
    $check = mysqli_prepare($conn, "SELECT MaSP FROM sanpham WHERE MaSP=?");
    mysqli_stmt_bind_param($check, "s", $masp);
    mysqli_stmt_execute($check);
    mysqli_stmt_store_result($check);

    if (mysqli_stmt_num_rows($check) > 0) {
        // tồn tại mới xóa
        $sql = "DELETE FROM sanpham WHERE MaSP = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $masp);
        $result = mysqli_stmt_execute($stmt);

        if ($result) {
            echo "<script>
                alert('✅ XÓA THÀNH CÔNG!');
                    window.location.href = 'QL_SP.php';
                 </script>";
        } else {
            echo "<script>
                    alert('Xóa thất bại: " . mysqli_error($conn) . "');
                    window.location.href = 'QL_SP.php';
                 </script>";
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "<script>
                alert('❌ KHÔNG TÌM THẤY MÃ SẢN PHẨM!');
                window.location.href = 'QL_SP.php';
             </script>";
    }

    mysqli_stmt_close($check);
} else {
    echo "<script>
            alert('Mã sản phẩm không hợp lệ!');
            window.location.href = 'QL_SP.php';
         </script>";
}

mysqli_close($conn);
?>
