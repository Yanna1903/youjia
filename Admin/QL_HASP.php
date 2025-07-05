<?php
ob_start();
include '../includes/youjia_connect.php';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản Lý Sản Phẩm - Xem Hình Ảnh</title>
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        h2 { font-size: 30px; color: rgb(0,94,116); margin-bottom: 30px; text-align: center; }
        .btn-th { background: rgb(0,123,150); color: #fff; padding: 6px 12px; font-size: 12px; text-transform: uppercase; }
        .btn-th:hover { background: rgb(0,94,116); color: #fff; }
        table { width: 100%; border-collapse: collapse; color: rgb(0,94,116);}
        table th, table td { border:1px solid rgba(36,143,168,0.64); padding:10px; text-align:center; }
        table thead { background: rgb(0,94,116); color: #fff; }
        tr:hover { background: rgba(190,243,255,0.35); }
    </style>
</head>
<body>
<div class="container">
    <h2>QUẢN LÝ SẢN PHẨM - XEM HÌNH ẢNH</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Mã SP</th>
                <th>Tên SP</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $sql = "SELECT DISTINCT SanPham.MaSP, SanPham.TenSP
                FROM HinhAnh
                JOIN SanPham ON HinhAnh.MaSP = SanPham.MaSP";
        $result = $conn->query($sql);
        if ($result->num_rows > 0):
            while ($row = $result->fetch_assoc()):
        ?>
            <tr>
                <td><?= htmlspecialchars($row['MaSP']) ?></td>
                <td><?= htmlspecialchars($row['TenSP']) ?></td>
                <td>
                    <a href="HASP_xem.php?MaSP=<?= urlencode($row['MaSP']) ?>" class="btn btn-th btn-sm" title="Xem hình ảnh">
                        <i class="fas fa-images"></i>
                    </a>
                    <a href="HASP_sua.php?MaSP=<?= urlencode($row['MaSP']) ?>" class="btn btn-th btn-sm" title="Sửa thông tin">
                        <i class="fas fa-edit"></i>
                    </a>
                    <a href="HASP_xoa.php?MaSP=<?= urlencode($row['MaSP']) ?>" class="btn btn-th btn-sm" title="Xóa" 
                    onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này và tất cả hình ảnh?')">
                        <i class="fas fa-trash-alt"></i>
                    </a>
                </td>
            </tr>
        <?php endwhile;
        else: ?>
            <tr><td colspan="3" class="text-center text-muted">Không có sản phẩm nào có hình ảnh.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>

</body>
</html>
<?php 
$conn->close(); 
$content = ob_get_clean();
include 'Layout_AD.php';
?>

