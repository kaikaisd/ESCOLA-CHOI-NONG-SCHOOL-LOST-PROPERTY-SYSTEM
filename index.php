<?php
	session_start();	//初始化session變量
	/*
	if(!isset($_SESSION['admin'])){   
		echo "你還沒登陸";   
		exit;
	}*/
	header ('Content-Type: text/html; charset=UTF-8');
	/*連接數據庫*/
	require_once('con_db-php7.php');			//裝載頭文件
	int_db();
	//date_default_timezone_set("asia/macao");
  function resultToArray($result){
    $rows = array();
    while ($row = $result->fetch_assoc()){
      $rows[]=$row;
    }
    return $rows;
  }
	
	$result = sel_tb("name,pickup,description,COALESCE(photo,photo,'暫無圖片')","lost ","status = '0' ORDER BY uid");
  //$result = sel_tb("name","lost");
    /*"select name, pickup, claim, description, photo from lost where status = '未認領'"*/

	/*刪除用戶
	if(isset($_GET['action']) && $_GET['action'] == 'del'){
		mysql_query("delete from admintable where no = '". $_GET["no"] ."'");
		header("location:adminpage.php");
		exit;
	}*/


	
	/*管理員退出*/
	/*if(isset($_GET['action']) && $_GET['action'] == 'logout'){
		session_destroy();								//註銷session變量
		header("location:index.php");				//轉到adminlogin.php
		exit;
	}*/
	$show="";
	//echo mysqli_fetch_assoc($result);




  // $rows=resultToArray($result);
  $pegpage='';
$getpagetotal=1;


  // for($i=0;$i<sizeof($rows);++$i){
  //   if ($i>10){
  //     $getpagetotal++;
  //     $pegpage.='<li class="waves-effect"><a href="#!">'.$getpagetotal.'</a></li>';
  //   }
  // }
  // $result->free;


  while($rows=mysqli_fetch_array($result)){
	$show.="<tr>";
    $show.="<td>".$rows["name"]."</td>";
    $show.="<td>".$rows["pickup"]."</td>";
    $show.="<td>".$rows["description"]."</td>";
    $show.='<td><img class="materialboxed" data-caption="Losted items" width=100 height=60 src="./photo/'.$rows["COALESCE(photo,photo,'暫無圖片')"].'"> </td>';
    $show.="</tr>";
};


close_db(); 

unset($rows);
unset($result);
unset($getpagetotal);
?>
<html >

<head>

<!--Import Google Icon Font-->
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"/>
<!--Import materialize.css-->
<link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>
 <link href="css/style.css" type="text/css" rel="stylesheet" media="screen,projection"/>
<!--Let browser know website is optimized for mobile-->
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>失物認領系統</title>


</head>
<?php if($_GET){del_tb("lost");del_tb("user");echo '<script> alert("succeed."); location.href="index.php";</script>';}?>
<body>
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
<div id="main" hidden>
 <nav class="light-blue lighten-1" role="navigation">
    <div class="nav-wrapper container"><a id="logo-container" href="#" class="brand-logo"><img width="98" src="photo/logo.gif" >失物認領系統
 </a>

      <ul class="right hide-on-med-and-down">
		<?php
		if (isset($_SESSION['user_login_status'])){
		echo '<li>Welcome , '.$_SESSION['user_name'].'</li> <li><a href="adminpage.php">管理面版</a></li>  <li><a href="auth/index.php?logout">Logout</a></li>';
		}else{
		echo '<li><a href="auth/index.php">Login</a></li>';
		};
		?>
      </ul>

      <ul id="nav-mobile" class="side-nav">
		<?php
		if (isset($_SESSION['user_login_status'])){
		echo '<li>Welcome , '.$_SESSION['user_name'].'</li> <li><a href="adminpage.php">管理面版</a></li> <li><a href="auth/index.php?logout">Logout</a></li>';
		}else{
		echo '<li><a href="auth/index.php">Login</a></li>';
		};
		?>
		</ul>
		<a href="#" data-activates="nav-mobile" class="button-collapse"><i class="material-icons">menu</i></a>

     </div>
  </nav>

<div class="container">
<div class ="row">


	<div class="input-field col s12">
          <i class="material-icons prefix">search</i>
          <input type="text"  id="searchinput" class="autocomplete">
          <label for="searchinput">Search Item</label>
        </div>
      </div>
      <br>

<table class="striped centered responsive-table col s12" id="cstable">
	<thead>
	 <tr>
    <th>名稱</td>
	  <th>搭獲日期</td>
	  <th>描述</td>
	　<th>相片</td>
	 </tr>
	</thead>
	<tbody id="normaltable">
	<?php echo $show;unset($show);?>
		</tbody>
</table>
<div class="col s12">
     
            <ul class="pagination pager" id="myPager"></ul>
</div>
</div>

</div>




<footer class="page-footer orange">
    <div class="footer-copyright">
      <div class="container">
      Made by <a class="orange-text text-lighten-3" href="http://materializecss.com">Materialize</a>
	  & <a class="orange-text text-lighten-3" href="https://www.kaikaisd.link">kaikaisd</a> 
      </div>
    </div>
  </footer>
  </div>


</body>
  <script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
  <script src="js/materialize.js"></script>
    <script src="js/init.php" type="text/javascript"></script>
  
  <script type="text/javascript" src="js/pagination.js"></script>
<script type="text/javascript">

  $(window).on('load',function(){
    $('#overlay').fadeOut('500');
    $('#main').fadeIn('500');
});

</script>


</html>
<?php close_db();?>