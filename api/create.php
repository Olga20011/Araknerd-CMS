<?php

use model\User\User;

require_api_headers();
$data=json_decode(file_get_contents("php://input"));
require_api_data($data, ['role_name']);


$NewRequest=new User;
$result=$NewRequest->__create_role(clean($data->role_name));

$info = format_api_return_data($result, $NewRequest);

//make json
print_r(json_encode($info));

?>