if(!empty($_POST['name']) || !empty($_POST['email']) || !empty($_FILES['file']['name'])){
    $uploadedFile = '';
    if(!empty($_FILES["file"]["type"])){
        $fileName = time().'_'.$_FILES['file']['name'];
        $valid_extensions = array("jpeg", "jpg", "png");
        $temporary = explode(".", $_FILES["file"]["name"]);
        $file_extension = end($temporary);
        if((($_FILES["hard_file"]["type"] == "image/png") || ($_FILES["file"]["type"] == "image/jpg") || ($_FILES["file"]["type"] == "image/jpeg")) && in_array($file_extension, $valid_extensions)){
            $sourcePath = $_FILES['file']['tmp_name'];
            $targetPath = "uploads/".$fileName;
            if(move_uploaded_file($sourcePath,$targetPath)){
                $uploadedFile = $fileName;
            }
        }
    }
    
    $name = $_POST['name'];
    $email = $_POST['email'];
    
    //include database configuration file
    include_once 'dbConfig.php';
    
    //insert form data in the database
    $insert = $db->query("INSERT form_data (name,email,file_name) VALUES ('".$name."','".$email."','".$uploadedFile."')");
    
    echo $insert?'ok':'err';

    php ajax

<form action="edit.php?action=edit&uid=<?php echo $row['uid'];?>" method="post" enctype="multipart/form-data" name="form1" id="form1">
<table width="50%" border="1">
  <tr>
    <td colspan="2">失物資料</td>
  </tr>
  <tr>
    <td width="20%">名稱</td>
    <td><input name="name" type="text" value="<?php echo $row['name'];?>" /></td>
  </tr>
  <tr>
    <td>搭獲日期</td>
    <td><input name="pickup" type="text" class="IP_calendar" id="pickup" title="d/m/Y" value="<?php echo $row['pickup'];?>" alt="date" /></td>
  </tr>
  <td>認領日期</td>
  <td><input name="claim" type="text" class="IP_calendar" id="claim" title="d/m/Y" value="<?php echo $row['claim'];?>" alt="date" /></td>
  <tr>
    <td>描述</td>
    <td><textarea name="description" cols="40" rows="5" id="description"><?php echo $row['description'];?></textarea></td>
  </tr>
  <td>狀態</td>
  <td><label for="status"></label>
    <select name="status" id="status">
      <option selected="selected"><?php echo $row['status'];?></option>
      <option>未認領</option>
      <option>已認領</option>
    </select></td>
  <tr>
    <td>相片</td>
    <td><input type="file" name="userfile"/></td>
  </tr>
</table>
<input type="submit" name="Submit" value="提交" />
</form>
    