<?php
ob_start();
include '../includes/youjia_connect.php';

// Xử lý tìm kiếm
$keyword = isset($_GET['query']) ? trim($_GET['query']) : '';
$keyword_safe = mysqli_real_escape_string($conn, $keyword);

// Phân trang
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;
$size = 5;
$offset = ($page - 1) * $size;

// Query tùy theo có từ khóa hay không
if ($keyword !== '') {
    $where = "WHERE (SanPham.MaSP LIKE '%$keyword_safe%' OR SanPham.TenSP LIKE '%$keyword_safe%')";
} else {
    $where = "";
}

// Đếm tổng để phân trang
$sql_total = "SELECT COUNT(DISTINCT SanPham.MaSP) AS total
              FROM HinhAnh
              JOIN SanPham ON HinhAnh.MaSP = SanPham.MaSP
              $where";
$result_total = mysqli_query($conn, $sql_total);
$row_total = mysqli_fetch_assoc($result_total);
$total_products = $row_total['total'];
$total_pages = ceil($total_products / $size);

// Lấy danh sách sản phẩm có hình ảnh
$sql = "SELECT DISTINCT SanPham.MaSP, SanPham.TenSP, SanPham.AnhBia
        FROM HinhAnh
        JOIN SanPham ON HinhAnh.MaSP = SanPham.MaSP
        $where
        LIMIT $offset, $size";
$result = $conn->query($sql);
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
    .btn-tim {
        width: 30%;
    }

</style>

<div class="thongtin">
    <h2><b>QUẢN LÝ HÌNH ẢNH SẢN PHẨM</b></h2>
    <hr style="width:50%;">
    <!-- Form tìm kiếm -->
    <form method="get" action="" class="form-inline search-bar">
        <input type="text" name="query" class="form-control" placeholder="Tìm mã SP hoặc tên SP..."
               value="<?= htmlspecialchars($keyword) ?>">
        <button type="submit" class="btn-luu btn-tim"><i class="fas fa-search"></i></button>
    </form>

    <table class="table table-bordered table-hover align-middle text-center">
        <thead class="table-light">
            <tr>
                <th>Mã SP</th>
                <th>Tên SP</th>
                <th>Ảnh Bìa</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
        <?php if ($result && $result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($row['MaSP']) ?></td>
                <td><?= htmlspecialchars($row['TenSP']) ?></td>
                <td>
                    <?php if (!empty($row['AnhBia'])): ?>
                        <img src="../images/<?= htmlspecialchars($row['AnhBia']) ?>" 
                             style="width:120px; height:150px; border-radius:8px; object-fit:cover;">
                    <?php else: ?>
                        <small>Chưa có ảnh bìa</small>
                    <?php endif; ?>
                </td>
                <td>
                    <a href="HASP_sua.php?MaSP=<?= urlencode($row['MaSP']) ?>" 
                       class="btn-th" title="Sửa hình ảnh">
                        <i class="fas fa-edit"></i>
                    </a>
                </td>
            </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="4" class="text-center text-muted">Không có sản phẩm nào có hình ảnh.</td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>

    <!-- Pagination -->
    <?php if ($total_pages > 1): ?>
    <nav class="text-center mt-4">
        <ul class="pagination justify-content-center">
            <?php if ($page > 1): ?>
                <li class="page-item">
                    <a class="page-link" href="?page=<?= $page - 1 ?><?= $keyword ? '&query=' . urlencode($keyword) : '' ?>">&laquo;</a>
                </li>
            <?php endif; ?>
            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <?php if ($i == $page): ?>
                    <li class="page-item active"><span class="page-link"><?= $i ?></span></li>
                <?php else: ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?= $i ?><?= $keyword ? '&query=' . urlencode($keyword) : '' ?>"><?= $i ?></a>
                    </li>
                <?php endif; ?>
            <?php endfor; ?>
            <?php if ($page < $total_pages): ?>
                <li class="page-item">
                    <a class="page-link" href="?page=<?= $page + 1 ?><?= $keyword ? '&query=' . urlencode($keyword) : '' ?>">&raquo;</a>
                </li>
            <?php endif; ?>
        </ul>
    </nav>
    <?php endif; ?>
</div>

<?php
$conn->close();
$content = ob_get_clean();
include 'Layout_AD.php';
?>
