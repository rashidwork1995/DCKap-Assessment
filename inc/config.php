<?php
error_reporting(1);
session_start();
include 'pdo.php';

//db config details
define("DB_HOST", "localhost");
define("DB_USER", "root");
define("DB_PASS", "");
define("DB_NAME", "dckap_task");

//gloabl values define
define("PDOERRORS", $_SERVER['DOCUMENT_ROOT'] . '/inc/');

//Db table name define
define("TABLE_PREFIX", "dckap_");
define("DCKAP_USER", TABLE_PREFIX . "user");
define("DCKAP_PRODUCT", TABLE_PREFIX . "product");
define("DCKAP_PRODUCT_FILE", TABLE_PREFIX . "product_file");
define("DCKAP_CART", TABLE_PREFIX . "cart");
define("DCKAP_ORDER", TABLE_PREFIX . "order");

$db = new Epdo(DB_HOST, DB_USER, DB_PASS, DB_NAME);
global $db; 

define("DB",$db);

?>