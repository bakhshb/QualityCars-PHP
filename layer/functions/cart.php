<?php 
function show_cart(){
	$db = $GLOBALS['db_connect'];
	$cart = $_SESSION['cart'];
	if ($cart) {
		$items = explode(',',$cart);
		$contents = array();
		$total = 0;
		foreach ($items as $item) {
			$contents[$item] = (isset($contents[$item])) ? $contents[$item] + 1 : 1;
		}
		$output[] = '<table border= 1; cellspacing="0" cellpadding="4" style="background-color:White;border-color:#CC9966;border-width:1px;"  class="grdCart">';
		$output[]='<tr style="color:#FFFFCC;background-color:#C80000;font-weight:bold;" >';
		$output[]=' <th>Car ID</th><th>Car Model</th> <th>Qunatity</th><th>Price</th><th>Subtotal</th> </tr>';
		foreach ($contents as $id=>$quantity){
			$sql = $db->query ("SELECT * FROM CarModel WHERE ModelID = '$id'");
			if ($sql->num_rows>0){
				while ($rows = $sql->fetch_object()){
					$output[]='<tr>';
					$output[]= '<td>'.$rows->ModelID.'</td>';
					$output[]='<td>'.$rows->Name.'</td>';
					$output[]='<td>'.$quantity.'</td>';
					$output[]='<td>'.$rows->Price.'</td>';
					$output[]='<td>'.$rows->Price*$quantity.'</td>';
					$output[]='</tr>';
					$total += $rows->Price*$quantity;
				}
				$gst = ($total *.15)+$total;
			}
		}
		$output[]='</table>';
		$output[]='<div style="text-align: right; background-color: #c80000; margin-left: 100px; width: 800px; height: 50px; font-size: 14px; font-weight: bold; color: White;">';
		$output[]='<label>OrderTotal: $ </label><label name="total">'.$total.'</label><br/>';
        $output[]='<label>GST 15%: $ </label><label name="GST"></label>'.$gst.'</div>';
		$output[]='<div style=" float:right; margin-top: 20px; margin-right:80px; font-size:15px;">';
		$output[]='<button onclick="var r=confirm(\'Are you sure?\'); if(r==true){location.href=\'shopping_cart.php?action=empty\'}" class="button">Empty Cart</button></div>';
		$output[]='<div style="float:right; clear:both; margin-top: 20px; margin-bottom:20px; margin-right:75px;">';
		$output[]='<button class="button" onclick="location.href=\'index.php\'" style="width:160px;margin-right:20px;">Continue Shopping</button>';
		$output[]='<button onclick="var r= confirm(\'Would you like to check out?\'); if (r== true){location.href=\'order_action.php\'}" class="button" style="background-color:orange;">Check Out</button></div>';
	} else {
		$output[]= '<p align="center">You have no items in your shopping cart. <a href="#" onclick="location.href=\'index.php\'" >Go to the store<a></p>' ;
	}
	return join('', $output);
}


function count_cart_item (){
	$count = 0;
	if (isset($_SESSION['cart']))
	{
	$cart = $_SESSION['cart'];
	}
	if (!isset($cart) || $cart=='') {
		echo 'Cart ('. $count.')';
	} else {
		// Parse the cart session variable
		$items = explode(',',$cart);
		echo 'Cart ('.count($items).')';
	}
}

function register_order (){
	$db = $GLOBALS['db_connect'];
	$cart = $_SESSION['cart'];
	if ($cart) {
		$items = explode(',',$cart);
		$contents = array();
		$total = 0;
		foreach ($items as $item) {
			$contents[$item] = (isset($contents[$item])) ? $contents[$item] + 1 : 1;
		}
		foreach ($contents as $id=>$quantity){
			$sql = $db->query ("SELECT * FROM CarModel WHERE ModelID = '$id'");
			if ($sql->num_rows>0){
				while ($rows = $sql->fetch_object()){
					
					$total += $rows->Price*$quantity;
					
				}
				$subtotal = $total;
			}
		}
		$customer_id = $_SESSION['customer_id'];
		$status = "Waiting";
		$db->autocommit(false);
		if ($insert=  $db->query ("INSERT INTO CustomerOrder (CustomerID, Status, Subtotal) VALUES ('$customer_id', '$status','$subtotal')")){
			// echo $db->affected_rows + "your order has been successfully made";
			 $db->commit();
			 return true;
		}
		else {
			echo $db->connect_error;
			return false;
		}
	}
	$sql->free();
	$db->close();
}

function get_order_id(){
	$db = $GLOBALS['db_connect'];
	if(isset($_SESSION['customer_id'])){
		$customer_id = $_SESSION['customer_id'];
		$sql = $db->query("SELECT * FROM CustomerOrder Where CustomerID = '$customer_id' ");
		while ($rows = $sql->fetch_object()){
			return $rows->OrderID;
		}
	}
	if(isset($_SESSION['admin'])){
		$customer_id = $_SESSION['admin'];
		$sql = $db->query("SELECT * FROM CustomerOrder Where CustomerID = '$customer_id' ");
		while ($rows = $sql->fetch_object()){
			return $rows->OrderID;
		}
	}
	$db->close();
}

function register_order_item ($id){
	$db = $GLOBALS['db_connect'];
	$order_id = $id;
	$cart = $_SESSION['cart'];
	if ($cart) {
		$items = explode(',',$cart);
		$contents = array();
		$total = 0;
		foreach ($items as $item) {
			$contents[$item] = (isset($contents[$item])) ? $contents[$item] + 1 : 1;
		}
		
		foreach ($contents as $id=>$quantity){
			$sql = $db->query ("SELECT * FROM CarModel WHERE ModelID = '$id'");
			if ($sql->num_rows>0){
				while ($rows = $sql->fetch_object()){
					$db->autocommit(false);
					$subtotal = $rows->Price * $quantity;
					if ($insert=  $db->query ("INSERT INTO CustomerOrderItem (OrderID, ModelID, Quantity, Price) VALUES ('1', '$rows->ModelID','$quantity', '$subtotal')")){
					// echo $db->affected_rows + "your order hase been successfully made";
					 $db->commit();
					 send_order_details( );
					 unset($_SESSION['cart']);
					}
					else {
						echo $db->connect_error;
					} 
					
				}
			}
		}
	}
	$db->close();
}

function send_order_details( ){
	
	$db = $GLOBALS['db_connect'];
	if(isset($_SESSION['customer_id'])){
		$id = $_SESSION['customer_id'];
		$sql=  $db->query( "SELECT Email FROM Customers WHERE CustomerID = '$id' ");
		$rows= $sql->fetch_all(MYSQLI_ASSOC);
		foreach ($rows as $row){
			 $email_to = $row['Email'];
		}
	} 
	// CHANGE THE TWO LINES BELOW
	$email_subject = 'Shopping Details';
	$email_message= '<html><body>';
	$email_message.='Hi '.get_customer_name($id). ',';
	$email_message.='Here is a summary of your recent order.Thank you for shopping on Quality Car! ';
	$email_message.= '<table border= 1; cellspacing="0" cellpadding="4" style="background-color:White;border-color:#CC9966;border-width:1px;"  class="grdCart">';
	$email_message.='<tr style="color:#FFFFCC;background-color:#C80000;font-weight:bold;" >';
	$email_message.=' <th>Car ID</th><th>Car Model</th> <th>Qunatity</th><th>Price</th><th>Subtotal</th> </tr>';
	$cart = $_SESSION['cart'];
	if ($cart) {
		$items = explode(',',$cart);
		$contents = array();
		$total = 0;
		foreach ($items as $item) {
			$contents[$item] = (isset($contents[$item])) ? $contents[$item] + 1 : 1;
		}
		foreach ($contents as $id=>$quantity){
			$sql = $db->query ("SELECT * FROM CarModel WHERE ModelID = '$id'");
			if ($sql->num_rows>0){
				while ($rows = $sql->fetch_object()){
				$email_message.='<tr>';
				$email_message.= '<td>'.$rows->ModelID.'</td>';
				$email_message.='<td>'.$rows->Name.'</td>';
				$email_message.='<td>'.$quantity.'</td>';
				$email_message.='<td>'.$rows->Price.'</td>';
				$email_message.='<td>'.$rows->Price*$quantity.'</td>';
				$email_message.='</tr>';
				}
			}
		}
	}
	$email_message.='</table>';
	$email_message.='<p>Admin</p>';
	$email_message.='<p>bakhshb@gmail.com</p>';
	$email_message.='</body></html>';
	$email_from = 'Admin@qualitycar.co.nz';
	$headers = "From: ".$email_from ."\r\n". 
               "MIME-Version: 1.0" . "\r\n" . 
               "Content-type: text/html; charset=UTF-8" . "\r\n" ; 
	@mail($email_to, $email_subject, $email_message, $headers);  
}

?>
