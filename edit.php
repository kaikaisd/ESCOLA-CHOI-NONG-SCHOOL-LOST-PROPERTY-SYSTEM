<?php
	session_start();
	header('Content-type: text/html; charset=utf-8');  //可令php使用utf-8編制頁面;
	if(empty($_GET)){
		echo '<script> alert("你還沒有選擇要修改的項目."); location.href="adminpage.php";</script>';}
	if(!isset($_SESSION['user_login_status']) ){   
		//echo "你還沒登陸";   
		//exit;
		//header("location:index.php");
		echo '<script> alert("你還沒登陸."); location.href="index.php";</script>';
		
	}
	
	require 'vendor/autoload.php';

require_once('con_db-php7.php');					//裝載頭文件
	date_default_timezone_set("asia/macao");
	//bigen_con();
	int_db();
	// $check_query = "select uid, name, pickup, claim, description, status, photo from lost where uid = '". $_GET["uid"] ."'";
 //    $check_result = mysqli_query($check_query) or die ("無法使用此數據庫的原因為s:".mysqli_error());
	$check_result = sel_tb("uid,name, pickup, claim, description, status, photo","lost","uid = '". $_GET["uid"] ."'");
	//print_r($row);
	$row = mysqli_fetch_array($check_result);
	//print_r($row);
	
	/*更新物品*/
	if(isset($_GET['action']) && $_GET['action'] == 'edit'){
	
	$filename = $row['photo'];
	$photo_path = "photo";		//路徑
	//檢查是否更新圖片檔案
	if(!empty($_FILES['userfile']['tmp_name']) && $_POST['name'] != ''){
	
	//將舊檔案刪除
	if(file_exists($photo_path."/".$filename)){
            unlink($photo_path."/".$filename);
        }
		
	//$photo_path = $_SESSION['m_id']."/"."photo";		//路徑
	
	$userfile = $_FILES['userfile']['tmp_name'];	//保存在系統的臨時位置 
		$userfile_name = $_FILES['userfile']['name'];	//文件名 
		$userfile_size = $_FILES['userfile']['size'];	//文件大小，字節 
		$userfile_type = $_FILES['userfile']['type'];	//文件類型
		/* echo "<script> alert('1');</script>"; */
		$extend_name = substr($userfile_name,strrpos($userfile_name,'.')+1);	//提取文件名擴展名
		$file = $userfile;
		$today = date("YmdHis");

		$new_name_file =  $today.".".$extend_name;//將文件名改為上傳時間名

		$quality = 60;
		$image_compress = new  Eihror\Compress\Compress($file, $new_name_file, $quality,5,$photo_path );
		$new_name_file = $image_compress->compress_image();				//將文件名改為上傳時間名
		//$userfile_name = $_POST['name'].".".$extend_name;					//將文件名改為輸入的姓名
		$arry = array('JPG','jpg','Jpg','gif','GIF','Gif','zip','ZIP','rar','RAR');
		/* echo "<script> alert('2,".$userfile_name."');</script>"; */
		if(!in_array($extend_name,$arry)){			//判斷文件類型
			echo "上傳失敗,僅限於 jpg, bmp, gif 文件<br>"; 
			echo "<a href=\"#\" onClick=\"window.history.back();\">返回</a>";
			exit; 
		}

		
		if(!is_dir($photo_path))				//判斷用戶目錄是否存在
			mkdir ($photo_path, 0700);			//創建新目錄，以m_id命名

		
		/* echo "<script> alert('3');</script>";	*/
		$upfile = $photo_path."/".$userfile_name;	//保存位置和文件名
		/* echo "<script> alert('$upfile');</script>";  */
		if(!copy($userfile,$upfile)){			//上傳文件,將文件從臨時位置複製到用戶文件夾
			echo "上傳失敗"; 
			echo "<a href=\"#\" onClick=\"window.history.back();\">返回</a>";
			exit; 
			}
		}
		
	if($_POST["status"] == 1 && $_POST["date1"]==""){
		$ans="date1";
	}
	

	if ($_POST["status"] == 0 && $_POST["date1"]!==""){
		$_POST["date1"]="";
	}

	if($_POST["date1"]==""){
		if(empty($userfile_name)){
			if ($ans!==""){
				$ans .= upd_tb("name = '".$_POST["name"]."' , status = '".$_POST["status"]."', pickup = '".$_POST["date"]."', claim = NULL,  description = '".$_POST["description"]."' where uid = '". $_GET["uid"] ."'","lost");
			}else{
				$ans = upd_tb("name = '".$_POST["name"]."' , status = '".$_POST["status"]."', pickup = '".$_POST["date"]."', claim = NULL,  description = '".$_POST["description"]."' where uid = '". $_GET["uid"] ."'","lost");
			}

		
  		}else{
  			if ($ans!==""){
				$ans .=upd_tb("name = '".$_POST["name"]."', photo ='".$userfile_name."' , status = '".$_POST["status"]."', pickup = '".$_POST["date"]."', claim = NULL, description = '".$_POST["description"]."' where uid = '". $_GET["uid"] ."'","lost");
			}else{
				$ans =upd_tb("name = '".$_POST["name"]."', photo ='".$userfile_name."' , status = '".$_POST["status"]."', pickup = '".$_POST["date"]."', claim = NULL, description = '".$_POST["description"]."' where uid = '". $_GET["uid"] ."'","lost");
			}
		
		}
  	}else{
    if (empty($userfile_name)){
    	if ($ans!==""){
				$ans .=upd_tb("name = '".$_POST["name"]."' , status = '".$_POST["status"]."', pickup = '".$_POST["date"]."', claim = '".$_POST["date1"]."', description = '".$_POST["description"]."' where uid = '". $_GET["uid"] ."'","lost");
			}else{
				 $ans =upd_tb("name = '".$_POST["name"]."' , status = '".$_POST["status"]."', pickup = '".$_POST["date"]."', claim = '".$_POST["date1"]."', description = '".$_POST["description"]."' where uid = '". $_GET["uid"] ."'","lost");
			}
     
    }else{
    	if ($ans!==""){
				 $ans .=upd_tb("name = '".$_POST["name"]."' , photo ='".$userfile_name."', status = '".$_POST["status"]."', pickup = '".$_POST["date"]."' , claim = '".$_POST["date1"]."' , description = '".$_POST["description"]."' where uid = '". $_GET["uid"] ."'","lost");
			}else{
				 $ans =upd_tb("name = '".$_POST["name"]."' , photo ='".$userfile_name."', status = '".$_POST["status"]."', pickup = '".$_POST["date"]."' , claim = '".$_POST["date1"]."' , description = '".$_POST["description"]."' where uid = '". $_GET["uid"] ."'","lost");
			}
     
    	}
	}

	if (!empty($ans)){
		if($ans=="date1"){
		 	echo '<script> alert("請填寫認領日期\n本次所有的外動均為無效."); url='.$_SERVER['PHP_SELF'].'  </script>';
		}else{
			echo '<script> alert("偵測到SQL錯誤,請聯繫負責老師.");</script>';
		}
	}else{
		echo '<script> alert("修改成功.");location.href="adminpage.php";</script>';
	}
// 
		// upd_tb("name = '".$_POST["name"]."' , photo ='".$userfile_name."', status = '".$_POST["status"]."', pickup = '".$_POST["date"]."', claim = '".$_POST["date1"]." ".$_POST["time"]."', description = '".$_POST["description"]."' where uid = '". $_GET["uid"] ."'","lost");
	// mysqli_query("UPDATE lost SET name = '".$_POST["name"]."' , photo ='".$userfile_name."', status = '".$_POST["status"]."', pickup = '".$_POST["pickup"]."', claim = '".$_POST["claim"]."', description = '".$_POST["description"]."' where uid = '". $_GET["uid"] ."'");
		// header("location:adminpage.php");
		//echo "<script>window.close();</script>";
		//echo $re;
		//exit;
	}
	
?>
<html lang="utf-8">
<head>
<!--Import Google Icon Font-->
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<!--Import materialize.css-->
<link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>
  <link href="css/style.css" type="text/css" rel="stylesheet" media="screen,projection"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
  <script src="js/materialize.js"></script>
  
  <script src="js/jquery-paginate.min.js" type="text/javascript"></script>
<title>修改UID為 <?php echo $row["uid"];?> 的失物</title>

</head>

<body onload="disableupload();detectifzero();">
<nav class="light-blue lighten-1" role="navigation">
    <div class="nav-wrapper container"><a id="logo-container" href="index.php" class="brand-logo"> <img width="98" src="photo/logo.gif" >失物認領系統</a>
      <ul class="right hide-on-med-and-down">
		<?php
		if (isset($_SESSION['user_login_status'])){
		echo '<li>Welcome , '.$_SESSION['user_name'].'</li> <li><a href="index.php">主頁</a></li> <li><a href="auth/index.php?logout">Logout</a></li>';
		}else{
		echo '<li><a href="auth/index.php">Login</a></li>';
		};
		?>
      </ul>

      <ul id="nav-mobile" class="side-nav">
		<?php
		if (isset($_SESSION['user_login_status'])){
		echo '<li>Welcome , '.$_SESSION['user_name'].'</li> <li><a href="index.php">主頁</a></li> <li><a href="auth/index.php?logout">Logout</a></li>';
		}else{
		echo '<li><a href="auth/index.php">Login</a></li>';
		};
		?>
		</ul>
		<a href="#" data-activates="nav-mobile" class="button-collapse"><i class="material-icons">menu</i></a>

     </div>
  </nav>
  <br>
<div class="container">
<div class="row">
	<h2>失物資料 ID: <?php echo $row["uid"]?> </h2>
    <form class="col s12" action="edit.php?action=edit&uid=<?php echo $row['uid'];?>" method="post" enctype="multipart/form-data" name="form1" id="form1">
      <div class="input-field col s12"> 
      <input name="name" id="name" type="text" value="<?php echo $row['name'];?>" required="required"><br>
      <label for="name" >物品名稱</label>
      </div>
	  <div class="col s6 ">
     <label for="date" >搭獲日期</label>
      <input type="text" name="date" id="date" value="<?php echo $row['pickup'];?>" class ="datepicker"  required="required">
    </div>
    
	<div class="col s6 ">
      <label for="date1" >認領日期</label>
      <input type="text" name="date1" id="date1" value="<?php echo $row['claim'];?>" class ="datepicker" required="required">
    </div>
    
	<div class="input-field col s12">
    	<textarea id="description" id="textarea1" name="description" class="materialize-textarea" data-length="120" required="required" ><?php echo $row['description'];?></textarea>
    	<label for="textarea1">描述</label>
    </div>

     <p>
      <input type="checkbox" id="onoff" onchange="valueChanged()" />
      <label for="onoff" >是否上傳圖片</label>
    </p>

	<div class="file-field input-field col s12" id="file">
    	<div class="btn">
    		<span>檔案</span>
    		<input type="file" name="userfile" id="userfile" />
    	</div>
		<div class="file-path-wrapper" >
    		<input type="text" value="<?php echo $row['photo'];?>" placeholder="可留空，僅接受JPG/PNG/GIF的圖片格式" class="file-path validate">
    		
    	</div>
    </div>

    <div class="input-field col s12">
    <select name="status" id="status" required onchange="detectifzero();detectifgot()" onload="detectifzero()">
    	<option value="" disabled>請選擇</option>
     	<option value="" disabled  >現時的狀態為: <mark><?php if($row['status']=='0'){echo "未領取";}else{echo "已領取";};?></mark> </option>
     	<?php
     	if ($row['status']=='0'){
     		echo " <option value='0'  selected>未領取</option> <option value='1'>已領取</option>";
    	 }else{
     		echo " <option value='0' >未領取</option> <option value='1' selected>已領取</option>";
    	 };
     	?>
    </select>
    <label>狀態</label>
  </div>

  <button class="btn waves-effect waves-light " id="submit" type="submit" name="action">Submit
    <i class="material-icons right">send</i>
  </button>
    </form>
  </div>
</div>


<footer class="page-footer orange">

	<div class="container">
      <div class="row">
        <div class="col s12">
          <h5 class="white-text">注意</h5>
          <p class="grey-text text-lighten-4">以上失物者如需認領，可親臨圖書館管理員認領。<br>失物認領期為三個月，在認領期過後仍未有被認領之物品，將由學校負責處理。<br><h4>注! 若遺失衣物、水壼等，請前往傳達室詢問。</h4></p>


        </div>
        </div>
      </div>
       <div class="footer-copyright">
      <div class="container">
      Made by <a class="orange-text text-lighten-3" href="http://materializecss.com">Materialize</a>
	  & <a class="orange-text text-lighten-3" href="https://www.kaikaisd.link">kaikaisd</a> 
	  
      </div>
    </div>
  </footer>

</body>
</html>
<script src="js/init.js" type="text/javascript"></script>
<?php close_db();?>