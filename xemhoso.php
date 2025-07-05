<?php
session_start();
ob_start();
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
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông tin</title>
    <style>
/* === TRANG HỒ SƠ NGƯỜI DÙNG === */
.container-ahihi {
    background: #fff;
    padding: 30px;
    border-radius: 20px;
    border: 1px solid rgba(49, 111, 125, 0.35);
    box-shadow: 4px 8px rgba(0, 0, 0, 0.05);
    max-width: 800px; /* Điều chỉnh độ rộng tối đa */
    width: 90%;
    margin: 40px auto; /* Căn giữa trang */
    font-family: 'Segoe UI', Tahoma, Verdana, sans-serif;
}

h2 {
    color: rgb(49, 111, 125) !important;
    font-size: 30PX;
    text-align: center;
    font-weight: bold !important;
}

table {
    width: 100%;
    border-collapse: collapse !important;
    /* margin-bottom: 20px; */
}

.table td {
    padding: 12px 10px;
    border-bottom: 2px solid rgba(49, 111, 125, 0.2) !important;
    text-align: left;
    font-size: 1.1em;
}

.table td:first-child {
    font-weight: bold;
    color: rgb(49, 111, 125);
    width: 150px; /* Điều chỉnh độ rộng cột tiêu đề */
}

.table tr:last-child td {
    border-bottom: none;
}

hr {
    border: 0;
    height: 3px !important;
    background-color:rgba(60, 133, 149, 0.31); 
    margin: 20px 10px; 
}

    </style>
</head>
<body>

<div class="container-ahihi">
    <h2>THÔNG TIN CÁ NHÂN</h2>
    <hr>
    <div class="panel panel-default">
        <table class="table table-bordered">
            <tr>
                <td><strong>Tên:</strong></td>
                <td><?= htmlspecialchars($user['TenKH']) ?></td>
            </tr>
            <tr>
                <td><strong>Email:</strong></td>
                <td><?= htmlspecialchars($user['Email']) ?></td>
            </tr>
            <tr>
                <td><strong>Số Điện Thoại:</strong></td>
                <td><?= htmlspecialchars($user['SDT']) ?></td>
            </tr>
            <tr>
                <td><strong>Địa Chỉ:</strong></td>
                <td><?= htmlspecialchars($user['DiaChi']) ?></td>
            </tr>
            <tr>
                <td><strong>Ngày Sinh:</strong></td>
                <td><?= htmlspecialchars($user['NgaySinh']) ?></td>
            </tr>
            
        </table>
    </div>
    <a href="capnhat_hoso.php" class="btn btn-success"><b>CẬP NHẬT</b></a>

</div>

<?php
$content = ob_get_clean();
include 'includes/youjia_layout.php';
?>
</body>
</html>