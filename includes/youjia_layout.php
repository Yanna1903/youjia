<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1">
<title>YOUJIA - CHUYÊN SỈ LẺ NỘI ĐỊA TRUNG</title>

<!-- Tải Bootstrap từ CDN -->
<link rel="stylesheet" href="css/bootstrap.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

<style type="text/css">
.imgbook {
    transition: all 1s ease-in;
    width: 100%;                  
    max-width: 400px;             
    object-fit: cover;            
    height: 300px;                
    border-radius: 8px;           
}
.imgbook:hover {
    transform: scale(0.9);        
    cursor: pointer;             
}
.imgsachbannhieu {
    width: 100px;
}

#zalo-chat-btn {
      position: fixed;
      bottom: 30%;
      right: 80px;
      z-index: 9999;
      cursor: pointer;
      box-shadow: 0 2px 8px rgb(113, 153, 196);
      transition: background-color 0.3s;
      display: flex;
      align-items: center;
      background-color:rgb(222, 237, 255);
      color: rgb(0, 115, 239);
      padding: 12px 20px;
      border-radius: 30px;
      font-weight: bold;
      font-family: Arial, sans-serif;
      text-decoration: none;
    }
    #zalo-chat-btn:hover {
      background-color:rgb(26, 109, 197);
      color:white;
    }
    #zalo-chat-btn img {
      width: 50px;
      height: 50px;
      margin-right: 10px;
    }
</style>

</head>
<body>
<?php
    include 'includes/youjia_connect.php';
    include "header.php";                   
?>
<div class="container">
  <div class="row">
    <div class="container mt-4">
    <!-- ds quần áo -->
      <?php echo $content; ?>  
    </div>
  </div>
</div>

<?php
    // include "quanaobannhieu.php";  
    include "footer.php";         //footer
?>
<!-- <?php include 'chatbox.php'; ?> -->
<a
    id="zalo-chat-btn"
    href="https://zalo.me/0976215508"
    target="_blank"
    rel="noopener noreferrer"
    title="Chat Zalo với chúng tôi"
  >
    <img src="images/Icon_of_Zalo.jpg" alt="Zalo" />
    Chat Zalo
</a>
</body>
</html>