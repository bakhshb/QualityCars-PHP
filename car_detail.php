<?php include 'layer/init.php'?>
<?php 
$title="Car Detail";
$sidebar = true;
$css = "
<style type='text/css'>
#holder{
  margin:0;
  padding:0;
  height:500px;
}
#image{
  float:left;
  margin:10px;
  width:350px;
  height:350px;
  border: 1px solid #808080;
}
#detailcontainer{
  float:left;
  margin-left:20px;
  width: 350px;
}
#title {
  font-size:35px;
  text-align:center;
  padding:10px;
}
#detail{
  font-size:16px;
  text-align:left;
  padding:10px;
}
#detail div {
   text-align:center;
}
#desc{
   clear:both;
   width:740px;
   font-size:15px;
   text-align:left;
   padding:15px;
}
</style>

";
include'includes/header.php';
?>
<?php 
if (isset($_GET['id'])){
	$id=$_GET['id'];
	if ($models =get_car_model_id ($id)){
	foreach ($models as $model){?>

<div id="holder">
  <div id="image"> <img src='../uploads/PHPUpload/<?php echo $model["Image"]?>'  Width="350px" Height="350px"/> </div>
  <div id="detailcontainer">
    <div id="title">
      <?php
	  $makes = get_car_make_by_id ($model["MakeID"]);
	  foreach ($makes as $make){
	   echo '
        <label>',$make["Name"],'</label> ';
	  }
        ?>
    </div>
    <div id="detail">
      <label style="font-weight:bold">Model Name:</label>
      &nbsp;&nbsp;
      <label><?php echo $model["Name"]?></label>
      <br />
      <br />
      <label style="font-weight:bold">Year:</label>
      &nbsp;&nbsp;
      <label><?php echo $model["Year"]?></label>
      <br />
      <br />
      <label style="font-weight:bold">Price: $</label>
      &nbsp;&nbsp;
      <label><?php echo $model["Price"]?></label>
      <br />
      <br />
      <div>
        <button class="button" onclick="location.href='shopping_cart.php?action=add&id=<?php echo $model["ModelID"] ?>' ">Add to Cart </button>
      </div>
    </div>
  </div>
  <div id="desc">
    <label>Description:</label>
    <br />
    <label><?php echo $model["Description"];?></label>
  </div>
</div>
<?php }
	}else {
		echo"<script language='javascript'>";
		echo"window.top.location.href='error_page.php?ErrorMessage=Page not found';";
		echo"</script>";
		exit;
	}
} else {
	echo"<script language='javascript'>";
	echo"window.top.location.href='error_page.php?ErrorMessage=Page not found';";
	echo"</script>";
	exit;
}
?>
<?php include'includes/footer.php';?>