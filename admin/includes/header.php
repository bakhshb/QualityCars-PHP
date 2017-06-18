<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo $title;?></title>
<link href="style/style.css" rel="stylesheet" type="text/css" />
<link href="images/tab-logo.png" rel="Shortcut Icon" type="image/png" />
<?php 
	if (isset($css)){
		echo $css;
	}
	if (isset($script)){
		echo $script;
	}
	?>
</head>
<body>
<div id="wrapper">
<div id="inner">
<div id="header">
  <h1><img src="images/logo.gif" width="519" height="63" alt="Online Store" /></h1>
  <div id="nav"> <a href="index.php">Admin Home</a>|<a href="../index.php">Main Page</a>| <?php get_customer_name($db); ?>
    <?php if (admin_logged_in ()== true )  { ?>
    <a href="#" onclick="var r= confirm('Would you like to logout?'); if(r==true){location.href='../logout.php'}">Logout</a>
    <?php } else {?>
    <a href="../login.php">Login</a>
    <?php }?>
  </div>
  <!-- end nav --> 
  <a href=#"><img src="images/header.jpg" width="1000" height="193" /></a> </div>
<!-- end header -->
<dl id="browse" <?php echo ($sidebar ? 'style="display:block"' : 'style="display:none"')?>>
  <dt>Full Category Lists</dt>
  <?php include 'menu.php';?>
</dl>
<div id="body"  <?php echo ($sidebar ? 'style="width: 790px;"' : 'style="width: 100%;"')?>>
<div class="inner">
