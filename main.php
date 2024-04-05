<?php
use model\Auth\Environment;
use model\Logs\Log;
include_once "include/autoloader.php";
include_once "include/functions.php";
(new Environment('.env'))->load();
if(!getenv('DATABASE_USER')):
    (new Log)->__log_custom_file(".env file can't be read", "file_error.log");
    include_once "api/404.php";
endif;
 $request=get_request_name(getenv('URI_DEPTH'));
ob_start();  // Start output buffering
include_once "sys/route_capture.php";
// include_once "strict.php";
include_once 'App.php'; 
include_once "sys/route_clock.php";
$output = ob_get_contents();  // Get the contents of the output buffer
ob_end_clean();  // Clean (erase) the output buffer and turn off output buffering

if (empty($output)) {
    include_once "api/404.php";
}else{
    echo $output;
}
?>