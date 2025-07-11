<?php
ob_start();
include '../includes/youjia_connect.php';

$keyword = isset($_GET['query']) ? trim($_GET['query']) : '';
$keyword_safe = mysqli_real_escape_string($conn, $keyword);

$page = isset($_GET['trang']) ? (int)$_GET['trang'] : 1;
if ($page < 1) $page = 1;

$perPage = 5;
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
            ORDER BY s.MaSP
            LIMIT $offset, $perPage";
    $result = mysqli_query($conn, $sql);
}
?>
<style>
.form-inline.search-bar {
        display: flex;
        flex-wrap: nowrap;
        justify-content: flex-end;
        align-items: center;
        gap: 10px;
        margin-bottom: 20px;
    }

    .form-inline.search-bar input.form-control {
        width: 100%;
    }

    .form-inline.search-bar button {
        white-space: nowrap;
        width: 10%;
    }

    input.form-control {
        border: 0.5px solid rgba(255, 120, 23, 0.58) !important; /* viền cam */
        background-color: #fffbe6; /* nền vàng nhạt */
        padding: 8px 12px;
        border-radius: 6px;
        transition: 0.3s;
        color: rgb(255, 106, 0) !important; 
        font-weight: bold;
    }

    input.form-control::placeholder {
        color: rgb(255, 106, 0) !important; /* placeholder cam đậm */
    }

    input.form-control:focus {
        border-color: rgb(255, 106, 0) !important;
        box-shadow: 0 0 5px rgba(255, 186, 136, 0.77) !important;
        outline: rgb(255, 185, 136) !important;
    }
    .btn-tim, .btn-them {
        width: 15%;
    }

</style>
<div class='thongtin'>
    <h2 class="text-center"><B>QUẢN LÝ SẢN PHẨM</B></h2> <HR>
    <!-- Form tìm kiếm -->
    <form method="get" action="" class="form-inline search-bar">
        <input type="text" name="query" class="form-control" placeholder="Tìm mã SP hoặc tên SP..."
               value="<?= htmlspecialchars($keyword) ?>">
        <button type="submit" class="btn-luu btn-tim"><i class="fas fa-search"></i></button>|
        <a href="SP_them.php" class="btn-th btn-them">
            <i class="fas fa-plus"></i><b>&ensp;Thêm</b>
        </a>        
    </form>

    <div class="table-responsive">
    <table class="table table-striped table-bordered table-hover text-center align-middle">
        <thead class="table-light">
            <tr>
                <th style="width: 5%;">Mã SP</th>
                <th style="width: 5%;">Tên SP</th>
                <th style="width: 10%;">Ảnh Bìa</th>
                <th style="width: 10%;">Giá Bán</th>
                <th style="width: 10%;">Số Lượng</th>
                <th style="width: 10%;">Màu Sắc</th>
                <th style="width: 10%;">Nhóm</th>
                <th style="width: 10%;">Danh mục</th>
                <!-- <th style="width: 10%;">Bảo hành</th> -->
                <th style="width: 10%;">Hành động</th>
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
                                <img src="../images/<?= htmlspecialchars($row['AnhBia']) ?>" style="width: 150px; height: 200px; object-fit: cover;">
                            <?php else: ?>
                                <span class="text-muted">Không có ảnh</span>
                            <?php endif; ?>
                        </td>
                        <td><?= number_format($row['GiaBan'], 0, ',', '.') ?> đ</td>
                        <td><?= $row['SoLuong'] ?></td>
                        <td><?= htmlspecialchars($row['MauSac']) ?></td>
                        <td><?= htmlspecialchars($row['TenNDM']) ?></td>
                        <td><?= htmlspecialchars($row['TenDM']) ?></td>
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
<nav class="text-center mt-4">
    <ul class="pagination justify-content-center">
        <?php if ($page > 1): ?>
            <li class="page-item">
                <a class="page-link" href="?trang=<?= $page - 1 ?><?= $keyword ? '&query=' . urlencode($keyword) : '' ?>">&laquo;</a>
            </li>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <?php if ($i == $page): ?>
                <li class="page-item active"><span class="page-link"><?= $i ?></span></li>
            <?php else: ?>
                <li class="page-item">
                    <a class="page-link" href="?trang=<?= $i ?><?= $keyword ? '&query=' . urlencode($keyword) : '' ?>"><?= $i ?></a>
                </li>
            <?php endif; ?>
        <?php endfor; ?>

        <?php if ($page < $totalPages): ?>
            <li class="page-item">
                <a class="page-link" href="?trang=<?= $page + 1 ?><?= $keyword ? '&query=' . urlencode($keyword) : '' ?>">&raquo;</a>
            </li>
        <?php endif; ?>
    </ul>
</nav>
<?php endif; ?>
<?php
    $conn->close();
    $content = ob_get_clean();
    include 'Layout_AD.php';
?>