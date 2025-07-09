<?php
ob_start();
include '../includes/youjia_connect.php';

if (isset($_GET['id'])) {
    $MaKH = $_GET['id'];
    $errors = [];

    $sql = "SELECT * FROM khachhang WHERE MaKH = '$MaKH'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $TenKH      = $row['TenKH'];
        $Username   = $row['Username'];
        $MatKhau    = $row['MatKhau'];
        $GioiTinh   = $row['GioiTinh'];
        $Email      = $row['Email'];
        $DiaChi     = $row['DiaChi'];
        $SDT        = $row['SDT'];
        $NgaySinh   = $row['NgaySinh'];
        $TrangThai  = $row['TrangThai'];
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $TenKH      = $_POST['TenKH'] ?? '';
        $Username   = $_POST['Username'] ?? '';
        $MatKhau    = $_POST['MatKhau'] ?? '';
        $GioiTinh   = $_POST['GioiTinh'] ?? '';
        $Email      = $_POST['Email'] ?? '';
        $DiaChi     = $_POST['DiaChi'] ?? '';
        $SDT        = $_POST['SDT'] ?? '';
        $NgaySinh   = $_POST['NgaySinh'] ?? '';
        $TrangThai  = $_POST['TrangThai'] ?? '';

        if (empty($errors)) {
            $sql_update = "UPDATE khachhang 
                SET TenKH='$TenKH', Username='$Username', MatKhau='$MatKhau', 
                    GioiTinh='$GioiTinh', Email='$Email', DiaChi='$DiaChi', 
                    SDT='$SDT', NgaySinh='$NgaySinh', TrangThai='$TrangThai'
                WHERE MaKH='$MaKH'";
            
            $result_update = mysqli_query($conn, $sql_update);

            if ($result_update) {
                echo "<script>
                        alert('Cập nhật thành công!');
                        window.location.href = 'QL_KH.php';
                      </script>";
            } else {
                echo "<script>alert('Cập nhật thất bại!');</script>";
            }
        }
    }
}
?>

<h2 style='color:rgb(212, 139, 3)'><b>SỬA THÔNG TIN KHÁCH HÀNG</b></h2>
<hr style="width:50%;">

<div class="thongtin">
    <form method="POST" class="form-container">
        <div class="form-group">
            <label>Họ Tên</label>
            <input type="text" name="TenKH" class="form-control" value="<?= htmlspecialchars($TenKH ?? '') ?>">
            <span class="text-danger"><?= $errors['TenKH'] ?? '' ?></span>
        </div>

        <div class="form-group">
            <label>Username</label>
            <input type="text" name="Username" class="form-control" value="<?= htmlspecialchars($Username ?? '') ?>">
            <span class="text-danger"><?= $errors['Username'] ?? '' ?></span>
        </div>

        <div class="form-group">
            <label>Mật khẩu</label>
            <input type="text" name="MatKhau" class="form-control" value="<?= htmlspecialchars($MatKhau ?? '') ?>">
            <span class="text-danger"><?= $errors['MatKhau'] ?? '' ?></span>
        </div>

        <div class="form-group">
            <label>Giới tính</label>
            <select name="GioiTinh" class="form-control">
                <option value="0" <?= ($GioiTinh == 0) ? 'selected' : '' ?>>Nam</option>
                <option value="1" <?= ($GioiTinh == 1) ? 'selected' : '' ?>>Nữ</option>
            </select>
            <span class="text-danger"><?= $errors['GioiTinh'] ?? '' ?></span>
        </div>

        <div class="form-group">
            <label>Email</label>
            <input type="email" name="Email" class="form-control" value="<?= htmlspecialchars($Email ?? '') ?>">
        </div>

        <div class="form-group">
            <label>Địa chỉ</label>
            <input type="text" name="DiaChi" class="form-control" value="<?= htmlspecialchars($DiaChi ?? '') ?>">
        </div>

        <div class="form-group">
            <label>Điện thoại</label>
            <input type="text" name="SDT" class="form-control" value="<?= htmlspecialchars($SDT ?? '') ?>">
        </div>

        <div class="form-group">
            <label>Ngày Sinh</label>
            <input type="date" name="NgaySinh" class="form-control" value="<?= htmlspecialchars($NgaySinh ?? '') ?>">
        </div>

        <div class="form-group">
            <label>Trạng Thái</label>
            <select name="TrangThai" class="form-control">
                <option value="0" <?= ($TrangThai == 0) ? 'selected' : '' ?>>Bị khóa / Không còn</option>
                <option value="1" <?= ($TrangThai == 1) ? 'selected' : '' ?>>Tồn tại</option>
            </select>
        </div>

        <div class="button-group">
            <button type="submit" class="btn-luu"><b><i class="fas fa-save"></i> &ensp;LƯU THAY ĐỔI</b></button>
            <a href="QL_KH.php" class="btn-th"><b><i class="fas fa-arrow-left"></i> &ensp;TRỞ VỀ</b></a>
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
