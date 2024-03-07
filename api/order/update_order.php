<?php
ini_set('display_errors',1);
error_reporting(E_ALL);
use model\Order\Order;

require_api_headers();
$data=json_decode(file_get_contents("php://input"));
require_api_data($data, ['id','date','total_cost','status']);


$NewRequest=new Order;
$result=$NewRequest->__update_order(clean($data->id),
                                    clean($data->date),
                                    clean($data->total_cost),
                                    clean($data->status));
                            
$info = format_api_return_data($result, $NewRequest);


//make json
print_r(json_encode($info));

?>