<?php
ob_start();
include '../includes/youjia_connect.php';

if (isset($_GET['id'])) {
    $MaDM = intval($_GET['id']);

    $sql = "SELECT * FROM DanhMuc WHERE MaDM = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $MaDM);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result && $dm = mysqli_fetch_assoc($result)) {
        $TenDM = $dm['TenDM'];
    } else {
        echo "<div class='alert alert-danger'>Không tìm thấy danh mục!</div>";
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errors = [];
    $MaDM = $_POST['MaDM'] ?? '';
    $TenDM = $_POST['TenDM'] ?? '';

    if (empty($MaDM)) {
        $errors['MaDM'] = "Mã danh mục không hợp lệ.";
    }
    if (empty($TenDM)) {
        $errors['TenDM'] = "Tên danh mục không được để trống.";
    }

    if (empty($errors)) {
        $sql = "UPDATE DanhMuc SET TenDM = ? WHERE MaDM=?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "si", $TenDM, $MaDM);
        $result = mysqli_stmt_execute($stmt);

        if ($result) {
            echo "<script>
                    alert('Cập nhật thành công!');
                    window.location.href = 'QL_DM.php';
                  </script>";
            exit;
        } else {
            echo "<div class='alert alert-danger'>Cập nhật thất bại!</div>";
        }
    }
}
?>

<div class="container">
    <h2 class="text-center mt-4"><b>SỬA DANH MỤC</b></h2>
    <hr />
    <form class="form-horizontal" method="POST" action="">
        <input type="hidden" name="MaDM" value="<?= htmlspecialchars($MaDM ?? '') ?>">
        <!-- Tên Danh Mục -->
        <div class="form-group row">
            <label class="control-label col-md-2">Tên Danh Mục</label>
            <div class="col-md-10">
                <input type="text" name="TenDM" class="form-control" 
                    value="<?= htmlspecialchars($TenDM ?? '') ?>">
                <span class="text-danger"><?= $errors['TenDM'] ?? '' ?></span>
            </div>
        </div>       
        <!-- nút lưu -->
        <div class="col-md-offset-2 col-md-10">
            <input type="submit" value="LƯU" class="btn-luu">
        </div>
    </form>
    
    <h3>
        <a href="QL_DM.php" class="btn-th" style="font-style: italic;">Trở về</a>
    </h3>
</div>

<?php 
    $content = ob_get_clean();
    include 'Layout_AD.php'; 
?>
<link rel="stylesheet" href="AD_css.css">
<style>
    .btn-th, .btn-luu{
        width: 45% !important;
    }
</style>