<?php
include '../includes/youjia_connect.php';

// Lấy MaSP
$MaSP = isset($_GET['MaSP']) ? $_GET['MaSP'] : '';
if (empty($MaSP)) {
    echo "Không tìm thấy sản phẩm.";
    exit;
}

// Lấy tên sản phẩm
$sql_name = "SELECT TenSP FROM SanPham WHERE MaSP = ?";
$stmt_name = $conn->prepare($sql_name);
$stmt_name->bind_param("s", $MaSP);
$stmt_name->execute();
$result_name = $stmt_name->get_result();
$row_name = $result_name->fetch_assoc();
$TenSP = $row_name ? $row_name['TenSP'] : 'Không xác định';

// Lấy danh sách hình ảnh
$sql_img = "SELECT AnhSP FROM HinhAnh WHERE MaSP = ?";
$stmt_img = $conn->prepare($sql_img);
$stmt_img->bind_param("s", $MaSP);
$stmt_img->execute();
$result_img = $stmt_img->get_result();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Hình Ảnh - <?= htmlspecialchars($TenSP) ?></title>
    <link rel="stylesheet" href="AD_css.css">
    <style>
        h3 { text-align:center; color:rgb(0,94,116); margin:20px 0; }
        .img-gallery { display:flex; flex-wrap:wrap; justify-content:center; gap:20px; }
        .img-gallery img { width:200px; height:200px; object-fit:cover; border-radius:10px; box-shadow:0 2px 6px rgba(0,0,0,0.15); transition:0.3s; }
        .img-gallery img:hover { transform:scale(1.05); }
        .back-btn { display:block; margin:20px auto; width:max-content; padding:8px 16px; background:rgb(0,123,150); color:white; text-decoration:none; border-radius:5px; }
        .back-btn:hover { background:rgb(0,94,116); }
    </style>
</head>
<body>
    <div class="container">
        <a href="QL_SP.php" class="back-btn">&laquo; Quay lại danh sách sản phẩm</a>
        <h3>Hình ảnh của: <?= htmlspecialchars($TenSP) ?> (<?= htmlspecialchars($MaSP) ?>)</h3>
        <div class="img-gallery">
            <?php if($result_img->num_rows > 0): 
                while($row_img = $result_img->fetch_assoc()): ?>
                    <img src="../images/<?= htmlspecialchars($row_img['AnhSP']) ?>" alt="Ảnh SP">
            <?php endwhile; else: ?>
                <p>Không có hình ảnh cho sản phẩm này.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
<?php
$conn->close();
?>
