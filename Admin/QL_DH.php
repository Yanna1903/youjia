<?php
ob_start();
include '../includes/youjia_connect.php';

$keyword = isset($_GET['query']) ? trim($_GET['query']) : '';
$keyword_safe = mysqli_real_escape_string($conn, $keyword);

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;
$size = 10;
$offset = ($page - 1) * $size;

$where_clause = "";
if ($keyword !== '') {
    $where_clause = "WHERE dh.MaDH LIKE '%$keyword_safe%' 
                     OR kh.TenKH LIKE '%$keyword_safe%' 
                     OR kh.SDT LIKE '%$keyword_safe%' 
                     OR kh.DiaChi LIKE '%$keyword_safe%'";
}

$sql_count = "SELECT COUNT(*) AS total FROM donhang dh 
              JOIN khachhang kh ON dh.MaKH = kh.MaKH $where_clause";

$sql = "SELECT dh.MaDH, dh.NgayDH, dh.NgayGiao, dh.TrangThai, kh.TenKH, kh.SDT, kh.DiaChi
        FROM donhang dh 
        JOIN khachhang kh ON dh.MaKH = kh.MaKH
        $where_clause
        ORDER BY dh.MaDH DESC
        LIMIT $offset, $size";

$result_total = mysqli_query($conn, $sql_count);
$row_total = mysqli_fetch_assoc($result_total);
$total_orders = $row_total['total'];
$total_pages = ceil($total_orders / $size);

$result = mysqli_query($conn, $sql);
if (!$result) {
    die("Lỗi truy vấn: " . mysqli_error($conn));
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

<div class="thongtin">
    <h2 class="text-center m-0"><b>DANH SÁCH ĐƠN HÀNG</b></h2>
    <hr>
    <form method="get" class="form-inline search-bar mb-3">
        <input type="text" name="query" class="form-control" placeholder="Tìm mã ĐH, tên KH, số điện thoại..." value="<?= htmlspecialchars($keyword) ?>">
        <button type="submit" class="btn-luu btn-tim"><i class="fas fa-search"></i></button>
    </form>

    <?php if (mysqli_num_rows($result) > 0): ?>
        <table class="table table-bordered table-striped">
            <thead class="text-center">
                <tr>
                    <th style="width: 8%">Mã ĐH</th>
                    <th style="width: 15%">Khách hàng</th>
                    <th style="width: 10%">SĐT</th>
                    <th style="width: 25%">Địa chỉ</th>
                    <th style="width: 10%">Ngày đặt</th>
                    <th style="width: 10%">Ngày giao</th>
                    <th style="width: 10%">Trạng thái</th>
                    <th style="width: 12%">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td class="text-center"><?= htmlspecialchars($row['MaDH']) ?></td>
                    <td><?= htmlspecialchars($row['TenKH']) ?></td>
                    <td class="text-center"><?= htmlspecialchars($row['SDT']) ?></td>
                    <td><?= htmlspecialchars($row['DiaChi']) ?></td>
                    <td class="text-center"><?= date('d/m/Y', strtotime($row['NgayDH'])) ?></td>
                    <td class="text-center">
                        <?= $row['NgayGiao'] ? date('d/m/Y', strtotime($row['NgayGiao'])) : '<i class="text-muted">Chưa có</i>' ?>
                    </td>
                    <td class="text-center">
                        <?php
                            switch ($row['TrangThai']) {
                                case 1: echo '<span class="text-warning">Chờ xác nhận</span>'; break;
                                case 2: echo '<span class="text-info">Xác nhận</span>'; break;
                                case 3: echo '<span class="text-primary">Đang giao</span>'; break;
                                case 4: echo '<span class="text-success">Hoàn thành</span>'; break;
                                case 5: echo '<span class="text-danger">Đã hủy</span>'; break;
                                default: echo 'Không rõ';
                            }
                        ?>
                    </td>
                    <td class="text-center">
                        <a href="DH_chitiet.php?id=<?= $row['MaDH'] ?>" class="btn-th"><i class="fas fa-eye"></i></a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <?php if ($total_pages > 1): ?>
            <nav class="text-center mt-3">
                <ul class="pagination justify-content-center">
                    <?php if ($page > 1): ?>
                        <li class="page-item"><a class="page-link" href="?query=<?= urlencode($keyword) ?>&page=<?= $page - 1 ?>">&laquo;</a></li>
                    <?php endif; ?>
                    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                        <li class="page-item <?= ($i == $page ? 'active' : '') ?>">
                            <a class="page-link" href="?query=<?= urlencode($keyword) ?>&page=<?= $i ?>"><?= $i ?></a>
                        </li>
                    <?php endfor; ?>
                    <?php if ($page < $total_pages): ?>
                        <li class="page-item"><a class="page-link" href="?query=<?= urlencode($keyword) ?>&page=<?= $page + 1 ?>">&raquo;</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        <?php endif; ?>
    <?php else: ?>
        <p class="text-center text-muted">Không tìm thấy đơn hàng nào phù hợp.</p>
    <?php endif; ?>
</div>
<?php
$conn->close();
$content = ob_get_clean();
include 'Layout_AD.php';
?>