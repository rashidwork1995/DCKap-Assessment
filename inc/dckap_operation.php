<?php
include 'config.php';
require_once 'dckap_function.php';

$method = $_REQUEST['method'];   
$dckap_function = new DCKAP();
global $db;
switch ($method) {
    case 'login':
        $dckap=$dckap_function->LoginCheck();
    break;
    case 'user_register':
        $dckap=$dckap_function->UserRegister();
    break;
    case 'view_user':
        $dckap=$dckap_function->ViewUser();
    break;
    case 'product_add':
        $dckap=$dckap_function->ProductAdd();
    break;
    case 'product_view':
        $dckap=$dckap_function->ProductView();
    break;
    case 'add_cart':
        $dckap=$dckap_function->AddCart();
    break;
    case 'view_cart':
        $dckap=$dckap_function->ViewCart();
    break;
    case 'customer_address':
        $dckap=$dckap_function->customer_address();
    break;
    case 'add_order':
        $dckap=$dckap_function->AddOrder();
    break;
    case 'view_orders':
        $dckap=$dckap_function->ViewOrder();
    break;
    case 'deletecart':
        $dckap=$dckap_function->DeleteCart();
    break;

    default:
    break;
}
echo json_encode($dckap);
?>