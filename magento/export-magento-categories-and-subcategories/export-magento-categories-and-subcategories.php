<?php
require_once("app/Mage.php"); //Path to Magento
umask(0);
Mage::app();

error_reporting(E_ALL | E_STRICT);

ini_set('display_errors', 1);

$mainCategoryId = Mage::app()->getStore("default")->getRootCategoryId();
$firstCategories = Mage::getModel('catalog/category')->getCategories($mainCategoryId);
$export_file = "categories.csv"; // assumes that you're running from the web root. var/ is typically writable
$export = fopen($export_file, 'w') or die("Permissions error."); // open the file for writing.  if you see the error then check the folder permissions.
$output = "";
$output = "Category Id,Category Name\r\n"; // column names. end with a newline.
fwrite($export, $output); // write the file header with the column names
foreach ($firstCategories as $firstCategory) {
	$output = 	"";
	$output .= 	$firstCategory->getId().",";
 	$output .= 	$firstCategory->getName()."\r\n"; 	
 	//$output .= 	$firstCategory['is_active']."\r\n";
 	fwrite($export, $output);
	$secondCategories = Mage::getModel('catalog/category')->getCategories($firstCategory->getId());
	if(count($secondCategories) > 0){
		foreach ($secondCategories as $secondCategory) {
			$output = 	"";
			$output .= 	$secondCategory->getId().",";
		 	$output .= 	$firstCategory->getName()." > ".$secondCategory->getName()."\r\n";
		 	//$output .= 	$secondCategory['is_active']."\r\n";
		 	fwrite($export, $output);
			$thirdCategories = Mage::getModel('catalog/category')->getCategories($secondCategory->getId());
			if(count($thirdCategories) > 0){
				foreach ($thirdCategories as $thirdCategory) {
					$output = 	"";
					$output .= 	$thirdCategory->getId().",";
				 	$output .= 	$firstCategory->getName()." > ".$secondCategory->getName()." > ".$thirdCategory->getName()."\r\n";				 	
				 	//$output .= 	$thirdCategory['is_active']."\r\n";
				 	fwrite($export, $output);
					$fourthCategories = Mage::getModel('catalog/category')->getCategories($thirdCategory->getId());
					if(count($fourthCategories) > 0){
						foreach ($fourthCategories as $fourthCategory) {
							$output = 	"";
							$output .= 	$fourthCategory->getId().",";
						 	$output .= 	$firstCategory->getName()." > ".$secondCategory->getName()." > ".$thirdCategory->getName()." > ".$fourthCategory->getName()."\r\n";
						 	//$output .= 	$fourthCategory['is_active']."\r\n";
						 	fwrite($export, $output);
							$fifthCategories = Mage::getModel('catalog/category')->getCategories($fourthCategory->getId());
							if(count($fifthCategories) > 0){
								foreach ($fifthCategories as $fifthCategory) {
									$output = 	"";
									$output .= 	$fifthCategory->getId().",";
								 	$output .= 	$firstCategory->getName()." > ".$secondCategory->getName()." > ".$thirdCategory->getName()." > ".$fourthCategory->getName()." > ".$fifthCategory->getName()."\r\n";
								 	//$output .= 	$fifthCategory['is_active']."\r\n";
								 	fwrite($export, $output);					
									$sixthCategories = Mage::getModel('catalog/category')->getCategories($fifthCategory->getId());
									if(count($sixthCategories) > 0){
										foreach ($sixthCategories as $sixthCategory) {
											$output = 	"";
											$output .= 	$sixthCategory->getId().",";
										 	$output .= 	$firstCategory->getName()." > ".$secondCategory->getName()." > ".$thirdCategory->getName()." > ".$fourthCategory->getName()." > ".$fifthCategory->getName()." > ".$sixthCategory->getName()."\r\n";
										 	//$output .= 	$sixthCategory['is_active']."\r\n";
										 	fwrite($export, $output);					
										}
									}
								}
							}
						}
					}
				}
			}
		}
	}
}
fclose($export); // close the file handle.