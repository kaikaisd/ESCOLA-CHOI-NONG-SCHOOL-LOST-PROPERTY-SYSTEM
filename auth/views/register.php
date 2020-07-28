<?php
// show potential errors / feedback (from registration object)
if (isset($registration)) {
    if ($registration->errors) {
        foreach ($registration->errors as $error) {
            echo $error;
        }
    }
    if ($registration->messages) {
        foreach ($registration->messages as $message) {
            echo $message;
        }
    }
}
?>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
  <title><?php echo $title;?></title>
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
<!-- register form -->
<form method="post" action="register.php" name="registerform">

<div class="form-container">
                <h3 class="teal-text">註册</h3>
                <div class="row">
                    <div class="input-field col s12">
                        <label for="login_input_username">使用者名稱 (只能使用字母和數字,2至64個字元)</label>
                         <input id="login_input_username" class="validate"  type="text" pattern="[a-zA-Z0-9]{2,64}" name="user_name" required />
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                         <label for="login_input_email">使用者電郵</label>
                         <input id="login_input_email" class="validate" type="email" name="user_email" required />
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                         <label for="login_input_password_new">密碼(最少6個字元)</label>
    <input id="login_input_password_new" class="login_input" class="validate" type="password" name="user_password_new" pattern=".{6,}" required autocomplete="off" />

                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <label for="login_input_password_repeat">請再輸入一次密碼</label>
    <input id="login_input_password_repeat" class="login_input" class="validate" type="password" name="user_password_repeat" pattern=".{6,}" required autocomplete="off" />  
                      </div>
                </div>
                
    </div>
    <!-- the user name input field uses a HTML5 pattern check -->
    

    <!-- the email input field uses a HTML5 email type check -->
   

   <center>     <button class="btn waves-effect waves-light " name="register" id="submit" type="submit" name="action">註册
    <i class="material-icons right">send</i>
  </button>
</center>

</form>

  </div>
</div>

<!-- backlink -->
<center><a  class="btn waves-effect waves-light " href="index.php">返回登入頁面</a></center>


<script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script src="./js/materialize.js"></script>