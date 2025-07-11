<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1">
<title>YOUJIA - CHUYÊN SỈ LẺ NỘI ĐỊA TRUNG</title>

<link rel="stylesheet" href="css/bootstrap.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<style>
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
  .search-form {
    justify-content: center;
    align-items: center;
    width: 1150px !important;
    margin: 0;
    padding-left:5px;
  }
  .search-form .form-control {
    border-radius: 20px 0 0 20px;
    height: 45px;
    width: 100% !important;
    border: 1px solid rgb(255, 119, 23);
    margin-left:2PX;
    padding: 10px 15px;
  }
  .search-form .form-control:focus {
    outline: none !important;
    box-shadow: none !important;
    border: solid 2px rgb(253, 178, 125) !important;
  }
  .search-form .btn {
    border-radius: 0 20px 20px 0;
    height: 100%;
    width: 100px;
    background-color: rgb(255, 119, 23);
    color: white;
    border: 2.5px solid rgb(255, 119, 23);
    border-left: 5px solid rgb(255, 119, 23);
    margin-right: 10px;
  }
  .search-form .btn:hover,  .search-form .btn:focus {
    background-color: rgb(228, 95, 0) !important ;
    border-color: rgb(228, 95, 0);
  }
</style>
</style>
</head>
<body>
<?php
    include 'includes/youjia_connect.php';
    include "header.php";      
    include "slider.php";
?>

<div class="center container">
  <div class="center row mt-4">
      <div class="col-12">
          <?php echo $content; ?>  
      </div>
  </div>
</div>

<?php
    include "footer.php";
?>

<a
    id="zalo-chat-btn"
    href="https://zalo.me/0976215508"
    target="_blank"
    rel="noopener noreferrer"
    title="Chat Zalo với chúng tôi"
>
    <img src="images/Logo/Icon_of_Zalo.jpg" alt="Zalo" />
    Chat Zalo
</a>
</body>
</html>
