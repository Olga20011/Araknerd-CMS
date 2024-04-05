<?php

switch($request):

    case "category/create":
        include_once "api/product_category/create_category.php";
        break; 

    case "category/update":
        include_once "api/product_category/update_category.php";
        break; 
         
    case "category/list":
        include_once "api/product_category/get_category_list.php";
        break; 
         
    case "category/delete":
        include_once "api/product_category/delete_category.php";
        break; 
         
    case "category/info":
        include_once "api/product_category/get_category_info.php";
        break; 
                         
         
endswitch;

?>