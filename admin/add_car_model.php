<?php include $_SERVER['DOCUMENT_ROOT'].'/bakhsb02/php_assignment/layer/init.php'?>
<?php 
$title="Add Car Model";
$sidebar=true;
$script = '
<script type="text/javascript">
function validateForm()
{
	var current_year=new Date().getFullYear();
	if (document.forms["myForm"]["make"].value == "Select Car Make"){
  	document.getElementById("showSpan").innerHTML = "Please Select Car Make";
	return false;
	}
	if (document.forms["myForm"]["supplier"].value == "Select Supplier"){
  	document.getElementById("showSpan").innerHTML = "Please Select Supplier";
	return false;
	}
	if (document.forms["myForm"]["name"].value == ""){
  	document.getElementById("showSpan").innerHTML = "Filed marked with an asterisk are required!!";
	return false;
	}
	if ((document.forms["myForm"]["year"].value == "") || (isNaN( document.forms["myForm"]["year"].value))){
  	document.getElementById("showSpan").innerHTML = "Please enter a valid year Price";
	return false;
	} else if (document.forms["myForm"]["year"].value.length != 4 ){
		document.getElementById("showSpan").innerHTML = "Year format ####";
	return false;
	}  else if (document.forms["myForm"]["year"].value > current_year || document.forms["myForm"]["year"].value < 2000){
		document.getElementById("showSpan").innerHTML = "Year should be in range 1920 to current year";
	return false;
	}  
	if ((document.forms["myForm"]["price"].value == "") || (isNaN( document.forms["myForm"]["price"].value))){
  	document.getElementById("showSpan").innerHTML = "Please enter a valid number";
	return false;
	}
	if (document.forms["myForm"]["file"].value == ""){
  	document.getElementById("showSpan").innerHTML = "Please upload an image";
	return false;
	}
	if (document.forms["myForm"]["comments"].value == ""){
  	document.getElementById("showSpan").innerHTML = "Filed marked with an asterisk are required!!";
	return false;
	}
	 var allowedExtension = ["jpeg", "jpg", "png", "gif", "bmp"];
	 var fileExtension = document.getElementById("file").value.split(".").pop().toLowerCase();
	 var isValidFile = false;
	 for(var index in allowedExtension) {
		 if(fileExtension === allowedExtension[index]) {
			 isValidFile = true; 
			  break;
		 }
	 }
	 if(!isValidFile) {
		 alert("Allowed Extensions are : *." + allowedExtension.join(", *."));
		 document.getElementById("showSpan").innerHTML = "";
		 return false;
	 }
	 return isValidFile;
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
	$required_filed = array('name','price', 'year','comments');
	foreach ($_POST as $key =>$value){
		if (empty($value) && in_array($key, $required_filed) === true){
			//$errors [] = 'Filed marked with an asterisk are required!!' ;
			break 1;
		}
	}
	if (empty($errors) === true){
		if (isset($_FILES["file"]) && ($_FILES["file"]["error"] > 0)){
			$errors [] = "Error: " . $_FILES["file"]["error"] ;
		}
		if (($_POST['make'] == "Select Car Make" )|| ($_POST['supplier'] == "Select Supplier")){
			$errors [] = 'Filed marked with an asterisk are required!!' ;
		}
	}
}
if (empty($_POST) === false && empty($errors) === true){
			
				
	//register_customer($register_data);
	if (isset ($_FILES["file"]["name"])) {
		move_uploaded_file($_FILES["file"]["tmp_name"],"../../uploads/PHPUpload/" . $_FILES["file"]["name"]);
		echo "Stored in: " . "upload/" . $_FILES["file"]["name"] . "<br>";
	}
	$model_data = array($_POST['make'],$_POST['supplier'],$_POST['name'], $_POST['year'],$_POST['price'],
										$_FILES['file']['name'], $_POST['comments']);
										
	register_car_model ($model_data);
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
    <legend style="font-size: 20px">Add Car Model</legend>
    <form name= "myForm" method="post" action="" enctype="multipart/form-data">
      <p>
        <label class="label"> </label>
        <label></label>
        <span id="showSpan"  style="color:Red">
        <?php if (empty($errors) === false){echo output_error($errors);}else {echo '';}?>
        </span> </p>
      <p>
        <label class="label"> Make *:</label>
        <select class="inputs" name="make">
          <option>Select Car Make</option>
          <?php 
		if ($makes = get_car_make ()){
			foreach ($makes as $make){
				echo '<option value="'.$make["MakeID"].'">'.$make["Name"].'</option>';
			}
			
		}
		 
		?>
        </select>
      </p>
      <p>
        <label class="label">Supplier *:</label>
        <select class="inputs" name="supplier" >
          <option>Select Supplier</option>
          <?php 
		if ($suppliers = get_suppliers ()){
			foreach ($suppliers as $supplier){
				echo '<option value="'.$supplier["SupplierID"].'">'.$supplier["Name"].'</option>';
			}
		}
		 
		?>
        </select>
      </p>
      <p>
        <label class="label">Name *:</label>
        <input type="text" name="name"  class="inputs"  placeholder="Name" value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : '' ?>" />
      </p>
      <p>
        <label class="label">Year *:</label>
        <input type="text" name="year"  class="inputs"  placeholder="Year" value="<?php echo isset($_POST['year']) ? htmlspecialchars($_POST['year']) : '' ?>" />
      </p>
      <p>
        <label class="label">Price *:</label>
        <input type="text" name="price"  class="inputs"  placeholder="Price" value="<?php echo isset($_POST['price']) ? htmlspecialchars($_POST['price']) : '' ?>"/>
      </p>
      <p>
        <label class="label">Image *:</label>
        <input type="file" name="file"  id="file" class="inputs"  />
      </p>
      <p>
        <label class="label">Description *:</label>
        <label class="label"> </label>
      </p>
      <p>
        <label class="label"> </label>
        <textarea  name="comments" placeholder="Description" style="border: 3px solid #EBE6E2; border-radius: 5px;  "  maxlength="1000" cols="25" rows="6"  ></textarea>
      </p>
      <p>
        <label class="label"> </label>
        <input type="submit" value="Submit" name="submit" class="button" onclick="return validateForm()"/>
        <input type="reset"  value="reset" class="button"  />
      </p>
    </form>
  </fieldset>
</div>
<?php include 'includes/footer.php';?>
