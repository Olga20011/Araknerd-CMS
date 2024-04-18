<?php

switch($request):

    case "product/create":
        include_once "api/products/create_product.php";
        break; 

    case "product/update":
        include_once "api/products/update_product.php";
        break; 
         
    case "product/list":
        include_once "api/products/get_prd_list.php";
        break; 
         
    case "product/delete":
        include_once "api/products/delete_product.php";
        break; 
         
    case "product/info":
        include_once "api/products/get_prd_info.php";
        break; 

    case "product/total":
        include_once "api/products/total_prd.php";
        break;  
        
    case "product/new":
        include_once "api/products/newest_prd.php";
        break;  

    case "product/limit":
        include_once "api/products/table_limit.php";
        break; 
                         
         
endswitch;

?>