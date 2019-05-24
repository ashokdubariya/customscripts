<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
ini_set('memory_limit', '5G');
error_reporting(E_ALL);

use Magento\Framework\App\Bootstrap;
require 'app/bootstrap.php';

$bootstrap = Bootstrap::create(BP, $_SERVER);

$objectManager = $bootstrap->getObjectManager();

$state = $objectManager->get('Magento\Framework\App\State');
$state->setAreaCode('frontend');

$catId = 2;
$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
$categoryObject = $objectManager->create('Magento\Catalog\Model\Category');
$categoryObject->load($catId);
$childCategories = $categoryObject->getChildrenCategories();

if(count($childCategories)) {
	foreach ($childCategories as $childCat) {
		echo $childCat->getName()."<br />";
		$categoryObject->load($childCat->getId());
		$firstLevelChildCategories = $categoryObject->getChildrenCategories();

		if(count($firstLevelChildCategories)) {
			foreach ($firstLevelChildCategories as $first) {
				echo $childCat->getName() . " > ".$first->getName()."<br />";
				$categoryObject->load($first->getId());
				$firstLevelChildCategories = $categoryObject->getChildrenCategories();

				if(count($firstLevelChildCategories)) {
					foreach ($firstLevelChildCategories as $second) {
						echo $childCat->getName()." > ".$first->getName()." > ".$second->getName()."<br />";
						$categoryObject->load($second->getId());
						$firstLevelChildCategories = $categoryObject->getChildrenCategories();

						if(count($firstLevelChildCategories)) {
							foreach ($firstLevelChildCategories as $third) {
								echo $childCat->getName()." > ".$first->getName()." > ".$second->getName()." > ".$third->getName()."<br />";
								$categoryObject->load($third->getId());
								$firstLevelChildCategories = $categoryObject->getChildrenCategories();

								if(count($firstLevelChildCategories)) {
									foreach ($firstLevelChildCategories as $fourth) {
										echo $childCat->getName()." > ".$first->getName()." > ".$second->getName()." > ".$third->getName()." > ".$fourth->getName()."<br />";
										$categoryObject->load($fourth->getId());
										$firstLevelChildCategories = $categoryObject->getChildrenCategories();

										if(count($firstLevelChildCategories)) {
											foreach ($firstLevelChildCategories as $fifth) {
												echo $childCat->getName()." > ".$first->getName()." > ".$second->getName()." > ".$third->getName()." > ".$fourth->getName()." > ".$fifth->getName()."<br />";
												$categoryObject->load($fifth->getId());
												$firstLevelChildCategories = $categoryObject->getChildrenCategories();

												if(count($firstLevelChildCategories)) {
												
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
	}	
}

?>