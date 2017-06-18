<?php include $_SERVER['DOCUMENT_ROOT'].'/bakhsb02/php_assignment/layer/init.php'?>
<?php 
$title="Add Supplier";
$sidebar=true;
$script = '
<script type="text/javascript">
function validateForm()
{
	if (document.forms["myForm"]["name"].value == ""){
  	document.getElementById("showSpan").innerHTML = "Filed marked with an asterisk are required!!";
	return false;
	} 
	 if (document.forms["myForm"]["email"].value == ""){
		document.getElementById("showSpan").innerHTML = "Filed marked with an asterisk are required!!";
	return false;
	}
	 if (document.forms["myForm"]["address"].value == ""){
		document.getElementById("showSpan").innerHTML = "Filed marked with an asterisk are required!!";
	return false;
	}
	 if ((document.forms["myForm"]["postcode"].value == "") || (isNaN( document.forms["myForm"]["postcode"].value))){
		document.getElementById("showSpan").innerHTML = "Please provide a valid Postcode number";
	return false;
	} else if (document.forms["myForm"]["postcode"].value.length != 4){
		document.getElementById("showSpan").innerHTML = "Postcode format ####";
	return false;
	}
	if ((document.forms["myForm"]["phone"].value != "") && (isNaN( document.forms["myForm"]["phone"].value)) ){
		document.getElementById("showSpan").innerHTML = "Please provide a valid phone number";
	return false;
	} else if (document.forms["myForm"]["phone"].value != "" && document.forms["myForm"]["phone"].value.length != 10 ){
		document.getElementById("showSpan").innerHTML = "Phone format 02########";
	return false;
	} 
	
	 if ((document.forms["myForm"]["mobile"].value == "") || (isNaN( document.forms["myForm"]["mobile"].value)) ){
		document.getElementById("showSpan").innerHTML = "Please provide a valid mobile number";
	return false;
	} else if (document.forms["myForm"]["mobile"].value.length != 10 ){
		document.getElementById("showSpan").innerHTML = "Mobile format 027#######";
	return false;
	} 
	 if ((document.forms["myForm"]["fax"].value == "" ) || (isNaN( document.forms["myForm"]["fax"].value))){
		document.getElementById("showSpan").innerHTML = "Please provide a valid fax number";
	return false;
	} else if (document.forms["myForm"]["fax"].value.length != 10 ){
		document.getElementById("showSpan").innerHTML = "Fax format 02########";
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
	$required_filed = array('name', ' email', 'address', 'postcode', 'mobile', 'fax');
	foreach ($_POST as $key =>$value){
		if (empty($value) && in_array($key, $required_filed) === true){
			//$errors [] = 'Filed marked with an asterisk are required!!' ;
			break 1;
		}
	}
	if (empty($errors) === true){
		if (email_exists($_POST['email'])===true) {
			$errors [] = 'Sorry, Email is already exists!!' ;
		}
	}
}
if (empty($_POST) === false && empty($errors) === true){
	//register_customer($register_data);
	$register_data = array($_POST['name'],$_POST['email'], $_POST['address'], $_POST['postcode'],
						$_POST['phone'],$_POST['mobile'], $_POST['fax']);								
	register_supplier ($register_data);
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
    <legend style="font-size: 20px">Add Supplier</legend>
    <form method="post" action="" name="myForm">
      <p>
        <label class="label"> </label>
        <label></label>
        <span id="showSpan"  style="color:Red">
        <?php if (empty($errors) === false){echo output_error($errors);}else {echo '';}?>
        </span> </p>
      <p>
        <label class="label"> Name *:</label>
        <input type="text" name="name"  class="inputs"  placeholder="Name" value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : '' ?>" />
      </p>
      <p>
        <label class="label">Email *:</label>
        <input type="email" name="email"  class="inputs"  placeholder="Email" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>" />
      </p>
      <p>
        <label class="label">Address *:</label>
        <input type="text" name="address"  class="inputs"  placeholder="Address" value="<?php echo isset($_POST['address']) ? htmlspecialchars($_POST['address']) : '' ?>" />
      </p>
      <p>
        <label class="label">PostCode *:</label>
        <input type="text" name="postcode"  class="inputs"  placeholder="PostCode" value="<?php echo isset($_POST['postcode']) ? htmlspecialchars($_POST['postcode']) : '' ?>"/>
      </p>
      <p>
        <label class="label">Phone:</label>
        <input type="text" name="phone"  class="inputs"  placeholder="phone" value="<?php echo isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : '' ?>"/>
      </p>
      <p>
        <label class="label">Mobile *:</label>
        <input type="text" name="mobile"  class="inputs"  placeholder="Mobile" value="<?php echo isset($_POST['mobile']) ? htmlspecialchars($_POST['mobile']) : '' ?>"/>
      </p>
      <p>
        <label class="label">Fax *:</label>
        <input type="text" name="fax"  class="inputs"  placeholder="Fax" value="<?php echo isset($_POST['fax']) ? htmlspecialchars($_POST['fax']) : '' ?>"/>
      </p>
      <p>
        <label class="label"> </label>
        <input type="submit" value="Submit" name="submit" class="button" onclick="return validateForm()" />
        <input type="reset"  value="reset" class="button"  />
      </p>
    </form>
  </fieldset>
</div>
<?php include 'includes/footer.php';?>
