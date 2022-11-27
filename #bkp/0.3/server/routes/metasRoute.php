<?php

$base_server_path_files=$_SERVER['DOCUMENT_ROOT'];
require_once($GLOBALS["base_server_path_files"].'/server/library/route.php');
require_once($GLOBALS["base_server_path_files"].'/server/mvc/controller/metasController.php');
Route::add('/server/metas',function(){
  // if(controlAcess())
   (new metasController())->find();
},'get');

Route::add('/server/metas/([0-9]*)',function($id){
   //if(controlAcess())
  (new metasController())->findByParams(["id"=>$id]);
},'get');

Route::add('/server/metas',function(){
    //if(controlAcess())
    (new metasController())->create();
},'post');

Route::add('/server/metas/([0-9]*)',function($id){
    //if(controlAcess())
    (new metasController())->update(["id"=>$id]);
},'put');

Route::add('/server/metas/([0-9]*)',function($id){
   //if(controlAcess())
  (new metasController())->del(["id"=>$id]);
},'delete');

Route::add('/meta/',function(){
    header('Content-Type: text/html; charset=utf-8');
    require_once($GLOBALS["base_server_path_files"].'/index.html');
},'get');

?>