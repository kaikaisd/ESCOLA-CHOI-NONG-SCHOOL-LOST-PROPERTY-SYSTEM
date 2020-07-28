<?php
// show potential errors / feedback (from login object)
if (isset($login)) {
    if ($login->errors) {
        foreach ($login->errors as $error) {
            echo $error;
        }
    }
    if ($login->messages) {
        foreach ($login->messages as $message) {
            echo $message;
        }
    }
}
?>

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
  <title>登入</title>
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
 <link href="./css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection"/>
  <link href="./css/style.css" type="text/css" rel="stylesheet" media="screen,projection"/>
  <link href="./css/animate.css" type="text/css" rel="stylesheet" />
</head>
  <style>
body
{
	background: #f5f5f5;
}

h5
{
	font-weight: 400;
}

.container
{
	margin-top: 80px;
	width: 400px;
	height: 700px;
}

.tabs .indicator
{
	background-color: #e0f2f1;
	height: 60px;
	opacity: 0.3;
}

.form-container
{
	padding: 40px;
	padding-top: 10px;
}

.confirmation-tabs-btn
{
	position: absolute;
}
</style>
 </head>

<body>
	  <div class="container">
	  	<div class="col s4">
<!-- login form box -->
<form class="col s12" method="post" action="index.php" name="loginform">

	<div class="form-container">
				<h3 class="teal-text">登入</h3>
				<div class="row">
					<div class="input-field col s12">
						<input id="login_input_username"  class="validate" type="text" name="user_name" >
						<label for="login_input_username">使用者名稱</label>
					</div>
				</div>
				<div class="row">
					<div class="input-field col s12">
						<input id="login_input_password"  class="validate" name="user_password" autocomplete="off" required type="password" >
						<label for="login_input_password">密碼</label>
					</div>
				</div>
	</div>
	<center>
    <button class="btn waves-effect waves-light " name="login" id="submit" type="submit" name="action">登入
    <i class="material-icons right">send</i>
  </button>
	<br><br>
	
</center>
</form>

  </div>
</div>

</body>
 <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script src="./js/materialize.js"></script>