<?php
    include '../includes/youjia_connect.php';

    if (isset($_GET['id'])) {
        $masp = $_GET['id'];

        $sql = "DELETE FROM sanpham WHERE MaSP = ?";
        $stmt = mysqli_prepare($conn, $sql);

        mysqli_stmt_bind_param($stmt, "s", $masp); // 'i' đại diện cho kiểu dữ liệu integer
        $result = mysqli_stmt_execute($stmt);

        if ($result) {
            echo "<script>
                    alert('Xóa thành công!');
                    window.location.href = 'QL_SP.php';
                  </script>";
        } else {
            echo "<script>
                    alert('Xóa thất bại! Vui lòng thử lại.');
                    window.location.href = 'QL_SP.php';
                  </script>";
        }

        mysqli_stmt_close($stmt);
    }

    mysqli_close($conn);
?>
