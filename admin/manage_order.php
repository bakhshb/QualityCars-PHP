<?php include $_SERVER['DOCUMENT_ROOT'].'/bakhsb02/php_assignment/layer/init.php'?>
<?php 
$title="Manage Order";
$sidebar=true;
include  'includes/header.php';
?> <fieldset>
    <legend style="font-size: 20px">Customers</legend>
<table border= 1; cellspacing="0" cellpadding="4" style="background-color:White;border-color:#CC9966;border-width:1px;"  class="grdCart">
        <tr style="color:#FFFFCC;background-color:#C80000;font-weight:bold;" >
        <th></th>
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
        <td><a href="manage_order.php?id=<?php echo $customer['CustomerID'] ?>">Select</a></td>
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

<?php
if(isset($_GET['id'])){
	$id =$_GET['id'];
	if($orders = get_order_by_id ($id)){?>
     <fieldset>
    <legend style="font-size: 20px">Orders</legend>
    <table border= 1; cellspacing="0" cellpadding="4" style="background-color:White;border-color:#CC9966;border-width:1px;"  class="grdCart">
        <tr style="color:#FFFFCC;background-color:#C80000;font-weight:bold;" >
        <th>Change Status</th>
        <th>OrderID</th>
        <th>CustomerID</th>
        <th>Status</th>
        <th>Price</th>
        </tr>

<?php
		foreach ($orders as $order){?>
        <tr>
        <td><button onClick="location.href='change_status_action.php?id=<?php echo $order['CustomerID'] ?>'">Shipped</button></td>
        <td><?php echo $order['OrderID'] ?></td>
        <td><?php echo $order['CustomerID'] ?></td>
        <td><?php echo $order['Status'] ?></td>
        <td><?php echo $order['Subtotal'] ?></td>
        </tr>
<?php 
		}
	} else{
		echo"<p align='center'>There is no orders</p>";	
	}
}

?>
</table>
</fieldset>
<?php include 'includes/footer.php';?>
