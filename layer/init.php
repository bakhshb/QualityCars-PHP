<?php
session_start();
require_once('database/connect.php');
require_once('functions/general.php');
require_once('functions/customers.php');
require_once('functions/cars.php');
require_once('functions/suppliers.php');
require_once('functions/cart.php');
$errors = array();

$GLOBALS['db_connect'] = $db;
$conn = $GLOBALS['db_connect'];
?>