<?php

switch($request):
           
    case "login"://login route
        include_once "api/login.php";//Login Endpoint
        break;

     case "user/role/list"://user role route
        include_once "api/list_roles.php";//User role Endpoint
        break;

    case "user/create"://user role route
        include_once "api/create_user.php";//User role Endpoint
        break;    
endswitch;

?>