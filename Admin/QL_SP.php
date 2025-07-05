<?php
    ob_start();
    include '../includes/youjia_connect.php';
    $size = 5;
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    if ($page < 1) $page = 1;
    $offset = ($page - 1) * $size;
    $sql = "SELECT s.MaSP, s.TenSP, s.AnhBia, s.MoTa, s.BaoHanh, s.MauSac, s.GiaBan, s.SoLuong, dm.TenDM, ndm.TenNDM, s.TrangThai
            FROM sanpham s 
            JOIN DanhMuc dm ON s.MaDM = dm.MaDM
            JOIN NhomDanhMuc ndm ON s.MaNDM = ndm.MaNDM
            ORDER BY MaSP
            LIMIT $offset, $size";
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        die("Lỗi truy vấn: " . mysqli_error($conn));
    }   
?>

<div class="thongtin">
    <h2 class="text-center mb-5"><b>DANH SÁCH SẢN PHẨM</b></h2>
    <hr>
    <h3><a href="SP_them.php" style="font-style: italic; text-decoration: underline;color: #fb3d78; ">Thêm sản phẩm mới</a></h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th class="text-center" style="width:100px;">Mã SP</th>
                <th class="text-center" style="width:200px;">Tên SP</th>
                <th class="text-center" style="width:150px;">Ảnh Bìa</th>
                <th class="text-center" style="width:100px;">Số lượng</th>
                <th class="text-center" style="width:150px;">Giá bán</th>
                <th class="text-center" style="width:150px;">Màu sắc</th>
                <th class="text-center" style="width:150px;">Nhóm</th>
                <th class="text-center" style="width:150px;">Danh mục</th>
                <th class="text-center" style="width:150px;">Bảo hành</th>
                <th class="text-center" style="width:100px;">Hành động</th>
            </tr>
        </thead>
        <tbody style="background-color:white; color: rgb(0, 94, 116)">
            <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <!-- mã sản phẩm -->
                <td><?= mb_strimwidth($row['MaSP'], 0, 50, '...') ?></td>
                <!-- Tên sản phẩm -->
                <td><?= mb_strimwidth($row['TenSP'], 0, 50, '...') ?></td>
                <!-- ảnh bìa -->
                <td class="text-center">
                    <img src="../Images/<?= $row['AnhBia'] ?>" style="width:130px; height:150px; padding:0;">
                </td>
                <!-- số lượng -->
                <td class="text-center"><?= $row['SoLuong'] ?></td>
                <!-- màu sắc -->
                <td class="text-center"><?= number_format($row['GiaBan'], 0, ',', '.') ?></td>
                <!-- giá bán -->
                <td><?= mb_strimwidth($row['MauSac'], 0, 50, '...') ?></td>
                <!-- Nhóm danh mục -->
                <td class="text-center"><?= $row['TenNDM'] ?></td>
                <!-- Danh mục -->
                <td class="text-center"><?= $row['TenDM'] ?></td>
                <!-- Bảo hành -->
                <td><?= mb_strimwidth($row['BaoHanh'], 0, 50, '...') ?> ngày</td>

                <td class="text-center">
                    <a href="HASP_xem.php?MaSP=<?= urlencode($row['MaSP']) ?>" class="btn-th" title="Xem hình ảnh"><i class="fas fa-images"></i></a>
                    <a href="SP_sua.php?MaSP=<?= urlencode($row['MaSP']) ?>" class="btn-th" title="Sửa thông tin"><i class="fas fa-edit"></i></a>
                    <a href="SP_xoa.php?MaSP=<?= urlencode($row['MaSP']) ?>" class="btn-th" title="Xóa" 
                    onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này và tất cả hình ảnh?')">
                        <i class="fas fa-trash-alt"></i>
                    </a>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
<?php
    // Phân trang
    $sql_total = "SELECT COUNT(*) AS total FROM sanpham";
    $result_total = mysqli_query($conn, $sql_total);
    $row_total = mysqli_fetch_assoc($result_total);
    $total_products = $row_total['total'];
    $total_pages = ceil($total_products / $size);

    if ($total_pages > 1) {
        echo "<nav class='text-center'>";
        echo "<ul class='pagination'>";

        if ($page > 1) {
            echo "<li class='page-item'><a class='page-link' href='?page=" . ($page - 1) . "'>&laquo;</a></li>";
        }

        for ($i = 1; $i <= $total_pages; $i++) {
            if ($i == $page) {
                echo "<li class='page-item active'><span class='page-link'>$i</span></li>";
            } else {
                echo "<li class='page-item'><a class='page-link' href='?page=$i'>$i</a></li>";
            }
        }

        if ($page < $total_pages) {
            echo "<li class='page-item'><a class='page-link' href='?page=" . ($page + 1) . "'>&raquo;</a></li>";
        }

        echo "</ul>";
        echo "</nav>";
    }

    $conn->close();
    $content = ob_get_clean();
    include 'Layout_AD.php';
?>
<link rel="stylesheet" href="AD_css.css"> 