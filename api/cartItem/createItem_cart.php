<?php
ini_set('display_errors',1);
error_reporting(E_ALL);
use model\CartItem\CartItem;

require_api_headers();
$data=json_decode(file_get_contents("php://input"));
require_api_data($data, ['cart_id', 'prd_id', 'customer_id','unit_price','quantity']);


$NewRequest=new CartItem;
$result=$NewRequest->__create_cartItem(clean($data->cart_id),
                                        clean($data->prd_id),
                                        clean($data->customer_id),
                                        clean($data->unit_price),
                                        clean($data->quantity));
                            
$info = format_api_return_data($result, $NewRequest);


//make json
print_r(json_encode($info));

?>