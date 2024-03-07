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
                         
         
endswitch;

?>