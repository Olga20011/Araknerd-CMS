<?php
ini_set('display_errors',1);
error_reporting(E_ALL);
use model\Cart\Cart;

require_api_headers();
$data=json_decode(file_get_contents("php://input"));
require_api_data($data, ['id','unit_price','quantity','total_price']);


$NewRequest=new Cart ;
$result=$NewRequest->__update_cart(clean($data->id),
                                        clean($data->total_price),
                                        clean($data->unit_price),
                                        clean($data->quantity));
                            
$info = format_api_return_data($result, $NewRequest);


//make json
print_r(json_encode($info));

?>