<?php
function logged_in(){
	return (isset($_SESSION['customer_id'])? true :false);
	
}
function admin_logged_in(){
	return (isset($_SESSION['admin'])? true :false);
}

function get_customer_name(){
	$db = $GLOBALS['db_connect'];
	if(isset($_SESSION['customer_id'])){
		$id = $_SESSION['customer_id'];
		$sql=  $db->query( "SELECT FirstName FROM Customers WHERE CustomerID = '$id' ");
		$rows= $sql->fetch_all(MYSQLI_ASSOC);
		foreach ($rows as $row){
			 echo $row['FirstName'];
		}
	} 
	if (isset($_SESSION['admin'])){
		$id = $_SESSION['admin'];
		$sql=  $db->query( "SELECT FirstName FROM Customers WHERE CustomerID = '$id' ");
		$rows= $sql->fetch_all(MYSQLI_ASSOC);
		foreach ($rows as $row){
			 echo $row['FirstName'];
		}
	}
}

function register_customer ($register_data){
	
	$db = $GLOBALS['db_connect'];
	$firstname = sanitize ($register_data[0]);
	$lastname = sanitize ($register_data[1]);
	$email = sanitize ($register_data[2]);
	$password = sanitize ($register_data[3]);
	$address = sanitize ($register_data[4]);
	$city = sanitize ($register_data[5]);
	$postcode = sanitize ($register_data[6]);
	$phone = sanitize ($register_data[7]);
	$mobile = sanitize ($register_data[8]);
	$fax = sanitize ($register_data[9]);
	$active = 1;
	$db->autocommit(false);
	if ($insert=  $db->query ("INSERT INTO Customers (RoleID, FirstName, LastName, Email, Password, Address,City, PostCode,
	 Phone, Mobile, Fax, Active ) VALUES ('2', '$firstname','$lastname', '$email','$password', '$address', '$city', 
	 '$postcode', '$phone', '$mobile','$fax','$active')")){
		 echo $db->affected_rows . " you have been successfully registered";
		 $db->commit();
	}
	else {
		echo $db->connect_error;
	}
	$db->close();
}

function email_exists ($email){
	
	$db = $GLOBALS['db_connect'];
	$email = sanitize ($email);
	$sql=  $db->query( "SELECT * FROM Customers WHERE Email = '$email'");
	if ($sql->num_rows){
		return true;
	} else {
		return false;
	}
	$sql->free();
	$db->close();
}

function customer_active ($email){
	$db = $GLOBALS['db_connect'];
	$email = sanitize ($email);
	$sql= $db->query("SELECT * FROM Customers WHERE Email = '$email' AND Active = 1");
	if ($sql->num_rows){
		return true;
	} else {
		return false;
	}
	$sql->free();
	$db->close();
}

function customer_id_from_customers ($email){
	$db = $GLOBALS['db_connect'];
	$email = sanitize ($email);
	$sql =  $db->query("SELECT CustomerID FROM Customers WHERE Email = '$email'");
	while ($rows = $sql->fetch_object()){
		return $rows->CustomerID;
	}
	$sql->free();
	$db->close();
}


function login ($email, $password){
	$db = $GLOBALS['db_connect'];
	$customer_id = customer_id_from_customers ($email);
	$email = sanitize ($email);
	$password = sanitize ($password);
	$sql = $db->query("SELECT * FROM Customers WHERE Email = '$email' AND Password = '$password' ");
	if ($sql->num_rows){
		return $customer_id;
	} else {
		return false;
	}
	$sql->free();
	$db->close();
}

function check_role ($email){
	$db = $GLOBALS['db_connect'];
	$sql = $db->query("SELECT * FROM Customers WHERE Email = '$email' AND RoleID = 1 ");
	if ($sql->num_rows){
		return true;
	}else {
		return false;	
	}
	$sql->free();
	$db->close();
}

function send_register_details($email_to, $first_name, $last_name, $email_from, $password ){
	$email_to ;
	$email_subject = "website html form submissions";
	$email_message .= "First Name: ".$first_name."\n";
	$email_message .= "Last Name: ".$last_name."\n";
	$email_message .= "Email: ".$email_to."\n";
	$email_message .= "Password: ".$password."\n";
	$email_message .= "\n\n\n\n\n";
	$email_message .= "Admin \n";
	$email_message .= "bakhshb@gmail.com";
	$email_from = "Admin@qualitycar.co.nz";
	// create email headers
	$headers = 'From: '.$email_from."\r\n".
	'Reply-To: '.$email_from."\r\n" .
	'X-Mailer: PHP/' . phpversion();
	@mail($email_to, $email_subject, $email_message, $headers);  
	
}

function get_all_customers (){
	
	$db = $GLOBALS['db_connect'];
	$sql=  $db->query( "SELECT CustomerID, FirstName, LastName, Email, Address, City, Mobile, Active FROM Customers");
	return $sql->fetch_all(MYSQLI_ASSOC);

	$sql->free();
	$db->close();
}

function get_order_by_id ($id){
	$db = $GLOBALS['db_connect'];
	$sql=  $db->query( "SELECT OrderID, CustomerID, Status, Subtotal FROM CustomerOrder WHERE CustomerID = '$id'");
	 if ($sql->num_rows && $sql){
		return $sql->fetch_all(MYSQLI_ASSOC);
	}else{
		return false;
	}

	$sql->free();
	$db->close();
}

function change_status($id){
	$db = $GLOBALS['db_connect'];
	$sql=  $db->query( "UPDATE CustomerOrder SET Status='Shipped' WHERE CustomerID = '$id'");
	if($db->affected_rows == 1){
		return true;
	}else{
		return false;
	}
}

function disable_customer($id){
	$db = $GLOBALS['db_connect'];
	$sql=  $db->query( "UPDATE Customers SET Active='0' WHERE CustomerID = '$id'");
	if($db->affected_rows == 1){
		return true;
	}else{
		return false;
	}
}
function active_customer($id){
	$db = $GLOBALS['db_connect'];
	$sql=  $db->query( "UPDATE Customers SET Active='1' WHERE CustomerID = '$id'");
	if($db->affected_rows == 1){
		return true;
	}else{
		return false;
	}
}
?>