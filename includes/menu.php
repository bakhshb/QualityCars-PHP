<?php 
$db = new mysqli('localhost','bakhsb02','25041986','bakhsb02mysql2' );

if ($db->connect_errno){
	echo $db->connect_error;
}
$sql =  $db->query("SELECT MakeID, Name FROM CarMake");
$rows = $sql->fetch_all(MYSQLI_ASSOC);
foreach ($rows as $row){
?>
<dd class="first"> <a href='index.php?makeId=<?php echo $row["MakeID"],'&name=',$row["Name"]?>'><?php echo $row["Name"]?></a> </dd><?php 
}
$db->close();?>
