<?php

switch($request):

    case "customer/create":
        include_once "api/customer/create_customer.php";
        break;

    case "customer/update":
        include_once "api/customer/update_customer.php";
        break; 
             
    case "customer/list":
        include_once "api/customer/get_customer_list.php";
        break; 
             
    case "customer/delete":
        include_once "api/customer/delete_customer.php";
        break; 
             
    case "customer/info":
        include_once "api/customer/get_customer_info.php";
        break;      
         
endswitch;

?>