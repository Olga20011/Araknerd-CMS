<?php

switch($request):

    case "cartItem/create":
        include_once "api/cartItem/create_cartItem.php";
        break;

    case "cartItem/update":
        include_once "api/cartItem/update_cartItem.php";
        break; 
             
    case "cartItem/list":
        include_once "api/cartItem/get_cartItem_list.php";
        break; 
             
    case "cartItem/delete":
        include_once "api/cartItem/delete_cartItem.php";
        break; 
             
    case "cartItem/info":
        include_once "api/cartItem/get_cartItem_info.php";
        break;  
    case "cartItem/details":
        include_once "api/cartItem/cartItem_details.php";
        break;   
        

        
         
endswitch;

?>