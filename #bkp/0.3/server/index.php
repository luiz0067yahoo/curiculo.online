<?php 
header("Access-Control-Allow-Origin: *");   
//header("Access-Control-Allow-Origin: http://localhost:5173");   
header("Access-Control-Allow-Methods: POST, DELETE, OPTIONS");    
header("Access-Control-Max-Age: 3600");    
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");    

$base_server_path_files=$_SERVER['DOCUMENT_ROOT'];
$GLOBALS["base_server_path_files"]=$_SERVER['DOCUMENT_ROOT'];
require_once($GLOBALS["base_server_path_files"].'/server/library/route.php');
require($GLOBALS["base_server_path_files"].'/server/library/functions.php');

require_once($GLOBALS["base_server_path_files"].'/server/routes/siteRoute.php');
require_once($GLOBALS["base_server_path_files"].'/server/routes/estadosRoute.php');
require_once($GLOBALS["base_server_path_files"].'/server/routes/usersRoute.php');

require_once($GLOBALS["base_server_path_files"].'/server/routes/parceirosRoute.php');
require_once($GLOBALS["base_server_path_files"].'/server/routes/metasRoute.php');
Route::run('/');


?>