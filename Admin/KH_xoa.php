<?php
    include '../includes/quanao_connect.php';

    if (isset($_GET['id'])) {
        $maKH = $_GET['id'];

        $sql = "DELETE FROM khachhang WHERE MaKH = ?";
        $stmt = mysqli_prepare($conn, $sql);

        mysqli_stmt_bind_param($stmt, "i", $maKH); // 'i' đại diện cho kiểu dữ liệu integer
        $result = mysqli_stmt_execute($stmt);

        if ($result) {
            echo "<script>
                    alert('Xóa thành công!');
                    window.location.href = 'QL_KH.php';
                  </script>";
        } else {
            echo "<script>
                    alert('Xóa thất bại! Vui lòng thử lại.');
                    window.location.href = 'QL_KH.php';
                  </script>";
        }

        mysqli_stmt_close($stmt);
    }

    mysqli_close($conn);
?>