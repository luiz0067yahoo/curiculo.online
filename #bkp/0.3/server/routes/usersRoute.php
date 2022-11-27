<?php

$base_server_path_files=$_SERVER['DOCUMENT_ROOT'];
require_once($GLOBALS["base_server_path_files"].'/server/library/route.php');
require_once($GLOBALS["base_server_path_files"].'/server/mvc/controller/usersController.php');
Route::add('/server/users',function(){
  // if(controlAcess())
   (new usersController())->find();
},'get');

Route::add('/server/users/([0-9]*)',function($id){
   //if(controlAcess())
  (new usersController())->findByParams(["id"=>$id]);
},'get');

Route::add('/server/users',function(){
    //if(controlAcess())
    (new usersController())->create();
},'post');

Route::add('/server/users/([0-9]*)',function($id){
    //if(controlAcess())
    (new usersController())->update(["id"=>$id]);
},'put');

Route::add('/server/users/([0-9]*)',function($id){
   //if(controlAcess())
  (new usersController())->del(["id"=>$id]);
},'delete');

Route::add('/server/auth',function(){
  // if(controlAcess())
   (new usersController())->auth();
},'post');

Route::add('/active_user/',function(){
    header('Content-Type: text/html; charset=utf-8');
    require_once($GLOBALS["base_server_path_files"].'/mvc/view/admin/active_user.php');
},'get');

Route::add('/cadastro_usuarios/',function(){
    header('Content-Type: text/html; charset=utf-8');
    require_once($GLOBALS["base_server_path_files"].'/index.html');
},'get');

?>