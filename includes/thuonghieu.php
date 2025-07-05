<style>
  .thuonghieu-wrapper {
    font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background-color:rgb(234, 251, 255);
    padding: 15px;
    margin: 15px 0;
    box-shadow: 0 0 8px rgba(113, 152, 163, 0.77);
  }

  .thuonghieu-title {
    font-size: 18px;
    font-weight: bold;
    color: #285560;
    margin-bottom: 10px;
  }

  .thuonghieu-list {
    display: flex;
    flex-wrap: nowrap;
    overflow-x: auto;
    gap: 50px; /* khoảng cách giữa tên các dm/th */
    padding-bottom: 5px;
  }

  .thuonghieu-item a {
    color: #285560;
    text-decoration: none;
    font-size: 16px;
    white-space: nowrap;
  }

  .thuonghieu-item a:hover {
    text-decoration: underline;
  }
</style>

<div class="thuonghieu-wrapper">
    <div class="thuonghieu-title" style='text-align: left'>THƯƠNG HIỆU</div>
    <div class="thuonghieu-list">
      <?php
          $sql = "SELECT MaTH, TenTH FROM thuonghieu ORDER BY MaTH DESC";
          $result = mysqli_query($cuoiki_conn, $sql);
          while ($row = mysqli_fetch_assoc($result)) {
              echo '<div class="thuonghieu-item"><a href="theoTH.php?id=' . $row['MaTH'] . '">' . $row['TenTH'] . '</a></div>';
          }
      ?>
    </div>
</div>
