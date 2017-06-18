<?php include 'layer/init.php'?>
<?php 
error_reporting(0);
$title="Contact Us";
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
	 if (document.forms["myForm"]["subject"].value == ""){
		document.getElementById("showSpan").innerHTML = "Filed marked with an asterisk are required!!";
	return false;
	}
	if (document.forms["myForm"]["comments"].value == ""){
		document.getElementById("showSpan").innerHTML = "Filed marked with an asterisk are required!!";
	return false;
	}
}
</script>
';
$sidebar = false;
include'includes/header.php';
?>
<?php
if(empty($_POST)=== false){
	$required_filed = array('firstname', 'lastname', ' email' , 'subject', 'comments');
	foreach ($_POST as $key =>$value){
		if (empty($value) && in_array($key, $required_filed) === true){
			//$errors [] = 'Filed marked with an asterisk are required!!' ;
			break 1;
		}
	}
}
if (empty($_POST) === false && empty($errors) === true){
	 $email_to = "bakhshb@gmail.com";
	 $first_name = $_POST['firstname'];
	 $last_name = $_POST['lastname'];
	 $email_from=  $_POST['email'];
	 $subject=  $_POST['subject'];
	 $comments=  $_POST['comments'];
	contact_us_email( $email_to, $first_name, $last_name, $email_from, $subject,$comments );
	?>
    <script type="text/javascript">
	alert("Thanks for contacting us. We will try to reply to you as soon as possible!!");
	location.href = 'index.php';
	</script>
    <?php
	exit();
}


?>

<div class="formLayout">
  <fieldset>
    <legend style="font-size: 20px">Contect Form</legend>
    <form method="post" action="" name= "myForm">
      <p>
        <label class="label"> </label>
        <label></label>
        <span id="showSpan"  style="color:Red"> </span> </p>
      <p>
        <label class="label">First Name *:</label>
        <input type="text" name="firstname"  class="inputs"  placeholder="First Name" />
      </p>
      <p>
        <label class="label">Last Name *:</label>
        <input type="text" name="lastname"  class="inputs"  placeholder="Last Name" />
      </p>
      <p>
        <label class="label">Email *:</label>
        <input type="email" name="email"  class="inputs"  placeholder="Email" />
      </p>
      <p>
        <label class="label">Subject *:</label>
        <input type="text" name="subject"  class="inputs"  placeholder="Subject" />
      </p>
      <p>
        <label class="label">Comment *:</label>
        <label class="label"> </label>
      </p>
      <p>
        <label class="label"></label>
        <textarea  name="comments" placeholder="Comments" style="border: 3px solid #EBE6E2; border-radius: 5px;  "  maxlength="1000" cols="25" rows="6"></textarea>
      </p>
      <p>
        <label class="label"> </label>
        <input type="submit" value="Submit" name="submit" class="button" onclick="return validateForm()"/>
        <input type="reset"  value="reset" class="button"  />
      </p>
    </form>
  </fieldset>
</div>
<?php include'includes/footer.php';?>
