<?php 

/* 
 * Magento - Get database connection details
 */

require_once('app/Mage.php');
umask(0);
Mage::app();

error_reporting(E_ALL | E_STRICT);

ini_set('display_errors', 1);

$config 	= Mage::getConfig()->getResourceConnectionConfig("default_setup");
$host 		= $config->host;
$username 	= $config->username;
$password  	= $config->password;
$dbname 	= $config->dbname;

echo "Host: ".$host;
echo "<br />Username: ".$username;
echo "<br />Password: ".$password;
echo "<br />Database: ".$dbname;

?>