<style>
/* .danhmuc-wrapper {
    font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background-color:rgb(234, 251, 255);
    padding: 15px;
    border-radius: 12px;
    margin: 15px 0;
    box-shadow: 0 0 8px rgba(113, 152, 163, 0.77);
} */

.danhmuc-title {
    font-size: 18px;
    font-weight: bold;
    color: #285560;
    margin-bottom: 10px;
}

.danhmuc-list {
    display: flex;
    flex-wrap: nowrap;
    overflow-x: auto;
    gap: 80px; /* khoảng cách giữa tên các dm/th */
    padding-bottom: 5px;
}

.danhmuc-item a {
    color: #285560;
    text-decoration: none;
    font-size: 16px;
    white-space: nowrap;
}

.danhmuc-item a:hover {
    text-decoration: underline;
}

</style>

<div class="danhmuc-wrapper">
    <div class="danhmuc-title" style='text-align: left'><b>ĐIỆN TỬ</b></div>
    <!-- <hr> -->
    <div class="danhmuc-list">
        <?php
            $sql = "SELECT MaDT, TenDT FROM danhmucDientu";
            $result = mysqli_query($cuoiki_conn, $sql);
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<div class="danhmuc-item"><a href="theoDMDT.php?id=' . $row['MaDT'] . '">' . $row['TenDT'] . '</a></div>';
            }
        ?>
    </div>
</div>
