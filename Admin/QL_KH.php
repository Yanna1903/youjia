<?php
ob_start();
include '../includes/youjia_connect.php';

$keyword = isset($_GET['query']) ? trim($_GET['query']) : '';
$keyword_safe = mysqli_real_escape_string($conn, $keyword);

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;
$size = 10;
$offset = ($page - 1) * $size;

if ($keyword !== '') {
    $sql_count = "SELECT COUNT(*) AS total FROM khachhang 
                  WHERE MaKH LIKE '%$keyword_safe%' 
                     OR TenKH LIKE '%$keyword_safe%' 
                     OR Username LIKE '%$keyword_safe%'";
    
    $sql = "SELECT MaKH, TenKH, GioiTinh, Username, MatKhau, Email, SDT, DiaChi, NgaySinh, TrangThai 
            FROM khachhang 
            WHERE MaKH LIKE '%$keyword_safe%' 
               OR TenKH LIKE '%$keyword_safe%' 
               OR Username LIKE '%$keyword_safe%'
            LIMIT $offset, $size";
} else {
    $sql_count = "SELECT COUNT(*) AS total FROM khachhang";
    $sql = "SELECT MaKH, TenKH, GioiTinh, Username, MatKhau, Email, SDT, DiaChi, NgaySinh, TrangThai 
            FROM khachhang 
            LIMIT $offset, $size";
}

$result_total = mysqli_query($conn, $sql_count);
$row_total = mysqli_fetch_assoc($result_total);
$total_products = $row_total['total'];
$total_pages = ceil($total_products / $size);

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
    <h2 class="text-center m-0"><b>DANH SÁCH KHÁCH HÀNG</b></h2>
    <hr>

    <!-- FORM TÌM KIẾM -->
    <form method="get" action="" class="form-inline search-bar">
        <input type="text" name="query" class="form-control" placeholder="Tìm mã KH hoặc tên KH..."
               value="<?= htmlspecialchars($keyword) ?>">
        <button type="submit" class="btn-luu btn-tim"><i class="fas fa-search"></i></button>|
        <a href="KH_them.php" class="btn-th btn-them">
            <i class="fas fa-plus"></i><b>&ensp;Thêm</b>
        </a>        
    </form>
    <?php if (mysqli_num_rows($result) > 0): ?>
    <table class="table table-bordered table-striped">
        <thead>
            <tr class="text-center">
                <th style="width: 5%;">Mã KH</th>
                <th style="width: 10%;">Họ tên</th>
                <th style="width: 5%;">Giới tính</th>
                <th style="width: 10%;">Ngày sinh</th>
                <th style="width: 10%;">SĐT</th>
                <th style="width: 5%;">Email</th>
                <th style="width: 35%;">Địa chỉ</th>
                <th style="width: 10%;">Trạng thái</th>
                <th style="width: 10%;">Hành động</th>            
            </tr>
        </thead>

        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td class="text-center"><?= htmlspecialchars($row['MaKH']) ?></td>
                <td><?= htmlspecialchars($row['TenKH']) ?></td>
                <td class="text-center"><?= $row['GioiTinh'] == 0 ? 'Nam' : 'Nữ' ?></td>
                <td class="text-center"><?= date('d/m/Y', strtotime($row['NgaySinh'])) ?></td>
                <td class="text-center"><?= htmlspecialchars($row['SDT']) ?></td>
                <td><?= htmlspecialchars($row['Email']) ?></td>
                <td><?= htmlspecialchars($row['DiaChi']) ?></td>
                <td><?= $row['TrangThai'] == 0 ? '❌' : '✅' ?></td>
                <td class="text-center">
                    <a href="KH_sua.php?id=<?= $row['MaKH'] ?>" class="btn-th" title="Sửa"><i class="fas fa-edit"></i></a>
                    <a href="KH_xoa.php?id=<?= $row['MaKH'] ?>" class="btn-th" title="Xóa" onclick="return confirm('❓Bạn có chắc muốn xóa khách hàng này?');"><i class="fas fa-trash"></i></a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <?php else: ?>
        <p class="text-center text-muted">Không tìm thấy khách hàng phù hợp.</p>
    <?php endif; ?>

    <!-- PHÂN TRANG -->
    <?php if ($total_pages > 1): ?>
    <nav class="text-center mt-4">
        <ul class="pagination justify-content-center">
            <?php if ($page > 1): ?>
                <li class="page-item"><a class="page-link" href="?query=<?= urlencode($keyword) ?>&page=<?= $page - 1 ?>">&laquo;</a></li>
            <?php endif; ?>
            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <?php if ($i == $page): ?>
                    <li class="page-item active"><span class="page-link"><?= $i ?></span></li>
                <?php else: ?>
                    <li class="page-item"><a class="page-link" href="?query=<?= urlencode($keyword) ?>&page=<?= $i ?>"><?= $i ?></a></li>
                <?php endif; ?>
            <?php endfor; ?>
            <?php if ($page < $total_pages): ?>
                <li class="page-item"><a class="page-link" href="?query=<?= urlencode($keyword) ?>&page=<?= $page + 1 ?>">&raquo;</a></li>
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
