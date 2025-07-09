<?php
ob_start();
include '../includes/youjia_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errors = [];

    $TenNDM = $_POST['TenNDM'] ?? '';

    // Kiểm tra lỗi cơ bản
    if (empty($TenNDM)) {
        $errors['TenNDM'] = "Tên nhóm danh mục không được để trống.";
    }

    if (empty($errors)) {
        $sql = "INSERT INTO NhomDanhMuc (TenNDM)
                VALUES (?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, 's', $TenNDM);
        $result = mysqli_stmt_execute($stmt);

        if ($result) {
            echo "<script>
                    alert('Thêm thương hiệu thành công!');
                    window.location.href = 'QL_NDM.php';
                  </script>";
        } else {
            echo "<div class='alert alert-danger'>Thêm mới thất bại!</div>";
        }
    }
}
?>

<div class="thongtin">
    <br>
    <h2 class="text-center mt-4"><b>THÊM NHÓM DANH MỤC MỚI </b></h2>
    <hr>
    <div class='thongtin'>
        <form method="POST" class="form-container">
            <div class="form-group">
                <label class="form-label">Tên NDM</label>
                    <input type="text" name="TenNDM" class="form-control" value="<?= htmlspecialchars($TenNDM ?? '') ?>" />
                    <span class="text-danger"><?= $errors['TenNDM'] ?? '' ?></span>
            </div>        
            <div class="button-group">
                <button type="submit" class="btn-luu"><b><i class="fas fa-save"></i> &ensp;LƯU THAY ĐỔI</b></button>
                <a href="QL_NDM.php" class="btn-th"><b><i class="fas fa-arrow-left"></i> &ensp;TRỞ VỀ</b></a>
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