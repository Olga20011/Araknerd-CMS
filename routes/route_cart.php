<?php

switch($request):

    case "cart/create":
        include_once "api/cart/create_cart.php";
        break;

    case "cart/update":
        include_once "api/cart/update_cart.php";
        break; 
             
    case "cart/list":
        include_once "api/cart/get_cart_list.php";
        break; 
             
    case "cart/delete":
        include_once "api/cart/delete_cart.php";
        break; 
             
    case "cart/info":
        include_once "api/cart/get_cart_info.php";
        break; 
    case "cart/orders":
        include_once "api/cart/total_orders.php";
        break; 
            
    case "cart/details":
        include_once "api/cart/cart_details.php";
        break;        
        

        
         
endswitch;

?>