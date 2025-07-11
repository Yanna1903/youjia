<?php
ob_start();
include '../includes/youjia_connect.php';

$keyword = isset($_GET['query']) ? trim($_GET['query']) : '';
$keyword_safe = mysqli_real_escape_string($conn, $keyword);

$page = isset($_GET['trang']) ? (int)$_GET['trang'] : 1;
if ($page < 1) $page = 1;

$perPage = 10;
$offset = ($page - 1) * $perPage;

if ($keyword !== '') {
    // Tìm kiếm sản phẩm
    $sql_count = "SELECT COUNT(*) AS total FROM SanPham WHERE MaSP LIKE '%$keyword_safe%' OR TenSP LIKE '%$keyword_safe%'";
    $total_result = mysqli_query($conn, $sql_count);
    $total_row = mysqli_fetch_assoc($total_result);
    $total = $total_row['total'];
    $totalPages = ceil($total / $perPage);

    $sql = "SELECT s.MaSP, s.TenSP, s.AnhBia, s.MoTa, s.BaoHanh, s.MauSac, s.GiaBan, s.SoLuong, dm.TenDM, ndm.TenNDM, s.TrangThai
            FROM sanpham s 
            JOIN DanhMuc dm ON s.MaDM = dm.MaDM
            JOIN NhomDanhMuc ndm ON s.MaNDM = ndm.MaNDM
            WHERE s.MaSP LIKE '%$keyword_safe%' OR s.TenSP LIKE '%$keyword_safe%'
            ORDER BY TenSP
            LIMIT $offset, $perPage";
    $result = mysqli_query($conn, $sql);

    echo '<h2 class="text-center">KẾT QUẢ TÌM KIẾM: <span class="text-danger">' . htmlspecialchars($keyword) . '</span></h2>';
} else {
    // Hiển thị toàn bộ sản phẩm
    $sql_count = "SELECT COUNT(*) AS total FROM SanPham";
    $total_result = mysqli_query($conn, $sql_count);
    $total_row = mysqli_fetch_assoc($total_result);
    $total = $total_row['total'];
    $totalPages = ceil($total / $perPage);

    $sql = "SELECT s.MaSP, s.TenSP, s.AnhBia, s.MoTa, s.BaoHanh, s.MauSac, s.GiaBan, s.SoLuong, dm.TenDM, ndm.TenNDM, s.TrangThai
            FROM sanpham s 
            JOIN DanhMuc dm ON s.MaDM = dm.MaDM
            JOIN NhomDanhMuc ndm ON s.MaNDM = ndm.MaNDM
            ORDER BY TenSP
            LIMIT $offset, $perPage";
    $result = mysqli_query($conn, $sql);
}
?>
<div class='thongtin'>
<h2 class="text-center"><B>QUẢN LÝ SẢN PHẨM</B></h2> <HR>
<form class="search-form" action="timkiem-sp.php" method="GET">
        <div class="input-group">
          <input type="text" name="query" class="form-control input-lg" placeholder="Tìm sản phẩm..." required>
          <span class="input-group-btn">
            <button class="btn btn-lg btn-info" type="submit"><span class="glyphicon glyphicon-search"></span></button>
          </span>
        </div>
      </form>

<table class="table table-bordered text-center mt-4">
    <thead class="table-success">
        <tr>
            <th>Mã SP</th>
            <th>Tên SP</th>
            <th>Ảnh Bìa</th>
            <th>Giá Bán</th>
            <th>Số Lượng</th>
            <th>Màu Sắc</th>
            <th>Nhóm</th>
            <th>Danh mục</th>
            <th>Bảo hành</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        <?php if (mysqli_num_rows($result) > 0): ?>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?= htmlspecialchars($row['MaSP']) ?></td>
                    <td><?= htmlspecialchars($row['TenSP']) ?></td>
                    <td>
                        <?php if (!empty($row['AnhBia'])): ?>
                            <img src="../images/<?= htmlspecialchars($row['AnhBia']) ?>" style="width:80px; height:100px;">
                        <?php else: ?>
                            <small>Không có ảnh</small>
                        <?php endif; ?>
                    </td>
                    <td><?= number_format($row['GiaBan'], 0, ',', '.') ?> đ</td>
                    <td><?= $row['SoLuong'] ?></td>
                    <td><?= htmlspecialchars($row['MauSac']) ?></td>
                    <td><?= htmlspecialchars($row['TenNDM']) ?></td>
                    <td><?= htmlspecialchars($row['TenDM']) ?></td>
                    <td><?= htmlspecialchars($row['BaoHanh']) ?> ngày</td>
                    <td>
                        <a href="HASP_xem.php?MaSP=<?= urlencode($row['MaSP']) ?>" class="btn-th" title="Xem hình ảnh"><i class="fas fa-images"></i></a>
                        <a href="SP_sua.php?MaSP=<?= urlencode($row['MaSP']) ?>" class="btn-th" title="Sửa thông tin"><i class="fas fa-edit"></i></a>
                        <a href="SP_xoa.php?MaSP=<?= urlencode($row['MaSP']) ?>" class="btn-th" title="Xóa"
                           onclick="return confirm('❓Bạn có chắc chắn muốn xóa sản phẩm này và tất cả hình ảnh?')">
                            <i class="fas fa-trash-alt"></i>
                        </a>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="10" class="text-muted">Không tìm thấy sản phẩm nào phù hợp.</td></tr>
        <?php endif; ?>
    </tbody>
</table>
</div>
<!-- PHÂN TRANG -->
<?php if ($totalPages > 1): ?>
<nav class="text-center">
    <ul class="pagination justify-content-center">
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                <a class="page-link" href="?query=<?= urlencode($keyword) ?>&trang=<?= $i ?>"><?= $i ?></a>
            </li>
        <?php endfor; ?>
    </ul>
</nav>
<?php endif; ?>
<?php
    $conn->close();
    $content = ob_get_clean();
    include 'Layout_AD.php';
?>