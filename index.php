<?php include 'layer/init.php'?>
<?php
$title="Home";
$sidebar=true;
$css = "
 <style type='text/css'>
.CarList li {
     display: inline;
     float: left;
     margin-left: 10px;
     margin-right: 10px;
     margin-bottom: 50px;
     font-size: 10pt;
     padding: 15pt;
}

.CarList div {
     border: 1px solid #808080;
     padding: 10pt;
}
.CarList div div{
      border: none;
      text-align:center;
}

</style>

";
include'includes/header.php';
?>
<?php
if (empty($_GET['makeId'])){
	$db = $conn;
	$per_page=3;
	if ($result = $db->query("SELECT * FROM CarModel")){
		if($result->num_rows!=0){
			$total_results = $result->num_rows;
			$total_pages =ceil($total_results/ $per_page);
			if (isset($_GET['page']) && is_numeric($_GET['page'])){
				$show_page=$_GET['page'];
				if ($show_page>0 && $show_page <= $total_pages){
					$start= ($show_page-1)* $per_page;
					$end= $start + $per_page;
				} else {
					$start = 0;
					$end =$per_page;
				}
			
			} else{
				$start = 0;
				$end =$per_page;
			}
			echo "<p><b>View Page: </b> ";
			for ($i = 1 ; $i<=$total_pages; $i++){
				if (isset($_GET['page']) && $_GET['page'] == $i){
					echo "<b> ".$i." </b>";
	
				} else {
					echo "<a href='index.php?page=$i' style='text-decoration: none;'>" .$i." </a>";
				}
			}
				echo "</p>";
				
				// display the records
				for ($i = $start ; $i< $end ;$i++){
					if ($i== $total_results){ break;}
					$result->data_seek($i);
					$row=$result->fetch_row();?>

<ul class="CarList">
  <li>
    <div> <br />
      <b>Car Model: </b><?php echo $row[3]?> <br />
      <b>Year: </b> <?php echo$row[4]?> <br />
      <b>Price: $</b> <?php echo  $row[5]?> <br />
      <br />
      <img src='../uploads/PHPUpload/<?php echo $row[7]?>' align="middle" height="100" width="150" border="1" />
      <div>
        <button class="button" onclick="location.href='car_detail.php?id=<?php echo $row[0] ?>'">View</button>
        </a></div>
    </div>
  </li>
</ul>
<?php 
				}
		} else{
			echo "<p align='center'>No result to display</p>";
		}
	} else{
		echo "Error". $db->error;
		
	}
	$db->close();
}else{
	$id = $_GET['makeId'];
	$name = $_GET['name'];
	$cars = get_car_model_by_make_id($id);
	echo '
	  <legend style="font-size: 20px">
 	 	<label>',$name,'</label>
	  </legend>
	';
	foreach ($cars as $car){?>
<ul class="CarList">
  <li>
    <div> <br />
      <b>Car Model: </b><?php echo $car["Name"]?> <br />
      <b>Year: </b> <?php echo $car["Year"]?> <br />
      <b>Price: $</b> <?php echo  $car["Price"]?> <br />
      <br />
      <img src='../uploads/PHPUpload/<?php echo $car["Image"]?>' align="middle" height="100" width="150" border="1" />
      <div>
        <button class="button" onclick="location.href='car_detail.php?id=<?php echo $car["ModelID"] ?>'">View</button>
        </a></div>
    </div>
  </li>
</ul>
<?php }
echo '</fieldset>';
}
?>
<?php include'includes/footer.php';?>
