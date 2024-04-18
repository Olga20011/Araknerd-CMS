<?php
ini_set('display_errors',1);
error_reporting(E_ALL);
use model\Supplier\Supplier;

require_api_headers();
$data=json_decode(file_get_contents("php://input"));
require_api_data($data, ['page']);


$NewRequest=new Supplier;
$NewRequest->__set_current_page_number(clean($data->page));
$result=$NewRequest->__get_supplier_list();
                            
$info = format_api_return_data($result, $NewRequest);


//make json
print_r(json_encode($info));

?>