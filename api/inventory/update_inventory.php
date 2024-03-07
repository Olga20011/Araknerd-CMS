<?php
ini_set('display_errors',1);
error_reporting(E_ALL);
use model\Inventory\Inventory;

require_api_headers();
$data=json_decode(file_get_contents("php://input"));
require_api_data($data, ['id', 'prd_id', 'reorder_point', 'quantity']);


$NewRequest=new Inventory;
$result=$NewRequest->__update_inventory(clean($data->id),
                                        clean($data->prd_id),
                                        clean($data->reorder_point),
                                        clean($data->quantity));
                                      
                            
$info = format_api_return_data($result, $NewRequest);


//make json
print_r(json_encode($info));

?>