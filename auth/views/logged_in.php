<!-- if you need user information, just put them into the $_SESSION variable and output them here -->
Hey, <?php echo $_SESSION['user_name']; ?>. You are logged in.
<?php
if ($_SESSION['user_login_status'] == 1){
//echo "We will redirect you to user page in 5s";
echo '<meta http-equiv="refresh" content="0; url=//'.$_SERVER['HTTP_HOST'].'/lf1/adminpage.php"/>';
}

?>

<!-- because people were asking: "index.php?logout" is just my simplified form of "index.php?logout=true" -->
<a href="index.php?logout">Logout</a>
