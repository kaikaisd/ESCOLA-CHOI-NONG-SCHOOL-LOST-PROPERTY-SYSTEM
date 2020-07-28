<?php
session_start();
require('con_db-php7.php');
if(!isset($_SESSION['user_login_status'])){ 
	echo '<script> alert("你還沒登陸."); location.href="index.php";</script>'; 
}else{
	if(isset($_GET['delete']) && $_GET['delete'] == 'del'){
		echo '<script> alert("你還沒有選擇要刪除的項目."); location.href="adminpage.php";</script>';
	}else{
		$file = sel_tb("uid , photo","lost","uid = '".$_GET['uid']."'");
		$row=mysqli_fetch_array($file);
		unlink('photo/'.$row["photo"]);
	
		
		$result = del_tb("lost","uid = ".$_GET['uid']."");

		if (empty($result)){
			echo '<script> alert("成功."); location.href="adminpage.php";</script>';
		}else{echo '<script> alert("存在錯誤信息,請聯繫負責老師."); location.href="adminpage.php";</script>';}
	}
}



?>