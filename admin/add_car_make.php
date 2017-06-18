<?php include $_SERVER['DOCUMENT_ROOT'].'/bakhsb02/php_assignment/layer/init.php'?>
<?php 
$title="Add Car Make";
$sidebar=true;
$script = '
<script type="text/javascript">
function validateForm()
{
	var x=document.forms["myForm"]["name"].value;
	if (x == ""){
  	document.getElementById("showSpan").innerHTML = "Filed marked with an asterisk are required!!";
	return false;
	}
}
</script>
';
include  'includes/header.php';
?>
<?php
if (logged_in()==true){
	header('Location: ../error_page.php?ErrorMessage=Page not found');
} else if (admin_logged_in()==false){
	header('Location: ../error_page.php?ErrorMessage=Page not found');
}
if(empty($_POST)=== false){
	if (empty($_POST['name'])){
		//$errors [] = 'Filed marked with an asterisk are required!!' ;
	}
}
if (empty($_POST) === false && empty($errors) === true){
	$make_name = $_POST['name'];
	register_car_make($make_name);
	?>
    <script type="text/javascript">
	alert("it was successfully added to database");
	location.href = 'index.php';
	</script>
    <?php
	exit();		
}

?>

<div class="formLayout">
  <fieldset>
    <legend style="font-size: 20px">Add Car Make</legend>
    <form name= "myForm" method="post" action="">
      <p>
        <label class="label"> </label>
        <label></label>
        <span id="showSpan"  style="color:Red"></span> </p>
      <p>
        <label class="label">Name *:</label>
        <input type="text"  name="name"   class="inputs"  placeholder="Name" value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : '' ?>" />
      <p>
        <label class="label"> </label>
        <input type="submit" value="Submit" id= "submit" name="submit" class="button" onclick="return validateForm()"  />
        <input type="reset"  value="reset"  class="button"  />
      </p>
    </form>
  </fieldset>
</div>
<?php include 'includes/footer.php';?>
