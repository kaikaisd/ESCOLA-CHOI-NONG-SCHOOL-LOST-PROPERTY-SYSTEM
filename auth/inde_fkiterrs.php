<?php
  session_start();
  unset($_SESSION["class"]);
  unset($_SESSION["name"]);
  unset($_SESSION["sex"]);
  unset($_SESSION["cGroup"]);
?>
<!DOCTYPE html>
<html >
<head>
  <meta charset="UTF-8">
  <title>失物認領系統</title>
  
  
 
<link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
      <link rel="stylesheet" href="css/style.css">

  
</head>

<body>
    <div class="wrapper">
    <form class="form-signin" action="index_check_back.php" method="post">       
      <h2 class="form-signin-heading">登入</h2>
      <input type="text" class="form-control  span5" name="username" placeholder="用戶名" required="" autofocus="" />
      <input type="password" class="form-control  span5" name="password" placeholder="密碼" required=""/>     
      <button class="btn btn-lg btn-primary btn-block" type="submit">進入</button>   
    </form>
  </div>
  
  
</body>
</html>
