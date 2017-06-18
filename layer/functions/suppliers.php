<?php
function register_supplier ($register_data){
	$db = $GLOBALS['db_connect'];
	$name = sanitize ($register_data[0]);
	$email = sanitize ($register_data[1]);
	$address = sanitize ($register_data[2]);
	$postcode = sanitize ($register_data[3]);
	$phone = sanitize ($register_data[4]);
	$mobile = sanitize ($register_data[5]);
	$fax = sanitize ($register_data[6]);

	$db->autocommit(false);
	if ($insert=  $db->query ("INSERT INTO Suppliers (Name, Email, Address, PostCode,
	 Phone, Mobile, Fax) VALUES ('$name', '$email', '$address','$postcode', '$phone', '$mobile','$fax')")){
		 echo $db->affected_rows . "New Supplier has been successfully added";
		 $db->commit();
	}
	else {
		echo $db->connect_error;
	}
	$db->close();
}

function get_suppliers(){
	$db = $GLOBALS['db_connect'];
	$sql = $db->query("SELECT SupplierID, Name FROM Suppliers");
	return $sql->fetch_all(MYSQLI_ASSOC);
	$sql->free();
	$db->close();
}


?>