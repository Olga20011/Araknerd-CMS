<?php
ini_set('display_errors',1);
error_reporting(E_ALL);
use model\Order\Order;

require_api_headers();
$data=json_decode(file_get_contents("php://input"));
require_api_data($data, ['order_id','customer_id','prd_id','unit_price','quantity','date','status']);


$NewRequest=new Order;
$result=$NewRequest->__create_order(clean($data->order_id),
                                    clean($data->customer_id),
                                    clean($data->prd_id),
                                    clean($data->unit_price),
                                    clean($data->quantity),
                                    clean($data->date),
                                    clean($data->status),
                                   
                                    );
                            
$info = format_api_return_data($result, $NewRequest);


//make json
print_r(json_encode($info));

?>