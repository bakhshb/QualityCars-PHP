<?php include 'layer/init.php'?>
<?php 
$title="Order History";
include  'includes/header.php';
?>

<fieldset>
<legend style="font-size: 20px">Orders History</legend>
<table border= 1; cellspacing="0" cellpadding="4" style="background-color:White;border-color:#CC9966;border-width:1px;"  class="grdCart">
<?php 

$id=$_SESSION['customer_id'];
if($orders = get_order_by_id ($id)){
?>
<tr style="color:#FFFFCC;background-color:#C80000;font-weight:bold;" >
  <th>OrderID</th>
  <th>CustomerID</th>
  <th>Status</th>
  <th>Price</th>
</tr>
<?php
	foreach ($orders as $order){?>
        <tr>
        <td><?php echo $order['OrderID'] ?></td>
        <td><?php echo $order['CustomerID'] ?></td>
        <td><?php echo $order['Status'] ?></td>
        <td><?php echo $order['Subtotal'] ?></td>
        </tr>
<?php }
}
?>
</table>
<br />
<button class="button" onclick="location.href='index.php'" style="width:120px;margin-right:20px; float:right;">Go Back</button>
</fieldset>
<?php include'includes/footer.php';?>