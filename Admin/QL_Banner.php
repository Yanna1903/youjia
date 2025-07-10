<?php
include '../includes/youjia_connect.php';
$sql = "SELECT * FROM banner ORDER BY NgayGio DESC";
$result = mysqli_query($conn, $sql);
?>
<h2 class="thongtin">QUẢN LÝ BANNER</h2><hr>
<h3><a href="BN_them.php" style="font-style: italic; text-decoration: underline;color:rgb(255, 119, 23)">Thêm Banner mới</a></h3>
<table class="table table-bordered mt-3">
    <thead>
        <tr>
            <th>Hình ảnh</th>
            <th>Tiêu đề</th>
            <th>Link</th>
            <th>Ngày giờ</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td><img src="../images/<?php echo $row['Banner']; ?>" width="120"></td>
                <td><?php echo htmlspecialchars($row['TieuDe']); ?></td>
                <td><?php echo htmlspecialchars($row['Link']); ?></td>
                <td><?php echo $row['NgayGio']; ?></td>
                <td>
                    <a href="AD_banner_sua.php?id=<?php echo $row['MaBN']; ?>" class="btn btn-warning btn-sm">Sửa</a>
                    <a href="AD_banner_xoa.php?id=<?php echo $row['MaBN']; ?>" onclick="return confirm('Xóa banner này?');" class="btn btn-danger btn-sm">Xóa</a>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>
<?php
    $conn->close();
    $content = ob_get_clean();
    include 'Layout_AD.php';
?>
