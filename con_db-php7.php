 	<?php

 	// header ('Content-Type: text/html; charset=UTF-8');
$connMy;
function int_db(){
	global $connMy;
	$servername = "";
	$username = "";
	$password = "";
	$dbname = "";
	$connMy = new mysqli($servername, $username, $password, $dbname);
	if ($connMy->connect_error) {
    die("連接失敗: " . $connMy->connect_error);
	};
	unset($servername);
	unset($username);
	unset($password);
	unset($dbname);
};
function sel_tb($obj,$table,$condi){
	global $connMy;
	if (empty($condi)){
		$check_query = "SELECT ". $obj ." FROM ".$table;}
	else{
		$check_query = "SELECT ". $obj ." FROM ".$table." WHERE ".$condi;
	};
	// echo $check_query;
	$check_result = mysqli_query($connMy, $check_query);
	unset($check_query);
	return $check_result;
};

function ins_tb($obj,$table,$values){
	global $connMy;
	$check_query = "INSERT INTO ". $table ." (".$obj.") values (".$values.")";
//	mysqli_query($connMy,$check_query);
	if (!mysqli_query($connMy, $check_query)) {
		 echo "Error: " . $check_query . "<br>" . mysqli_error($connMy);
	};
	unset($check_query);
};


function upd_tb($obj,$table,$condi){
	global $connMy;
	if (empty($condi)){
		$check_query = "UPDATE ". $table ." SET ".$obj;}
	else{
		$check_query = "UPDATE ". $table ." SET ".$obj." WHERE ".$condi;
	};//echo $check_query;
	if (!mysqli_query($connMy, $check_query)) {
		echo "Error: " . $check_query . "<br>" . mysqli_error($connMy);
	};
	unset($check_query);
};

function del_tb($table,$condi){
	global $connMy,$check_query;
	$check_query = "DELETE FROM ".$table." where ".$condi;
	// echo $check_query;
	if (!mysqli_query($connMy, $check_query)) {
		echo "Error: " . $check_query . "<br>" . mysqli_error($connMy);
	};
	unset($check_query);
};

function export_tb($table,$condi){
	global $connMy;

// filename for export
$csv_filename = '失物記錄系統_'.$table.'資料_'.date('Y-m-d').'.csv';

// create empty variable to be filled with export data
$csv_export = '';
// query to get data from database
$query = mysqli_query($connMy, "SELECT * FROM ".$table." ".$condi);
$field = mysqli_field_count($connMy);
// create line with field names
for($i = 0; $i < $field; $i++) {
    $csv_export.= mysqli_fetch_field_direct($query, $i)->name.';';
}
// newline (seems to work both on Linux & Windows servers)
$csv_export.= '
';
// loop through database query and fill export variable
while($row = mysqli_fetch_array($query)) {
    // create line with field values
    for($i = 0; $i < $field; $i++) {
        $csv_export.= '"'.$row[mysqli_fetch_field_direct($query, $i)->name].'";';
    }
    $csv_export.= '
';
}
// Export the data and prompt a csv file for download
header("Content-type: text/x-csv");
header("Content-Disposition: attachment; filename=".$csv_filename."");
echo($csv_export);
}

function close_db(){
	global $connMy;
	mysqli_close($connMy);
	unset($GLOBALS['connMy']);
};
?>
