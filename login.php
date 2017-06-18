<?php include 'layer/init.php'?>
<?php 
$title="Login";
$script = '
<script type="text/javascript">
function validateForm()
{
	if (document.forms["myForm"]["email"].value == ""){
  	document.getElementById("showSpan").innerHTML = "You need to enter email and password!!";
	return false;
	}
	if (document.forms["myForm"]["password"].value == ""){
  	document.getElementById("showSpan").innerHTML = "You need to enter email and password!!";
	return false;
	}
}
</script>
';
$sidebar = false;
include  'includes/header.php';
?>
<?php

if ((admin_logged_in())|| (logged_in())){
	header('Location:index.php');
} 
if(empty($_POST)=== false){
	$email = $_POST['email'];
	$password = $_POST['password'] ;
	if (empty($email) || empty($password)){
	//	$errors[]='You need to enter email and password!!';
	} else if (email_exists($email)== false){
		$errors[]='We can\'t find that email. Have you registered?';
	} else if (customer_active($email) == false){
		$errors[]='You haven\'t activated your account';
	} else {
		$login = login($email, $password);
		if ($login === false){
			$errors[]='Email or password isn\'t correct!!';
		} else {
			if (check_role($email)==true){
				$_SESSION['admin'] = $login;
				header('Location: admin/index.php');
				exit();
			} else {
				$_SESSION['customer_id'] = $login;
				if (isset($_SESSION['cart'])){
					header('Location: shopping_cart.php');
					exit();
				}else{
					header('Location: index.php');
					exit();
				}
			}
		}
	} 
} 
?>

<div class="formLayout">
  <fieldset>
    <legend style="font-size: 20px">Login</legend>
    <form method="post" action=""  name= "myForm">
      <p>
        <label class="label"> </label>
        <label></label>
        <span id="showSpan"  style="color:Red">
        <?php if (empty($errors) === false){echo output_error($errors);}else {echo '';}?>
        </span> </p>
      <p>
        <label class="label">Email:</label>
        <input type="email" name="email"  class="inputs"  placeholder="Email" >
      </p>
      <p>
        <label class="label">Password:</label>
        <input type="password" name="password"  class="inputs"  placeholder="Password">
      </p>
      <p>
        <label class="label"> </label>
        <input type="submit" name="submit" value="Login" class="button" onclick="return validateForm()">
        <a href="register.php" style="font-size:16px; padding-left:10px;"> Register Now</a> </p>
    </form>
  </fieldset>
</div>
<?php include'includes/footer.php';?>