<?php include $_SERVER['DOCUMENT_ROOT'].'/bakhsb02/php_assignment/layer/init.php'?>
<?php 
$title="Manage Order";
$sidebar=true;
include  'includes/header.php';
?> <fieldset>
    <legend style="font-size: 20px">Manage Customers</legend>
<table border= 1; cellspacing="0" cellpadding="4" style="background-color:White;border-color:#CC9966;border-width:1px;"  class="grdCart">
        <tr style="color:#FFFFCC;background-color:#C80000;font-weight:bold;" >
        <th></th>
        <th>Active</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Email</th>
        <th>Address</th>
        <th>City</th>
        <th>Mobile</th>
        </tr>
<?php
if (logged_in()==true){
	header('Location: ../error_page.php?ErrorMessage=Page not found');
} else if (admin_logged_in()==false){
	header('Location: ../error_page.php?ErrorMessage=Page not found');
}
$customers = get_all_customers();
	foreach ($customers as $customer){?>
		<tr>
        <td><button onClick="location.href='customer_action.php?id=<?php echo $customer['CustomerID'] ?>'"><?php echo $customer['Active'] == 1? "Disable": "Active"?></button></td>
        <td><?php echo $customer['Active'] == 1? "Active": "Disable"?></td>
        <td><?php echo $customer['FirstName'] ?></td>
        <td><?php echo $customer['LastName'] ?></td>
        <td><?php echo $customer['Email'] ?></td>
        <td><?php echo $customer['Address'] ?></td>
        <td><?php echo $customer['City'] ?></td>
        <td><?php echo $customer['Mobile'] ?></td>
        </tr>	
<?php	
	}
?>
</table>
</fieldset>
<?php include 'includes/footer.php';?>
