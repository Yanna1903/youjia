<?php
include '../includes/youjia_connect.php';

$MaNDM = isset($_GET['MaNDM']) ? intval($_GET['MaNDM']) : 0;

echo '<option value="">-- Chọn danh mục --</option>';

if ($MaNDM > 0) {
    $sql = "SELECT MaDM, TenDM FROM DanhMuc WHERE MaNDM = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $MaNDM);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    while ($row = mysqli_fetch_assoc($result)) {
        echo '<option value="' . $row['MaDM'] . '">' . htmlspecialchars($row['TenDM']) . '</option>';
    }
}
?>
