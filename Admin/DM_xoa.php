<?php
    include '../includes/quanao_connect.php';
    if (isset($_GET['id']))
    {
        $maDM = $_GET['id'];
        $sql = "DELETE FROM danhmuc WHERE MaDM = ".$maDM;
        $result = mysqli_query($conn, $sql);

        if ($result) {
            echo "<script>
                    alert('Xóa thành công!');
                    window.location.href = 'QL_DM.php';
                  </script>";
        } else {
            echo "<script>
                    alert('Xóa thất bại! Vui lòng thử lại.');
                    window.location.href = 'QL_DM.php';
                  </script>";
        }
    }
    mysqli_close($conn);
?>