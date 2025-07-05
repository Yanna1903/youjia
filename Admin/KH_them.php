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
        $sql = "INSERT INTO KhachHang ( TenKH, Username, MatKhau, GioiTinh, Email, SDT, DiaChi, NgaySinh, TrangThai)
                VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ?)";
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

<div class="container">
    <h2 class="text-center mt-4"><b>THÊM KHÁCH HÀNG</b></h2>
    <hr />
    <form method="post">

        <div class="form-group row">
            <label class="control-label col-md-2">Tên khách hàng</label>
            <div class="col-md-10">
                <input type="text" name="TenKH" class="form-control" value="<?= htmlspecialchars($TenKH ?? '') ?>">
                <span class="text-danger"><?= $errors['TenKH'] ?? '' ?></span>
            </div>
        </div>

        <div class="form-group row">
            <label class="control-label col-md-2">Username</label>
            <div class="col-md-10">
                <input type="text" name="Username" class="form-control" value="<?= htmlspecialchars($Username ?? '') ?>">
                <span class="text-danger"><?= $errors['Username'] ?? '' ?></span>
            </div>
        </div>

        <div class="form-group row">
            <label class="control-label col-md-2">Mật khẩu</label>
            <div class="col-md-10">
                <input type="password" name="MatKhau" class="form-control" value="<?= htmlspecialchars($MatKhau ?? '') ?>">
                <span class="text-danger"><?= $errors['MatKhau'] ?? '' ?></span>
            </div>
        </div>

        <div class="form-group row">
            <label class="control-label col-md-2">Giới tính</label>
            <div class="col-md-10">
                <select name="GioiTinh" class="form-control">
                    <option value="">-- Chọn --</option>
                    <option value="Nam" <?= ($GioiTinh === 'Nam') ? 'selected' : '' ?>>Nam</option>
                    <option value="Nữ" <?= ($GioiTinh === 'Nữ') ? 'selected' : '' ?>>Nữ</option>
                </select>
            </div>
        </div>

        <div class="form-group row">
            <label class="control-label col-md-2">Email</label>
            <div class="col-md-10">
                <input type="email" name="Email" class="form-control" value="<?= htmlspecialchars($Email ?? '') ?>">
                <span class="text-danger"><?= $errors['Email'] ?? '' ?></span>
            </div>
        </div>

        <div class="form-group row">
            <label class="control-label col-md-2">SĐT</label>
            <div class="col-md-10">
                <input type="text" name="SDT" class="form-control" value="<?= htmlspecialchars($SDT ?? '') ?>">
                <span class="text-danger"><?= $errors['SDT'] ?? '' ?></span>
            </div>
        </div>

        <div class="form-group row">
            <label class="control-label col-md-2">Địa chỉ</label>
            <div class="col-md-10">
                <input type="text" name="DiaChi" class="form-control" value="<?= htmlspecialchars($DiaChi ?? '') ?>">
            </div>
        </div>

        <div class="form-group row">
            <label class="control-label col-md-2">Ngày sinh</label>
            <div class="col-md-10">
                <input type="date" name="NgaySinh" class="form-control" value="<?= htmlspecialchars($NgaySinh ?? '') ?>">
                <span class="text-danger"><?= $errors['NgaySinh'] ?? '' ?></span>
            </div>
        </div>

        <!-- <div class="form-group row">
            <label class="control-label col-md-2">Trạng thái</label>
            <div class="col-md-10">
                <select name="TrangThai" class="form-control">
                    <option value="1" <?= ($TrangThai == '1') ? 'selected' : '' ?>>Còn hoạt động</option>
                    <option value="0" <?= ($TrangThai == '0') ? 'selected' : '' ?>>Đã khóa</option>
                </select>
            </div>
        </div> -->

        <div class="form-group row text-center">
            <div class="col-md-offset-2 col-md-10">
                <input type="submit" value="LƯU" class="btn btn-th" style='font-size: 16px;'>
            </div>
        </div>
    </form>

    <h2>
        <a href="QL_SanPham.php" style='color: rgb(237, 79, 134); font-style: italic;'>Trở về</a>
    </h2>
</div>

<?php
$content = ob_get_clean();
include 'Layout_AD.php';
?>
<style>
    body {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        text-decoration: none;
        list-style: none;
    }

    label {
        align: left !important;
    }
    hr {
        border: 0;
        height: 5px !important;
        background-color: rgba(0, 95, 116, 0.44);
        margin-top: 20px;
        margin-bottom: 20px;
        width: 80%;
    }

    table {
        border-collapse: collapse;
        width: auto;
        margin: 20px auto;
        background-color: rgb(255, 212, 231);
        padding: 50px 100px;
        border-radius: 15px;
        box-shadow: 4px 4px rgba(0, 95, 116, 0.44);
        border: 2px solid rgb(0, 95, 116);
        line-height: 1.8;
    }

    h2 {
        font-size: 30px !important;
        color: rgb(0, 94, 116) !important;
    }

    label {
        color: rgb(0, 94, 116) !important;
        font-size: 18px !important;
        line-height: 1.8;
    }

    .btn-luu {
        color: #fff;
        padding: 6px 10px;
        font-size: 12px;
        font-weight: bold;
        border: 2px solid transparent;
        cursor: pointer;
        text-transform: uppercase;
        background-color:rgb(0, 123, 150) !important;
        margin: 0px;
        width:100%;
    }

    .btn-luu:hover {
        background-color:rgb(0, 94, 116) !important;
        color: #fff !important;
    }

    /* Style chung cho input, select */
    input[type="text"],
    input[type="number"],
    input[type="password"],
    input[type="email"],
    input[type="date"],
    select,
    textarea {
        width: 100%;
        height: 40px;
        padding: 8px;
        border: 1px solid rgba(0, 95, 116, 0.4) !important;
        border-radius: 10px;
        outline: none;
        background-color: #fff;
        transition: border-color 0.3s, box-shadow 0.3s;
        font-size: 16px;
        line-height: 1.5;
    }

    input[type="text"]:focus,
    input[type="number"]:focus,
    select:focus,
    textarea:focus {
        border-color: rgb(0, 94, 116) !important;
        box-shadow: 0 0 5px rgba(0, 94, 116, 0.5) !important;
        outline: none;
    }

    input[type="submit"] {
        width: 100%;
        height: 40px;
        padding: 8px 8px;
        background-color:rgb(0, 123, 150) !important;
        color: white;
        font-weight: bold;
        font-size: 20px;
        border-radius: 8px;
        cursor: pointer;
        transition: background-color 0.3s;
        text-align: center;
    }

    input[type="submit"]:hover {
        background-color:rgb(0, 94, 116) !important;
        color: #fff !important;
    }
</style>