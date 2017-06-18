<?php include 'layer/init.php'?>
<?php
if(admin_logged_in()){
	echo"<script language='javascript'>";
	echo"alert('Sorry, Admin cannot check out! please login as user');";
	echo"window.top.location.href='index.php';";
	echo"</script>";
	exit;
} else{
	if (register_order ()== true){
		register_order_item (get_order_id());
		header('Location:thanks.php');
	}
}
?>

