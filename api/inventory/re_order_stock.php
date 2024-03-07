<?php
ini_set('display_errors',1);
error_reporting(E_ALL);
use model\Inventory\Inventory;

require_api_headers();
$data=json_decode(file_get_contents("php://input"));
require_api_data($data, ['qty_in','reorder_point']);


$NewRequest=new Inventory;
$result=$NewRequest->__re_order_stock(clean($data->reorder_point),
                                      clean($data->qty_in)); 
                                       
                                      
                            
$info = format_api_return_data($result, $NewRequest);


//make json
print_r(json_encode($info));



?>