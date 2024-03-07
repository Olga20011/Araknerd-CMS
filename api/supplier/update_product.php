<?php
ini_set('display_errors',1);
error_reporting(E_ALL);
use model\Supplier\Supplier;

require_api_headers();
$data=json_decode(file_get_contents("php://input"));
require_api_data($data, ['id','supplier_name','phone_number','email','location']);


$NewRequest=new Supplier;
$result=$NewRequest->__update_supplier(clean($data->id),
                                       clean($data->supplier_name),
                                       clean($data->phone_number),
                                       clean($data->email),
                                       clean($data->location));
                            
$info = format_api_return_data($result, $NewRequest);


//make json
print_r(json_encode($info));

?>