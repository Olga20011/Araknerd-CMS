<?php
// ini_set('display_errors',1);
// error_reporting(E_ALL);
// use model\App;
use model\Products\Product;

require_api_headers();
$data=json_decode(file_get_contents("php://input"));
require_api_data($data, ['page']);


$NewRequest=new Product;
$NewRequest->__set_current_page_number(clean($data->page));
// $NewRequest->__set_system_user('oba');
$result=$NewRequest->__get_prd_list();
                            
$info = format_api_return_data($result, $NewRequest);


//make json
print_r(json_encode($info));

?>