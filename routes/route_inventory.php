<?php

switch($request):

    case "inv/create":
        include_once "api/inventory/create_inventory.php";
        break;

    case "inv/update":
        include_once "api/inventory/update_inventory.php";
        break; 
             
    case "inv/list":
        include_once "api/inventory/get_inv_list.php";
        break; 
             
    case "inv/delete":
        include_once "api/inventory/delete_inventory.php";
        break; 
             
    case "inv/info":
        include_once "api/inventory/get_inv_info.php";
        break;   
    
    case "inv/order":
        include_once "api/inventory/re_order_stock.php";
        break; 
        
    case "inv/total":
        include_once "api/inventory/total_qty.php";
        break;  
       
         
endswitch;

?>