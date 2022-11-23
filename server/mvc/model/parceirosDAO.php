<?php
require_once($base_server_path_files.'/server/library/model.php');
class parceirosDAO extends model
{
	const table="parceiros";
	const nome="nome";
	const id_unidade="id_unidade";
	const cnpj="cnpj";
    public function __construct($model_attributes){
		parent::__construct($model_attributes,self::table,[self::nome,self::id_unidade,self::cnpj]);
    }
}
?>