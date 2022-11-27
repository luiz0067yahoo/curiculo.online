<?php

$base_server_path_files=$_SERVER['DOCUMENT_ROOT'];
require_once($GLOBALS["base_server_path_files"].'/server/library/route.php');
require_once($GLOBALS["base_server_path_files"].'/server/mvc/controller/estadosController.php');
Route::add('/server/estados',function(){
  // if(controlAcess())
   (new estadosController())->find();
},'get');

Route::add('/server/estados/([0-9]*)',function($id){
   //if(controlAcess())
  (new estadosController())->findByParams(["id"=>$id]);
},'get');

Route::add('/server/estados',function(){
    //if(controlAcess())
    (new estadosController())->create();
},'post');

Route::add('/server/estados/([0-9]*)',function($id){
    //if(controlAcess())
    (new estadosController())->update(["id"=>$id]);
},'put');

Route::add('/server/estados/([0-9]*)',function($id){
   //if(controlAcess())
  (new estadosController())->del(["id"=>$id]);
},'delete');

Route::add('/cadastro_estados/',function(){
    header('Content-Type: text/html; charset=utf-8');
    require_once($GLOBALS["base_server_path_files"].'/index.html');
},'get');

?>