<?php

$base_server_path_files=$_SERVER['DOCUMENT_ROOT'];
require_once($GLOBALS["base_server_path_files"].'/server/library/route.php');
require_once($GLOBALS["base_server_path_files"].'/server/mvc/controller/parceirosController.php');
Route::add('/server/parceiros',function(){
  // if(controlAcess())
   (new parceirosController())->find();
},'get');

Route::add('/server/parceiros/([0-9]*)',function($id){
   //if(controlAcess())
  (new parceirosController())->findByParams(["id"=>$id]);
},'get');

Route::add('/server/parceiros',function(){
    //if(controlAcess())
    (new parceirosController())->create();
},'post');

Route::add('/server/parceiros/([0-9]*)',function($id){
    //if(controlAcess())
    (new parceirosController())->update(["id"=>$id]);
},'put');

Route::add('/server/parceiros/([0-9]*)',function($id){
   //if(controlAcess())
  (new parceirosController())->del(["id"=>$id]);
},'delete');

Route::add('/parceiros/',function(){
    header('Content-Type: text/html; charset=utf-8');
    require_once($GLOBALS["base_server_path_files"].'/index.html');
},'get');

?>