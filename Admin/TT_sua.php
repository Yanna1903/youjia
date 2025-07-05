<?php
ob_start();
include '../includes/youjia_connect.php';

// Xử lý khi bấm nút Lưu
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $MST = $_POST['MST'] ?? '';
    $DaiDien_PL = $_POST['DaiDien_PL'] ?? '';
    $DiaChi_CN = $_POST['DiaChi_CN'] ?? '';
    $Email = $_POST['Email'] ?? '';
    $Hotline = $_POST['Hotline'] ?? '';
    $MoTa = $_POST['MoTa'] ?? '';
    $SuMenh = $_POST['SuMenh'] ?? '';
    $TamNhin = $_POST['TamNhin'] ?? '';
    $GiaTriCotLoi = $_POST['GiaTriCotLoi'] ?? '';
    $GioHoatDong = $_POST['GioHoatDong'] ?? '';
    $Slogan = $_POST['Slogan'] ?? '';

    $sql = "UPDATE thongtin SET
        MST = ?,
        DaiDien_PL = ?,
        DiaChi_CN = ?,
        Email = ?,
        Hotline = ?,
        MoTa = ?,
        SuMenh = ?,
        TamNhin = ?,
        GiaTriCotLoi = ?,
        GioHoatDong = ?,
        Slogan = ?
        WHERE MaTT = 1";

    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("sssssssssss",
            $MST, $DaiDien_PL, $DiaChi_CN, $Email, $Hotline,
            $MoTa, $SuMenh, $TamNhin, $GiaTriCotLoi, $GioHoatDong, $Slogan
        );

        if ($stmt->execute()) {
            echo "<script>
                    alert('Cập nhật thành công!');
                    window.location.href = 'QL_TT.php';
                </script>";
        } else {
            echo "<script>alert('Lỗi khi cập nhật dữ liệu!');</script>";
        }

        $stmt->close();
    } else {
        echo "<script>alert('Lỗi truy vấn: " . $conn->error . "');</script>";
    }
}

// Lấy dữ liệu hiện tại
$sql = "SELECT * FROM thongtin WHERE MaTT = 1";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Cập Nhật Thông Tin</title>
    <link rel="stylesheet" href="AD_css.css">
<!-- <STYLE>
    .btn-th{
        width: 80%;
        text-align: center;
    }
</style> -->
</head>
<body>
<div class="thongtin">
    <h2 class="text-center mb-4"><b>CẬP NHẬT THÔNG TIN</b></h2> <br> <hr>
    <form method="post">
        <table>
            <thead>
                <tr>
                    <th style="width: 20%; font-size: 18px; text-align: center;">THÔNG TIN</th>
                    <th style="width: 80%; font-size: 18px;">NỘI DUNG CHI TIẾT</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Mã số thuế</td>
                    <td><input type="text" name="MST" value="<?= htmlspecialchars($row['MST'] ?? '') ?>"></td>
                </tr>
                <tr>
                    <td>Đại diện pháp luật</td>
                    <td><input type="text" name="DaiDien_PL" value="<?= htmlspecialchars($row['DaiDien_PL'] ?? '') ?>"></td>
                </tr>
                <tr><td>Địa chỉ chi nhánh</td><td><textarea name="DiaChi_CN"><?= htmlspecialchars($row['DiaChi_CN'] ?? '') ?></textarea></td></tr>
                <tr><td>Email</td><td><input type="text" name="Email" value="<?= htmlspecialchars($row['Email'] ?? '') ?>"></td></tr>
                <tr><td>Hotline</td><td><input type="text" name="Hotline" value="<?= htmlspecialchars($row['Hotline'] ?? '') ?>"></td></tr>
                <tr><td>Mô tả</td><td><textarea name="MoTa"><?= htmlspecialchars($row['MoTa'] ?? '') ?></textarea></td></tr>
                <tr><td>Sứ mệnh</td><td><textarea name="SuMenh"><?= htmlspecialchars($row['SuMenh'] ?? '') ?></textarea></td></tr>
                <tr><td>Tầm nhìn</td><td><textarea name="TamNhin"><?= htmlspecialchars($row['TamNhin'] ?? '') ?></textarea></td></tr>
                <tr><td>Giá trị cốt lõi</td><td><textarea name="GiaTriCotLoi"><?= htmlspecialchars($row['GiaTriCotLoi'] ?? '') ?></textarea></td></tr>
                <tr><td>Giờ hoạt động</td><td><input type="text" name="GioHoatDong" value="<?= htmlspecialchars($row['GioHoatDong'] ?? '') ?>"></td></tr>
                <tr><td>Slogan</td><td><textarea name="Slogan"><?= htmlspecialchars($row['Slogan'] ?? '') ?></textarea></td></tr>
            </tbody>
        </table>
    </form>
    <br>
    <div class="text-center mt-3" style="text-align:center;">
        <button type="submit" class="btn-luu"><b>LƯU</b></button>
    </div>
</div>
</body>
</html>
<?php
$conn->close();
$content = ob_get_clean();
include 'Layout_AD.php';
?>
<STYLE>
    textarea {
    width: 100%;
    height: 80px !important; 
    padding: 8px;
    border: 1px solid rgba(0, 95, 116, 0.4) !important;
    border-radius: 10px;
    outline: none;
    background-color: #fff !important;
    transition: border-color 0.3s, box-shadow 0.3s;
    font-size: 16px !important;
    line-height: 1.5;
    resize: vertical; 
}

</style>