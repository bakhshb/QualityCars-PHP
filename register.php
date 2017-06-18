<?php include 'layer/init.php'?>
<?php 
error_reporting(0);
$title="Register";
$script = '
<script type="text/javascript">
function validateForm()
{
	if (document.forms["myForm"]["firstname"].value == ""){
  	document.getElementById("showSpan").innerHTML = "Filed marked with an asterisk are required!!";
	return false;
	} 
	 if (document.forms["myForm"]["lastname"].value == ""){
		document.getElementById("showSpan").innerHTML = "Filed marked with an asterisk are required!!";
	return false;
	}
	 if (document.forms["myForm"]["email"].value == ""){
		document.getElementById("showSpan").innerHTML = "Filed marked with an asterisk are required!!";
	return false;
	}
	 if (document.forms["myForm"]["password"].value == ""){
		document.getElementById("showSpan").innerHTML = "Filed marked with an asterisk are required!!";
	return false;
	}
	 if (document.forms["myForm"]["password_again"].value == ""){
		document.getElementById("showSpan").innerHTML = "Filed marked with an asterisk are required!!";
	return false;
	}
	 if (document.forms["myForm"]["password"].value != document.forms["myForm"]["password_again"].value){
		document.getElementById("showSpan").innerHTML = "Password do not match";
	return false;
	}
	 if (document.forms["myForm"]["address"].value == ""){
		document.getElementById("showSpan").innerHTML = "Filed marked with an asterisk are required!!";
	return false;
	}
	 if (document.forms["myForm"]["city"].value == ""){
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
$sidebar = false;
if(empty($_POST)=== false){
	$required_filed = array('firstname', 'lastname', ' email' ,'password','password_again', 'address', 'city', 'postcode', 'mobile', 'fax');
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
		if ($_POST['password'] !== $_POST['password_again']){
			$errors [] = 'Your password do not match' ;
		}
	}
}
if (empty($_POST) === false && empty($errors) === true){
	$register_data = array($_POST['firstname'],$_POST['lastname'],$_POST['email'], $_POST['password'], $_POST['address'], 
	$_POST['city'], $_POST['postcode'],$_POST['phone'],	$_POST['mobile'], $_POST['fax']);
	register_customer ($register_data);
	 //send email
	send_register_details($_POST['email'], $_POST['firstname'], $_POST['lastname'],$_POST['password']);
	header('Location:login.php');
	exit();
}		
?>

<?php include  'includes/header.php';?>
<?php
if (logged_in()==true){
	header('Location:index.php');
}
?>

<div class="formLayout">
  <fieldset>
    <legend style="font-size: 20px">Register Form</legend>
    <form method="post" action="" name= "myForm">
      <p>
        <label class="label"> </label>
        <label></label>
        <span id="showSpan"  style="color:Red">
        <?php if (empty($errors) === false){echo output_error($errors);}else {echo '';}?>
        </span> </p>
      <p>
        <label class="label">First Name *:</label>
        <input type="text" name="firstname"  class="inputs"  placeholder="First Name" value="<?php echo isset($_POST['firstname']) ? htmlspecialchars($_POST['firstname']) : '' ?>" />
      </p>
      <p>
        <label class="label">Last Name *:</label>
        <input type="text" name="lastname"  class="inputs"  placeholder="Last Name" value="<?php echo isset($_POST['lastname']) ? htmlspecialchars($_POST['lastname']) : '' ?>" />
      </p>
      <p>
        <label class="label">Email *:</label>
        <input type="email" name="email"  class="inputs"  placeholder="Email"/>
      </p>
      <p>
        <label class="label">Password *:</label>
        <input type="password" name="password"  class="inputs"  placeholder="Password" />
      </p>
      <p>
        <label class="label">Confirm Password *:</label>
        <input type="password" name="password_again"  class="inputs"  placeholder="Confirm Password" />
      </p>
      <p>
        <label class="label">Address *:</label>
        <input type="text" name="address"  class="inputs"  placeholder="Address" value="<?php echo isset($_POST['address']) ? htmlspecialchars($_POST['address']) : '' ?>" />
      </p>
      <p>
        <label class="label">City *:</label>
        <input type="text" name="city"  class="inputs"  placeholder="City" value="<?php echo isset($_POST['city']) ? htmlspecialchars($_POST['city']) : '' ?>" />
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
        <input type="submit" value="Submit" name="submit" class="button"  onclick="return validateForm()"/>
        <input type="reset"  value="reset" class="button"  />
      </p>
    </form>
  </fieldset>
</div>
<?php include'includes/footer.php';?>