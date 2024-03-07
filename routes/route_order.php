<?php

switch($request):

    case "order/create":
        include_once "api/order/create_order.php";
        break;

    case "order/update":
        include_once "api/order/update_order.php";
        break; 
             
    case "order/list":
        include_once "api/order/get_order_list.php";
        break; 
             
    case "order/delete":
        include_once "api/order/delete_order.php";
        break; 
             
    case "order/info":
        include_once "api/order/get_order_info.php";
        break; 
    case "order/orders":
            include_once "api/order/total_orders.php";
            break;     
        

        
         
endswitch;

?>