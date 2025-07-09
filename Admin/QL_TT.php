<?php
ob_start();
include '../includes/youjia_connect.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 1;

$sql = "SELECT * FROM thongtin WHERE MaTT = $id";
$result = mysqli_query($conn, $sql);

if (!$result || mysqli_num_rows($result) == 0) {
    die("Không tìm thấy dữ liệu doanh nghiệp với id = $id");
}

$row = mysqli_fetch_assoc($result);

$fieldNames = [
    'MST' => 'Mã số thuế',
    'DaiDien_PL' => 'Đại diện pháp luật',
    'DiaChi_CN' => 'Địa chỉ chi nhánh',
    'Email' => 'Email',
    'Hotline' => 'Hotline',
    'MoTa' => 'Mô tả',
    'SuMenh' => 'Sứ mệnh',
    'TamNhin' => 'Tầm nhìn',
    'GiaTriCotLoi' => 'Giá trị cốt lõi',
    'GioHoatDong' => 'Giờ hoạt động',
    'Slogan' => 'Slogan'
];

$fields = array_keys($fieldNames);
?>
<div class="thongtin">
<h2 class="text-center mb-4"><b>THÔNG TIN DOANH NGHIỆP</b></h2> <hr>
    <table >
        <thead>
            <tr style="background-color: rgb(0, 94, 116); color: white;">
                <th class="text-center" style="width: 20%;">MỤC THÔNG TIN</th>
                <th class="text-center" >THÔNG TIN</th>
            </tr>
        </thead>
        <tbody class="input admin">
            <?php foreach ($fields as $field) { ?>
            <tr style="background-color:white;">
                <td><?= htmlspecialchars($fieldNames[$field]) ?></td>
                <td><?= nl2br(htmlspecialchars($row[$field])) ?></td>
            </tr>
            <?php } ?>
        </tbody>
    </table> <br>
</div>
<div class="text-center mt-3">
    <a href="TT_sua.php?id=<?= htmlspecialchars($id) ?>&field=<?= htmlspecialchars($field) ?>" class="btn-luu" style='text-align: center'><i class="fas fa-edit"></i>&ensp;<b>THAY ĐỔI THÔNG TIN</b></a>
</div>

<?php
$conn->close();
$content = ob_get_clean();
include 'Layout_AD.php';
?>