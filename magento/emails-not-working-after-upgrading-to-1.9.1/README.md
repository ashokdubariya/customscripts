## Magento - Emails not working after upgrading to 1.9.1
In the Magento version 1.9.1.0 and later all order emails sending with CRON jobs.
So if you want to send emails without CRON please follow the below steps.

1) copy `app/code/core/Mage/Sales/Model/Order.php` to local code pool `app/code/local/Mage/Sales/Model/Order.php`
2) Edit Order.php and find `function queueNewOrderEmail($forceMode = false)`
3) Now replace the below code in this function

<pre>
$storeId = $this->getStore()->getId();
if (!Mage::helper('sales')->canSendNewOrderEmail($storeId)) {
	return $this;
}

$emailSentAttributeValue = $this->hasEmailSent() ? $this->getEmailSent() : Mage::getModel('sales/order')->load($this->getId())->getData('email_sent');
$this->setEmailSent((bool)$emailSentAttributeValue);

if ($this->getEmailSent()) {
	return $this;
}

// Get the destination email addresses to send copies to

$copyTo = $this->_getEmails(self::XML_PATH_EMAIL_COPY_TO);
$copyMethod = Mage::getStoreConfig(self::XML_PATH_EMAIL_COPY_METHOD, $storeId);

// Start store emulation process
$appEmulation = Mage::getSingleton('core/app_emulation');
$initialEnvironmentInfo = $appEmulation->startEnvironmentEmulation($storeId);
try {
	// Retrieve specified view block from appropriate design package (depends on emulated store)
	$paymentBlock = Mage::helper('payment')->getInfoBlock($this->getPayment())->setIsSecureMode(true);
	$paymentBlock->getMethod()->setStore($storeId);
	$paymentBlockHtml = $paymentBlock->toHtml();
} catch (Exception $exception) {
	// Stop store emulation process
	$appEmulation->stopEnvironmentEmulation($initialEnvironmentInfo);
	throw $exception;
}

// Stop store emulation process
$appEmulation->stopEnvironmentEmulation($initialEnvironmentInfo);

// Retrieve corresponding email template id and customer name
if ($this->getCustomerIsGuest()) {
	$templateId = Mage::getStoreConfig(self::XML_PATH_EMAIL_GUEST_TEMPLATE, $storeId);
	$customerName = $this->getBillingAddress()->getName();
} else {
	$templateId = Mage::getStoreConfig(self::XML_PATH_EMAIL_TEMPLATE, $storeId);
	$customerName = $this->getCustomerName();
}

$mailer = Mage::getModel('core/email_template_mailer');
$emailInfo = Mage::getModel('core/email_info');
$emailInfo->addTo($this->getCustomerEmail(), $customerName);

if ($copyTo && $copyMethod == 'bcc') {
	// Add bcc to customer email
	foreach ($copyTo as $email) {
		$emailInfo->addBcc($email);
	}
}

$mailer->addEmailInfo($emailInfo);

// Email copies are sent as separated emails if their copy method is 'copy'
if ($copyTo && $copyMethod == 'copy') {
	foreach ($copyTo as $email) {
		$emailInfo = Mage::getModel('core/email_info');
		$emailInfo->addTo($email);
		$mailer->addEmailInfo($emailInfo);
	}
}

// Set all required params and send emails
$mailer->setSender(Mage::getStoreConfig(self::XML_PATH_EMAIL_IDENTITY, $storeId));
$mailer->setStoreId($storeId);
$mailer->setTemplateId($templateId);
$mailer->setTemplateParams(array(
	'order' => $this,
	'billing' => $this->getBillingAddress(),
	'payment_html' => $paymentBlockHtml
));

$mailer->send();
$this->setEmailSent(true);
$this->_getResource()->saveAttribute($this, 'email_sent');
return $this;
</pre>
