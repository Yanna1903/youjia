<?php
include '../includes/youjia_connect.php';

    if (isset($_GET['id'])) {
        $math = $_GET['id'];

        $sql = "DELETE FROM nhomdanhmuc WHERE MaNDM = ?";
        $stmt = mysqli_prepare($conn, $sql);

        mysqli_stmt_bind_param($stmt, "i", $math); // 'i' đại diện cho kiểu dữ liệu integer
        $result = mysqli_stmt_execute($stmt);

        if ($result) {
            echo "<script>
                    alert('Xóa thành công!');
                    window.location.href = 'QL_NDM.php';
                  </script>";
        } else {
            echo "<script>
                    alert('Xóa thất bại! Vui lòng thử lại.');
                    window.location.href = 'QL_NDM.php';
                  </script>";
        }

        mysqli_stmt_close($stmt);
    }

    mysqli_close($conn);
?>
