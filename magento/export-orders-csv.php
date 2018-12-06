<?php
// https://stackoverflow.com/questions/19922563/exporting-order-details-magento
error_reporting(E_ALL);
ini_set("memory_limit", "100000M");

require_once('app/Mage.php'); //Path to Magento
umask(0);
Mage::app("default");
Mage::init();

// Set an Admin Session
Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);
Mage::getSingleton('core/session', array('name' => 'adminhtml'));
$userModel = Mage::getModel('admin/user');
$userModel->setUserId(1);
$session = Mage::getSingleton('admin/session');
$session->setUser($userModel);
$session->setAcl(Mage::getResourceModel('admin/acl')->loadAcl());

$connection = Mage::getSingleton('core/resource')->getConnection('core_write');

$fromDate = date('Y-m-d H:i:s', strtotime('2018-01-01'));
$toDate = date('Y-m-d H:i:s', strtotime('2019-01-01'));

/* Get orders collection of pending orders, run a query */
$collection = Mage::getModel('sales/order')
    ->getCollection()
//      ->addFieldToFilter('state',Array('eq'=>Mage_Sales_Model_Order::STATE_NEW))
    ->addAttributeToSelect('*');
    //->addAttributeToFilter('created_at', array('from' => $fromDate, 'to' => $toDate));
//    ->setPageSize(2)
//    ->setCurPage(1);

$data[0] = array(
    'Order ID',
    'Status',
    'Shipping description',
    'Grand Total',
    'Total Qty Ordered',
    'Customer First name',
    'Customer Last name',
    'Customer Email',
    'Created At',
    'Billing Company',
    'Billing Name',
    'Billing City',
    'Billing Street',
    'Billing POST Code',
    'Shipping Company',
    'Shipping Name',
    'Shipping City',
    'Shipping Street',
    'Shipping POST Code',
    'Item Name',
    'Qty Ordered',
    'Price',
    'Product SKU'
);
$counter = 0;
foreach ($collection as $order) {
	$counter++;

    if ($billingAddress = $order->getBillingAddress()) {
        $billingStreet = $billingAddress->getStreet();
    }
    if ($shippingAddress = $order->getShippingAddress()) {
        $shippingStreet = $shippingAddress->getStreet();
    }

    $orderData = array(
        $order->getIncrementId(),
        $order->getStatus(),
        $order->getShippingDescription(),
        $order->getGrandTotal(),
        $order->getTotalQtyOrdered(),
        $order->getCustomerFirstname(),
        $order->getCustomerLastname(),
        $order->getCustomerEmail(),
        date('Y-m-d', strtotime($order->getCreatedAt())),
        $billingAddress->getCompany(),
        $billingAddress->getName(),
        $billingAddress->getCity(),
        $billingStreet[0],
        $billingAddress->getPostcode(),
        $shippingAddress->getCompany(),
        $shippingAddress->getName(),
        $shippingAddress->getCity(),
        $shippingStreet[0],
        $shippingAddress->getPostcode(),

    );


    foreach ($order->getAllItems() as $itemId => $item) {

        $item_name = str_replace('&', " ", $item->getName());
        $itemData = array(
            $item_name,
            $item->getQtyOrdered(),
            $item->getPrice(),
            $item->getSku()
        );

        $data[] = array_merge($orderData, $itemData);
    }

if($counter == 5) {
	break;
}
};

header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="productData.csv"');

$fp = fopen('php://output', 'wb');
foreach ($data as $line) {
    fputcsv($fp, $line, ',');
}
fclose($fp);