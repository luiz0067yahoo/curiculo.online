<?php
require_once($base_server_path_files.'/server/library/model.php');
class metasDAO extends model
{
	const table="metas";
	const titulo="titulo";
	const mes="mes";
	const valor="valor";
	const status="status";
	const descritivo="descritivo";
    public function __construct($model_attributes){
		parent::__construct($model_attributes,self::table,[self::titulo,self::mes,self::valor,self::status,self::descritivo]);
    }
}
?>