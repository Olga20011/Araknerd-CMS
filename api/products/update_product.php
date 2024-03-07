<?php
ini_set('display_errors',1);
error_reporting(E_ALL);
use model\Products\Product;

require_api_headers();
$data=json_decode(file_get_contents("php://input"));
require_api_data($data, ['id','prd_name','prd_category','buying_price', 'supplier','selling_price','prd_description']);


$NewRequest=new Product;
$result=$NewRequest->__update_product(clean($data->id),
                                       clean($data->prd_name),
                                       clean($data->prd_category),
                                       clean($data->buying_price),
                                       clean($data->selling_price),
                                       clean($data->supplier),
                                       clean($data->prd_description));
                            
$info = format_api_return_data($result, $NewRequest);


//make json
print_r(json_encode($info));

?>