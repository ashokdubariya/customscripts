<?php 
/* 
 * Magento - Set all categories is_anchor
 */

require_once('app/Mage.php');
umask(0);
Mage::app();

error_reporting(E_ALL | E_STRICT);

ini_set('display_errors', 1);

$categoryCollection = Mage::getModel('catalog/category')->getCollection()
						->addAttributeToSelect('*')
						->addAttributeToFilter('is_anchor', 0)
						->addAttributeToFilter('entity_id', array("gt" => 1))
						->setOrder('entity_id');

if($categoryCollection->count() > 0) {
	echo "List of below all categories has been update with is_anchor = Yes";
	foreach($categoryCollection as $category) {
		echo "<br />".$category->getId() . "&emsp;" . $category->getName();
		$category->setIsAnchor(1);
		$category->save();
	}
} else {
	echo "No categories found matching the selection.";
}

?>
