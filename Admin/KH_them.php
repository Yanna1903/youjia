<?php
ob_start();
include '../includes/youjia_connect.php';

$errors = [];
$MaKH = $TenKH = $Username = $MatKhau = $GioiTinh = $Email = $SDT = $DiaChi = $NgaySinh = $TrangThai = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $TenKH      = $_POST['TenKH']       ?? '';
    $Username   = $_POST['Username']    ?? '';
    $MatKhau    = $_POST['MatKhau']     ?? '';
    $GioiTinh   = $_POST['GioiTinh']    ?? '';
    $Email      = $_POST['Email']       ?? '';
    $SDT        = $_POST['SDT']         ?? '';
    $DiaChi     = $_POST['DiaChi']      ?? '';
    $NgaySinh   = $_POST['NgaySinh']    ?? '';
    $TrangThai  = $_POST['TrangThai']   ?? '';

    if (empty($TenKH))      $errors['TenKH'] = "Tên khách hàng không được để trống.";
    if (empty($Username))   $errors['Username'] = "Username không được để trống.";
    if (empty($MatKhau))    $errors['MatKhau'] = "Mật khẩu không được để trống.";
    if (empty($Email))      $errors['Email'] = "Email không được để trống.";
    if (empty($SDT))        $errors['SDT'] = "SĐT không được để trống.";
    if (empty($NgaySinh))   $errors['NgaySinh'] = "Ngày sinh không được để trống.";

    if (empty($errors)) {
        $sql = "INSERT INTO KhachHang (TenKH, Username, MatKhau, GioiTinh, Email, SDT, DiaChi, NgaySinh, TrangThai)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "sssssssss", $TenKH, $Username, $MatKhau, $GioiTinh, $Email, $SDT, $DiaChi, $NgaySinh, $TrangThai);
        $result = mysqli_stmt_execute($stmt);

        if ($result) {
            echo "<script>
                    alert('Thêm mới khách hàng thành công!');
                    window.location.href = 'QL_KH.php';
                  </script>";
            exit(); 
        } else {
            echo "<div class='alert alert-danger'>Thêm mới khách hàng thất bại! " . mysqli_error($conn) . "</div>";
        }
        mysqli_stmt_close($stmt);
    }
}
?>

<h2 class="text-center mt-4"><b>THÊM KHÁCH HÀNG</b></h2>
<hr style="width:50%;">

<div class="thongtin">
    <form method="post" class="form-container" style="background:#f9f9f9; border-radius:12px; padding:20px;">
        <div class="form-group">
            <label>Tên khách hàng</label>
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
            <input type="password" name="MatKhau" class="form-control" value="<?= htmlspecialchars($MatKhau ?? '') ?>">
            <span class="text-danger"><?= $errors['MatKhau'] ?? '' ?></span>
        </div>

        <div class="form-group">
            <label>Giới tính</label>
            <select name="GioiTinh" class="form-control">
                <option value="">-- Chọn --</option>
                <option value="Nam" <?= ($GioiTinh === 'Nam') ? 'selected' : '' ?>>Nam</option>
                <option value="Nữ" <?= ($GioiTinh === 'Nữ') ? 'selected' : '' ?>>Nữ</option>
            </select>
        </div>

        <div class="form-group">
            <label>Email</label>
            <input type="email" name="Email" class="form-control" value="<?= htmlspecialchars($Email ?? '') ?>">
            <span class="text-danger"><?= $errors['Email'] ?? '' ?></span>
        </div>

        <div class="form-group">
            <label>SĐT</label>
            <input type="text" name="SDT" class="form-control" value="<?= htmlspecialchars($SDT ?? '') ?>">
            <span class="text-danger"><?= $errors['SDT'] ?? '' ?></span>
        </div>

        <div class="form-group">
            <label>Địa chỉ</label>
            <input type="text" name="DiaChi" class="form-control" value="<?= htmlspecialchars($DiaChi ?? '') ?>">
        </div>

        <div class="form-group">
            <label>Ngày sinh</label>
            <input type="date" name="NgaySinh" class="form-control" value="<?= htmlspecialchars($NgaySinh ?? '') ?>">
            <span class="text-danger"><?= $errors['NgaySinh'] ?? '' ?></span>
        </div>

        <div class="form-group">
            <label>Trạng thái</label>
            <select name="TrangThai" class="form-control">
                <option value="1" <?= ($TrangThai == '1') ? 'selected' : '' ?>>Còn hoạt động</option>
                <option value="0" <?= ($TrangThai == '0') ? 'selected' : '' ?>>Đã khóa</option>
            </select>
        </div>

        <div class="button-group" style="margin-top: 20px;">
            <button type="submit" class="btn-luu"><b><i class="fas fa-save"></i> &ensp;LƯU</b></button>
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
        width: 48%;
    }
</style>
