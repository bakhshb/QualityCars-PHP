<?php require_once $_SERVER['DOCUMENT_ROOT'].'/bakhsb02/php_assignment/layer/init.php'?>
<?php 
$title="Welcome to Admin Page";
$sidebar=true;
$script;
include  'includes/header.php';
?>
<?php
if (logged_in()==true){
	header('Location: ../error_page.php?ErrorMessage=Page not found');
} else if (admin_logged_in()==false){
	header('Location: ../error_page.php?ErrorMessage=Page not found');
}
?>
<h3>Welcome to the management page</h3>
<h3>Authorized account is required</h3>
<?php include 'includes/footer.php';?>
