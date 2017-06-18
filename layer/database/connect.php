<?php

$GLOBALS['db'] = new mysqli('localhost','bakhsb02','25041986','bakhsb02mysql2' );

if ($db->connect_errno){
	echo $db->connect_error;
}

?>