<?php

use model\Products\Product;

require_api_headers();
$data=json_decode(file_get_contents("php://input"));
require_api_data($data, []);


$NewRequest=new Product;
// $NewRequest->__set_system_user('oba');
$result=$NewRequest->__table_limit();
                            
$info = format_api_return_data($result, $NewRequest);


//make json
print_r(json_encode($info));

?>