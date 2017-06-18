<?php
function register_car_make($make_name){
	
	$db = $GLOBALS['db_connect'];
	$make_name = sanitize ($make_name);
	$db->autocommit(false);
	if ($insert=  $db->query ("INSERT INTO CarMake (Name) VALUES ('$make_name')")){
		 echo $db->affected_rows . "New Car Make has been successfully added to database";
		 $db->commit();
	}
	else {
		echo $db->connect_error;
	} 
	
}

function register_car_model($model_data){
	$db = $GLOBALS['db_connect'];
	$make_id = sanitize ($model_data[0]); 
	$supplier_id = sanitize ($model_data[1]); 
	$model_name = sanitize ($model_data[2]); 
	$model_year = sanitize ($model_data[3]); 
	$model_price = sanitize ($model_data[4]); 
	$model_image = sanitize ($model_data[5]);
	$model_desc = sanitize ($model_data[6]); 
	
	
	$db->autocommit(false);
	if ($insert=  $db->query ("INSERT INTO CarModel (MakeID, SupplierID, Name, Year, Price, Description, Image) VALUES ('$make_id','$supplier_id', '$model_name','$model_year', '$model_price', '$model_desc','$model_image')")){
		 echo $db->affected_rows ."New Car Model has been successfully added to database";
		 $db->commit();
	}
	else {
		echo $db->connect_error;
	} 
	$db->close();
}

function get_car_make (){
	$db = $GLOBALS['db_connect'];
	$sql =  $db->query("SELECT MakeID, Name FROM CarMake");
	return $sql->fetch_all(MYSQLI_ASSOC);
	$sql->free();
	$db->close();
}

function get_car_make_by_id ($id){
	$db = $GLOBALS['db_connect'];
	$sql =  $db->query("SELECT Name FROM CarMake WHERE MakeID = '$id'");
	return $sql->fetch_all(MYSQLI_ASSOC);
	$sql->free();
	$db->close();
}

function get_car_model (){
	$db = $GLOBALS['db_connect'];
	$sql =  $db->query("SELECT ModelID,Name,Year, Price, Image FROM CarModel");
	return $sql->fetch_all(MYSQLI_ASSOC);
	$sql->free();
	$db->close();
}


function get_car_model_by_make_id ($id){
	$db = $GLOBALS['db_connect'];
	$sql =  $db->query("SELECT ModelID,Name,Year, Price, Image FROM CarModel WHERE MakeID = '$id'");
	return $sql->fetch_all(MYSQLI_ASSOC);
	$sql->free();
	$db->close();
}

function get_car_model_id ($id){
	$db = $GLOBALS['db_connect'];
	$sql =  $db->query("SELECT ModelID, MakeID, Name, Year, Price, Description, Image FROM CarModel WHERE ModelID = '$id'");
	if($sql->num_rows){
		return $sql->fetch_all(MYSQLI_ASSOC);
	}else {
		return false;	
	}
	$sql->free();
	$db->close();
}

function model_exists ($id){
	$db = $GLOBALS['db_connect'];
	$sql =  $db->query("SELECT * FROM CarModel WHERE ModelID = '$id'");
	if ($sql->num_rows){
		return true;
	} else {
		return false;
	}
	$sql->free();
	$db->close();
}

?>