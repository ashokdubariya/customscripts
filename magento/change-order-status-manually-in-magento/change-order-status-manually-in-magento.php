<!DOCTYPE HTML>
<html>
<head>
<title>Change Order Status</title>
<body>
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once('app/Mage.php');
Mage::app('default');
$orderStatusCollection = Mage::getModel('sales/order_status')->getResourceCollection()->getData();
?>
<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
   Enter Order Increment Id :	<input type="text" name="increment_id" required /><br>
   Select Your Status:	<select name="status" required>
						   	<option value="">Select Option</option>
						   	<?php $connection = Mage::getSingleton('core/resource')->getConnection('core_read');
							$sql = "SELECT state FROM sales_order_status_state WHERE is_default = '1'";
							$rows = $connection->fetchAll($sql);
							foreach($rows as $state){ ?>
								<?php if($state['state'] != 'complete' && $state['state'] != 'closed' ) { ?>
								<option value="<?php echo $state['state']; ?>"><?php echo $state['state']; ?></option>
							<?php }
							} ?>
						<!--<option value="New">New</option>
						   	<option value="Pending Payment">Pending Payment</option>
						   	<option value="Processing">Processing</option>
						   	<option value="Closed">Closed</option>
						   	<option value="Canceled">Canceled</option>
						   	<option value="Holded">Holded</option>
						   	<option value="Payment Review">Payment Review</option> -->
	 					</select><br>
   						<input type="submit" name="submit" value="Submit"><br>
</form>
<?php
	if(isset($_POST['submit'])) 
	{ 
	    $increment_id = $_POST['increment_id'];
	    $status = $_POST['status'];
	    $_order = Mage::getModel('sales/order');
		$orderIds = $_order->getCollection()->addAttributeToSelect('*')->addAttributeToFilter('increment_id',$increment_id);
		if($orderIds->Count() == 0){
			echo "No Data Found!";
		}
		else{

			$order =  $_order->loadByIncrementId($increment_id);	
			$old_state = $order->getState();
			$old_status = $order->getStatus();
			if($status == "new"){
				$order->setState(Mage_Sales_Model_Order::STATE_NEW, true)->save();
			}
			if($status == "pending_payment"){
				$order->setState(Mage_Sales_Model_Order::STATE_PENDING_PAYMENT, true)->save();
			}
			if($status == "processing"){
				$order->setState(Mage_Sales_Model_Order::STATE_PROCESSING, true)->save();
			}
			if($status == "closed"){
				$order->setState(Mage_Sales_Model_Order::STATE_CLOSED, true)->save();
			}
			if($status == "canceled"){
				$order->setState(Mage_Sales_Model_Order::STATE_CANCELED, true)->save();
			}
			if($status == "holded"){
				$order->setState(Mage_Sales_Model_Order::STATE_HOLDED, true)->save();
			}
			if($status == "payment_review"){
				$order->setState(Mage_Sales_Model_Order::STATE_PAYMENT_REVIEW, true)->save();
			}
			//echo $status."<br /><br />";
			$new_state = $order->getState();
			$new_status = $order->getStatus();
			echo "You have requested to change status of order id :".$increment_id . "<br /><br />";
			echo "Old State : " .$old_state."<br /><br />";
			echo "Old Status : " . $old_status."<br /><br />";
			echo "New State : " . $new_state."<br /><br />";
			echo "New Status : " . $new_status."<br />";

			/*$resource = Mage::getSingleton('core/resource');
			$writeConnection = $resource->getConnection('core_write');
			$table = "order_status_change";

			$query = "INSERT INTO {$table}
						(increment_id, old_status, new_status, updated_date) 
						values('$increment_id','$old_status','$new_status',NOW())";
            $writeConnection->query($query);*/
		}
	}
?>
</body>
</html>