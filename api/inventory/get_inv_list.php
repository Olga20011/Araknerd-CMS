<?php
ini_set('display_errors',1);
error_reporting(E_ALL);
use model\Inventory\Inventory;

require_api_headers();
$data=json_decode(file_get_contents("php://input"));
require_api_data($data, ['page']);


$NewRequest=new Inventory;
$NewRequest->__set_current_page_number(clean($data->page));
$result=$NewRequest->__get_inv_list();
                            
$info = format_api_return_data($result, $NewRequest);


//make json
print_r(json_encode($info));

?>