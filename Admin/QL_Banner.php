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
                <td><img src="../images/slider/<?php echo $row['Banner']; ?>" width="120"></td>
                <td><?php echo htmlspecialchars($row['TieuDe']); ?></td>
                <td><?php echo htmlspecialchars($row['Link']); ?></td>
                <td><?php echo $row['NgayGio']; ?></td>
                <td class="text-center">
                    <a href="BN_sua.php?id=<?= htmlspecialchars($row['MaBN']) ?>" class="btn-th"><i class="fas fa-edit"></i></a>
                    <a href="BN_xoa.php?id=<?= htmlspecialchars($row['MaBN']) ?>" class="btn-th"><i class="fas fa-trash-can"></i></a>
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
