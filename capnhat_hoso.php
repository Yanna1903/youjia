<?php
session_start();
include 'includes/youjia_connect.php';

// Kiểm tra nếu người dùng chưa đăng nhập thì chuyển hướng về trang đăng nhập
if (!isset($_SESSION['username'])) {
    header("Location: DKDN.php");
    exit;
}

// Lấy thông tin người dùng từ cơ sở dữ liệu
$username = $_SESSION['username'];
$sql_user = "SELECT * FROM khachhang WHERE username = '$username'";
$res_user = mysqli_query($conn, $sql_user);

if (mysqli_num_rows($res_user) > 0) {
    $user = mysqli_fetch_assoc($res_user);
} else {
    echo "Không tìm thấy thông tin người dùng.";
    exit;
}

// Xử lý form khi người dùng cập nhật thông tin
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Lấy thông tin người dùng từ form
    $tenkh = mysqli_real_escape_string($conn, $_POST['tenkh']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $sdt = mysqli_real_escape_string($conn, $_POST['sdt']);
    $diachi = mysqli_real_escape_string($conn, $_POST['diachi']);
    $ngaysinh = mysqli_real_escape_string($conn, $_POST['ngaysinh']);
    $matkhau = mysqli_real_escape_string($conn, $_POST['matkhau']);
    
    // Cập nhật mật khẩu nếu người dùng nhập mật khẩu mới
    if (!empty($matkhau)) {
        $matkhau = password_hash($matkhau, PASSWORD_DEFAULT); // Mã hóa mật khẩu mới
        $sql_update = "UPDATE khachhang SET TenKH = '$tenkh', Email = '$email', SDT = '$sdt', DiaChi = '$diachi', NgaySinh = '$ngaysinh', MatKhau = '$matkhau' WHERE username = '$username'";
    } else {
        // Nếu không nhập mật khẩu mới, không thay đổi mật khẩu
        $sql_update = "UPDATE khachhang SET TenKH = '$tenkh', Email = '$email', SDT = '$sdt', DiaChi = '$diachi', NgaySinh = '$ngaysinh' WHERE username = '$username'";
    }

    // Thực thi câu lệnh cập nhật
    if (mysqli_query($conn, $sql_update)) {
        echo "<script>alert('Cập nhật thông tin thành công!'); window.location.href='xemhoso.php';</script>";
    } else {
        echo "Lỗi: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CẬP NHẬT THÔNG TIN NGUÒI DÙNG</title>
    <style>
        
        /* color: rgb(40, 85, 96); */
    .form-group {
        display: flex;
        align-items: center;
        margin-bottom: 15px;
    }

    .form-group label {
        width: 150px;
        margin-bottom: 0;
        font-weight: bold;
    }

    .form-group .form-control {
        flex: 1;
    }
    hr {
      margin: 0 auto; 
      width: 90%;
      height: 5px !important;
    }
    
</style>

</head>
<body>

<div class="container" style='color: rgb(40, 85, 96);'>
    <h2 class="text-center main-title"><strong>CẬP NHẬT THÔNG TIN</strong></h2>
    <hr>
    <div class="panel panel-default">
        <!-- <div class="panel-heading">Thông Tin Cá Nhân</div> -->
        <div class="panel-body">
            <form action="capnhat_hoso.php" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="tenkh">Tên người dùng:</label>
                    <input type="text" class="form-control" id="tenkh" name="tenkh" value="<?= htmlspecialchars($user['TenKH']) ?>" required>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($user['Email']) ?>" required>
                </div>
                <div class="form-group">
                    <label for="sdt">Số điện thoại:</label>
                    <input type="text" class="form-control" id="sdt" name="sdt" value="<?= htmlspecialchars($user['SDT']) ?>" required>
                </div>
                <div class="form-group">
                    <label for="diachi">Địa chỉ:</label>
                    <input type="text" class="form-control" id="diachi" name="diachi" value="<?= htmlspecialchars($user['DiaChi']) ?>" required>
                </div>
                <div class="form-group">
                    <label for="ngaysinh">Ngày sinh:</label>
                    <input type="date" class="form-control" id="ngaysinh" name="ngaysinh" value="<?= htmlspecialchars($user['NgaySinh']) ?>" required>
                </div>
                <div class="form-group">
                    <label for="matkhau">Mật khẩu:</label>
                    <input type="password" class="form-control" id="matkhau" name="matkhau" placeholder="Nhập mật khẩu mới (nếu muốn thay đổi)">
                </div>
                <button type="submit" class="btn btn-success"><B>CẬP NHẬT THÔNG TIN</B></button>
            </form>
        </div>
    </div>
</div>

<!-- Footer -->
<?php 
$content = ob_get_clean();
include 'includes/youjia_layout.php'; 
?>
</body>
</html>
