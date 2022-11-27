<?php 

$base_server_path_files=$_SERVER['DOCUMENT_ROOT'];
require($GLOBALS["base_server_path_files"].'/route.php');
require($GLOBALS["base_server_path_files"].'/library/functions.php');

Route::add('/',function(){
    header('Content-Type: text/html; charset=utf-8');
    require_once($GLOBALS["base_server_path_files"].'/template.html');
},'get');
Route::add('/adm/',function(){
    header('Content-Type: text/html; charset=utf-8');
    require_once($GLOBALS["base_server_path_files"].'/template.html');
},'get');
Route::add('/formacao_academica/',function(){
    header('Content-Type: text/html; charset=utf-8');
    require_once($GLOBALS["base_server_path_files"].'/template.html');
},'get');
Route::add('/conhecimentos/',function(){
    header('Content-Type: text/html; charset=utf-8');
    require_once($GLOBALS["base_server_path_files"].'/template.html');
},'get');
Route::add('/cargo_pretendido/',function(){
    header('Content-Type: text/html; charset=utf-8');
    require_once($GLOBALS["base_server_path_files"].'/template.html');
},'get');
Route::add('/dados_pessoais/',function(){
    header('Content-Type: text/html; charset=utf-8');
    require_once($GLOBALS["base_server_path_files"].'/template.html');
},'get');
Route::add('/dados_basicos/',function(){
    header('Content-Type: text/html; charset=utf-8');
    require_once($GLOBALS["base_server_path_files"].'/template.html');
},'get');
Route::add('/experiencia_profissional/',function(){
    header('Content-Type: text/html; charset=utf-8');
    require_once($GLOBALS["base_server_path_files"].'/template.html');
},'get');
Route::add('/cadastro_estados/',function(){
    header('Content-Type: text/html; charset=utf-8');
    require_once($GLOBALS["base_server_path_files"].'/template.html');
},'get');



require_once($GLOBALS["base_server_path_files"].'/mvc/controller/estadosController.php');
Route::add('/server/estados',function(){
  // if(controlAcess())
   (new estadosController())->find();
},'get');

Route::add('/server/estados/([0-9]*)',function($id){
   //if(controlAcess())
  (new estadosController())->findById($id);
},'get');

Route::add('/server/estados',function(){
    //if(controlAcess())
    (new estadosController())->create();
},'post');

Route::add('/server/estados',function(){
    //if(controlAcess())
    (new estadosController())->update();
},'put');

Route::add('/server/estados/([0-9]*)',function($id){
   //if(controlAcess())
  (new estadosController())->del($id);
},'delete');


Route::run('/');


?>