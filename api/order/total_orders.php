<?php
use model\Order\Order;
ini_set('display_errors',1);
error_reporting(E_ALL);


require_api_headers();
$data=json_decode(file_get_contents("php://input"));
require_api_data($data, []);


$NewRequest=new Order;
$result=$NewRequest->__total_orders(); 
                            
$info = format_api_return_data($result, $NewRequest);


//make json
print_r(json_encode($info));

?>
