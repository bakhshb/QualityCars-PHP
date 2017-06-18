<?php include 'layer/init.php'?>
<?php 
error_reporting(0);
$title="Shopping Cart";

if ((!admin_logged_in())&& (!logged_in())){
	header('Location:login.php');
} 

if (isset($_SESSION['cart'])){
	$cart = $_SESSION['cart'];
}
if (isset($_GET['action'])){
	$action = $_GET['action'];
	switch ($action) {
		case 'add':
		if (isset($cart) && $cart!='') {
				$cart .= ','.$_GET['id'];
			} else {
				$cart = $_GET['id'];
			}
			break;
		case 'empty':
		$cart=null;
			break;
		default:	
		echo"<script language='javascript'>";
		echo"window.top.location.href='error_page.php?ErrorMessage=Page not found';";
		echo"</script>";
		exit;
	}
}
$_SESSION['cart'] = $cart;
?>
<?php include'includes/header.php';?>
<?php
echo show_cart();
?>

<?php include'includes/footer.php';?>