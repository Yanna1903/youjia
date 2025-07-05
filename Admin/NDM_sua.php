<?php
    ob_start();
    include '../includes/youjia_connect.php';

    $id = isset($_GET['id']) ? intval($_GET['id']) : 0;

    if ($id == 0) {
        die("Thương hiệu không tồn tại.");
    }

    // Lấy thông tin thương hiệu từ DB
    $sql = "SELECT * FROM NhomDanhMuc WHERE MaNDM = $id";
    $result = mysqli_query($conn, $sql);
    $brand = mysqli_fetch_assoc($result);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $tenNDM = $_POST['TenNDM'];

        // Cập nhật
        $sql_update = "UPDATE NhomDanhMuc 
                       SET TenNDM = '$tenNDM'
                       WHERE MaNDM = $id";

        if (mysqli_query($conn, $sql_update)) {
            echo "<script>
                    alert('Cập nhật thương hiệu thành công!');
                    window.location.href = 'QL_NDM.php';
                </script>";
        } else {
            echo "<div class='alert alert-danger'>Lỗi cập nhật: " . mysqli_error($conn) . "</div>";
        }
    }

    $conn->close();
?>

<div class="container">
    <br>
    <h2 class="text-center"><b>CẬP NHẬT NHÓM DANH MỤC</b></h2>
    <hr>
    <form action="NDM_sua.php?id=<?= $brand['MaNDM'] ?>" method="POST">
        <!-- TÊN th -->
        <div class="form-group row">
            <label class="control-label col-md-2">Tên nhóm DM</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="TenNDM" value="<?= $brand['TenNDM'] ?>" required>
            </div>
        </div>

        
        <!-- nút lưu -->
        <div class="form-group row text-center">
            <div class="col-md-offset-2 col-md-10">
                <input type="submit" value="LƯU" class="btn btn-luu" style='font-size: 16px;'>
            </div>
        </div>
    </form>
</div>

<?php
    $content = ob_get_clean();
    include 'Layout_AD.php';
?>