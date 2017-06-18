<?php include $_SERVER['DOCUMENT_ROOT'].'/bakhsb02/php_assignment/layer/init.php'?>
<?php
if(isset($_GET['id'])){
	$id=$_GET['id'];
	if(change_status($id)){
		header("Location:manage_order.php?id=$id");

		
	}else{
		echo"<script language='javascript'>";
		echo"alert('Status is already Shipped');";
		echo"window.top.location.href='manage_order.php';";
		echo"</script>";
		exit;
	}
}else{
	echo"<script language='javascript'>";
	echo"window.top.location.href='manage_order.php';";
	echo"</script>";
	exit;
}
?>