<?php

switch($request):

    case "sup/create":
        include_once "api/supplier/create_supplier.php";
        break;

    case "sup/update":
        include_once "api/supplier/update_supplier.php";
        break; 
             
    case "sup/list":
        include_once "api/supplier/get_supplier_list.php";
        break; 
             
    case "sup/delete":
        include_once "api/supplier/delete_supplier.php";
        break; 
             
    case "sup/info":
        include_once "api/supplier/get_supplier_info.php";
        break;     
        

        
         
endswitch;

?>