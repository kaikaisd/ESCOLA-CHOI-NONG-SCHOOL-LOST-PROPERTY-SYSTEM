<?php
	session_start();
	header("Content-Type:text/html; charset=utf-8");
	if(!isset($_SESSION['user_login_status'])){   
		// echo "你還沒登陸";   
		// exit;
		// header("location:index.php");
		echo '<script> alert("你還沒登陸."); location.href="index.php";</script>';
	}


	require 'vendor/eihror/compress-image/autoload.php';
	require_once('con_db-php7.php');			//裝載頭文件
	date_default_timezone_set("asia/macao");
    int_db();
		
	//$check_query = "select uid, name, pickup, claim, description, status, photo from lost";
    //$check_result = mysql_query($check_query) or die ("無法使用此數據庫的原因為1:".mysql_error());
    $check_sql=sel_tb("uid, name, pickup, COALESCE(claim,claim,'暫無'),COALESCE(claim_time,claim_time,''),COALESCE(pickup_time,pickup_time,'') ,description, status, photo","lost");
	$show ='';
	  while($row = mysqli_fetch_array($check_sql)) {
   	if ($row["status"]==0){
   		$re_status="未領取";
   	}
   	if($row["status"]==1){
   		$re_status="已領取";
   	}



    $show.='<tr>';
    $show.="<td>".$row["uid"]."</td>";
    $show.="<td>".$row["name"]."</td>";
    $show.="<td>".$row["pickup"]."</td>";
    $show.="<td>".$row["COALESCE(claim,claim,'暫無')"]."</td>";
    $show.="<td>".$row["description"]."</td>";
    $show.="<td>".$re_status."</td>";
    $show.='<td><img class="materialboxed" data-caption="Losted items" width=100 src="photo/'.$row["photo"].'"></td>';
    $show.='<td><a class="waves-effect waves-light btn orange darken-3" onclick="window.location=\'edit.php?uid='.$row["uid"].'\';"><i class="material-icons left">edit</i></a></td>';
    $show.='<td><a class="waves-effect red darken-2 waves-light btn" herf="del.php?action=del&uid='.$row["uid"].'\';" onclick="return  confirm(\'是否確定刪除?\')"><i class="material-icons left">delete_forever</i></a></td>';
    $show.="</tr>";
	}
	
	
	//上傳檔案 & 新增記錄
	if(isset($_FILES['userfile']['tmp_name']) && $_POST['name'] != ''){
		
	//$photo_path = $_SESSION['m_id']."/"."photo";		//路徑	
	$photo_path = "photo";		//路徑
	$userfile = $_FILES['userfile']['tmp_name'];	//保存在系統的臨時位置 
		$userfile_name = $_FILES['userfile']['name'];	//文件名 
		$userfile_size = $_FILES['userfile']['size'];	//文件大小，字節 
		$userfile_type = $_FILES['userfile']['type'];	//文件類型
		echo($_FILES);
		 // echo "<script> alert('".$userfile."    ".$userfile_name."');</script>"; 
		$extend_name = substr($userfile_name,strrpos($userfile_name,'.')+1);	//提取文件名擴展名

		$file = $userfile;
		$today = date("YmdHis");

		$new_name_file =  $today.".".$extend_name;//將文件名改為上傳時間名

		$quality = 60;
		$image_compress = new Compress($file, $new_name_file, $quality, $destination);
		$userfile_name = $image_compress->compress_image();
		//$userfile_name = $_POST['name'].".".$extend_name;					//將文件名改為輸入的姓名
		$arry = array('JPG','jpg','Jpg','gif','GIF','Gif','png','Png','PNG');
		/* echo "<script> alert('2,".$userfile_name."');</script>"; */
		if(!in_array($extend_name,$arry)){			//判斷文件類型
			echo "上傳失敗,僅限於 jpg, bmp, gif,png 文件<br>"; 
			echo "<a href=\"#\" onClick=\"window.history.back();\">返回</a>";
			exit; 
		}
		
		if(!is_dir($photo_path))				//判斷用戶目錄是否存在
			mkdir ($photo_path, 0700);			//創建新目錄，以m_id命名

		
		/* echo "<script> alert('3');</script>";	*/
		$upfile = $photo_path."/".$userfile_name;	//保存位置和文件名
		// echo "<script> alert('$upfile');</script>";  
		if(!copy($userfile,$upfile)){			//上傳文件,將文件從臨時位置複製到用戶文件夾
			echo "上傳失敗"; 
			echo "<a href=\"#\" onClick=\"window.history.back();\">返回</a>";
			exit; 
		}
		
		$dd = strtotime(str_replace('/', '-',$_POST["date"]." ".$_POST["date1"]));
		$dd = date("Y-m-d H:i:s", $dd);
		/* echo "<script> alert('$dd');</script>"; */
		
		ins_tb("name,photo,pickup,description,status,pickup_time","lost", "'". $_POST["name"] ."','".$userfile_name."','".$dd."','". $_POST["description"] ."','0','". $_POST["date1"]."'");
		//echo "<script> alert('新增成功');location.href='adminpage.php';</script>"; 
		exit;
	}
	
    /*認領物品*/
	if(isset($_GET['action']) && $_GET['action'] == 'claim'){
		//mysql_query("UPDATE lost SET status = '已認領', claim = '". date("Y-m-d H:i:s") ."' where uid = '". $_GET["uid"] ."'");
		upd_tb("status = '1', claim = '". date("Y-m-d H:i:s") ."'","lost","uid = '". $_GET["uid"] ."'");
		header("location:adminpage.php");
		exit;
	}
	
	/*管理員退出
	if(isset($_GET['action']) && $_GET['action'] == 'logout'){
		session_destroy();								//註銷session變量
		header("location:index.php");				//轉到index.php
		exit;
        }*/
?>


<html lang="utf-8">
<head>
<!--Import Google Icon Font-->
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"/>
<!--Import materialize.css-->
<link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>
  <link href="css/style.css" type="text/css" rel="stylesheet" media="screen,projection"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

  <script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
  <script src="js/materialize.js"></script>
  <script src="js/init.php" type="text/javascript"></script>
  
  <script type="text/javascript" src="js/pagination.js"></script>
<title>管理頁面</title>

<script type="text/javascript">
	$(document).ready(function(){
  $("#searchinput").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#admintableitem tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});
</script>
</head>

<body>
	 <nav class="light-blue lighten-1" role="navigation">
    <div class="nav-wrapper container"><a id="logo-container" href="#" class="brand-logo"> <img width="98" src="photo/logo.gif" >失物認領系統</a>
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
  <div id="overlay" class="center" >
 <div class="preloader-wrapper big active" >
      <div class="spinner-layer spinner-blue">
        <div class="circle-clipper left">
          <div class="circle"></div>
        </div><div class="gap-patch">
          <div class="circle"></div>
        </div><div class="circle-clipper right">
          <div class="circle"></div>
        </div>
      </div>
</div>
</div>
  <div class="fixed-action-btn">

<a class="btn-floating btn-large waves-effect waves-light red" style="display: none;" id="scroll"><i class="material-icons">keyboard_arrow_up
</i></a>
</div>
<div id="main">
  <div class="container">
<div class ="row">
  

	<div class="input-field col s12" id="searchbar">
          <i class="material-icons prefix">search</i>
          <input type="text"  id="searchinput" class="autocomplete">
          <label for="searchinput">Search Item</label>
        </div>

	<div class="col s12">
	<ul class="tabs tabs-fixed-width ">
        <li class="tab col s3"><a href="#table" onclick="hidesearch()" class="active">Table</a></li>
        <li class="tab col s3"><a href="#form" onclick="hidesearch()">Form</a></li>
      </ul>
  </div>
 <div id="table" class="col s12">
<table class="striped centered responsive-table highlight col s12 " id="admintable">
  <thead>
	<tr>
   	  <th>UID</th>
      <th>名稱</th>
	  <th>搭獲日期</th>
	  <th>認領日期</th>
	  <th>描述</th>
      <th>狀態</th>
	　<th>相片</th>
      <th>修改</th>
      <th>刪除</th>
	</tr>
</thead>
	<tbody id="admintableitem">
		<?php echo $show; unset($show);?>
	</tbody>
</table>

<div class="col s12">
     
            <ul class="pagination pager" id="myPager"></ul>
</div>
</div>

<br><br>
<div id="form" class="col s12">
<form action="" method="post" enctype="multipart/form-data" name="form1" id="form1">
<div class="input-field col s12"> 
      <input name="name" id="name" type="text" onchange="removedisable()"><br>
      <label for="name" >物品名稱</label>
      </div>
	  <div class="input-field col s12 ">
     <label for="date" >日期</label>
      <input type="text" name="date" id="date" class ="datepicker" onchange="removedisable()" >
    </div>

	<div class="input-field col s12">
    	<textarea id="description" id="textarea1" name="description" class="materialize-textarea" data-length="120" onchange="removedisable()"></textarea>
    	<label for="textarea1">描述</label>
    </div>
	<div class="file-field input-field col s12">
    	<div class="btn">
    		<span>檔案</span>
    		<input type="file" name="userfile" />
    	</div>
		<div class="file-path-wrapper" ">
    		<input type="text"  placeholder="可留空，僅接受JPG/PNG/GIF的圖片格式" class="file-path validate">
    		
    	</div>
    </div>
<!-- <input type="submit" name="Submit" value="提交" /> -->
  <button class="btn waves-effect waves-light disabled" id="submit" type="submit" name="action">Submit
    <i class="material-icons right">send</i>
  </button>
</form>
</div>
</div>

</div>
</div>
<script type="text/javascript">
	$(window).load(function(){
    $('#overlay').fadeOut('200');
    $('#main').fadeIn('500');
});

</script>

<footer class="page-footer orange">
       <div class="footer-copyright">
      <div class="container">
      Made by <a class="orange-text text-lighten-3" href="http://materializecss.com">Materialize</a>
	  & <a class="orange-text text-lighten-3" href="https://www.kaikaisd.link">kaikaisd</a> 
	  
      </div>
    </div>
  </footer>
</body>
</html>
