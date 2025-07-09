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
<h2 class="text-center mt-4"><b>CẬP NHẬT NHÓM DANH MỤC</b></h2>
<hr style="width:50%;">

<div class="thongtin">
    <form method="POST" class="form-container" style="background:#f9f9f9; border-radius:12px;">
        <input type="hidden" name="MaDM" value="<?= htmlspecialchars($MaDM ?? '') ?>">

        <div class="form-group">
            <label for="TenDM" class="form-label">Tên NDM</label>
            <input type="text" name="TenDM" id="TenDM" class="form-control"
                value="<?= htmlspecialchars($TenDM ?? '') ?>">
            <span class="text-danger"><?= $errors['TenDM'] ?? '' ?></span>
        </div>

        <div class="button-group">
            <button type="submit" class="btn-luu"><b><i class="fas fa-save"></i> &ensp;LƯU THAY ĐỔI</b></button>
            <a href="QL_NDM.php" class="btn-th"><b><i class="fas fa-arrow-left"></i> &ensp; TRỞ VỀ</b></a>
        </div>
    </form>
</div>
<?php
    $content = ob_get_clean();
    include 'Layout_AD.php';
?>
<style>
    .btn-th, .btn-luu{
        width: 49%;
    }
</style>