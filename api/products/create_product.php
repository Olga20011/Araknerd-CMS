<?php
ini_set('display_errors',1);
error_reporting(E_ALL);
use model\Products\Product;

require_api_headers();
$data=json_decode(file_get_contents("php://input"));
require_api_data($data, ['prd_name','prd_category','prd_description','supplier','buying_price','selling_price','qty_in', 'qty_out','reorder_point']);


$NewRequest=new Product;
$result=$NewRequest->__create_products(clean($data->prd_name),
                                       clean($data->prd_category),
                                       clean($data->prd_description),
                                       clean($data->supplier),
                                       clean($data->buying_price),
                                       clean($data->selling_price),
                                       clean($data->qty_in),
                                       clean($data->qty_out),
                                       clean($data->reorder_point));
                            
$info = format_api_return_data($result, $NewRequest);


//make json
print_r(json_encode($info));

?>