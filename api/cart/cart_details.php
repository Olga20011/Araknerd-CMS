<?php
use model\Cart\Cart;
ini_set('display_errors',1);
error_reporting(E_ALL);


require_api_headers();
$data=json_decode(file_get_contents("php://input"));
require_api_data($data, ['id']);


$NewRequest=new Cart;
$result=$NewRequest->__cart_details(clean($data->id)); 
                            
$info = format_api_return_data($result, $NewRequest);


//make json
print_r(json_encode($info));

?>
