<?php include $_SERVER['DOCUMENT_ROOT'].'/bakhsb02/php_assignment/layer/init.php'?>
<?php
if(isset($_GET['id'])){
	$id=$_GET['id'];
	if(disable_customer($id)){
		header("Location:manage_customer_account.php");

		
	}else if (active_customer($id)){
		header("Location:manage_customer_account.php");
	}
}else{
	echo"<script language='javascript'>";
	echo"window.top.location.href='manage_customer_account.php';";
	echo"</script>";
	exit;
}
?>