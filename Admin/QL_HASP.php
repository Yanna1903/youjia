<?php
ob_start();
include '../includes/youjia_connect.php';

// Phân trang
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$size = 5;
$offset = ($page - 1) * $size;

// Query SP có hình ảnh
$sql = "SELECT DISTINCT SanPham.MaSP, SanPham.TenSP, SanPham.AnhBia
        FROM HinhAnh
        JOIN SanPham ON HinhAnh.MaSP = SanPham.MaSP
        LIMIT $offset, $size";
$result = $conn->query($sql);

// Đếm tổng để phân trang
$sql_total = "SELECT COUNT(DISTINCT SanPham.MaSP) AS total
              FROM HinhAnh
              JOIN SanPham ON HinhAnh.MaSP = SanPham.MaSP";
$result_total = mysqli_query($conn, $sql_total);
$row_total = mysqli_fetch_assoc($result_total);
$total_products = $row_total['total'];
$total_pages = ceil($total_products / $size);
?>
<div class="container">
    <h2 class="text-center mt-4"><b>QUẢN LÝ HÌNH ẢNH SẢN PHẨM</b></h2>
    <hr style="width:50%;">

    <table class="table table-bordered mt-4">
        <thead>
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
                        <img src="../Images/<?= htmlspecialchars($row['AnhBia']) ?>" style="width:120px; height:150px; border-radius:8px;">
                    <?php else: ?>
                        <small>Chưa có ảnh bìa</small>
                    <?php endif; ?>
                </td>
                <td>
                    <a href="HASP_sua.php?MaSP=<?= urlencode($row['MaSP']) ?>" class="btn-th" title="Sửa hình ảnh">
                        <i class="fas fa-edit"></i>
                    </a>
                </td>
            </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="4" class="text-center text-muted">Không có sản phẩm nào có hình ảnh.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>

    <!-- Pagination -->
    <?php if ($total_pages > 1): ?>
    <nav class="text-center mt-4">
        <ul class="pagination justify-content-center">
            <?php if ($page > 1): ?>
                <li class="page-item"><a class="page-link" href="?page=<?= ($page - 1) ?>">&laquo;</a></li>
            <?php endif; ?>
            <?php for ($i=1; $i <= $total_pages; $i++): ?>
                <?php if ($i == $page): ?>
                    <li class="page-item active"><span class="page-link"><?= $i ?></span></li>
                <?php else: ?>
                    <li class="page-item"><a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a></li>
                <?php endif; ?>
            <?php endfor; ?>
            <?php if ($page < $total_pages): ?>
                <li class="page-item"><a class="page-link" href="?page=<?= ($page + 1) ?>">&raquo;</a></li>
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