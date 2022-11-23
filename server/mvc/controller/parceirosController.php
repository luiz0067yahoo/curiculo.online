<?php
    require_once ($base_server_path_files.'/server/library/functions.php');
	require_once($base_server_path_files.'/server/mvc/model/parceirosDAO.php');
	require_once($base_server_path_files.'/server/library/controller.php');
	
	class parceirosController extends controller
	{
		public function create(){
		    $params=[];
		    $model_=parent::getModel();
	        if(issetNotEmptyParameter(parceirosDAO::id))$params[parceirosDAO::id]=getParameter(parceirosDAO::id);
	        if(arrayKeyExistsParameter(parceirosDAO::nome))$params[parceirosDAO::nome]=getParameter(parceirosDAO::nome);
	        if(issetParameter(parceirosDAO::id_unidade))$params[parceirosDAO::id_unidade]=getParameter(parceirosDAO::id_unidade);
	        if(issetParameter(parceirosDAO::cnpj))$params[parceirosDAO::cnpj]=getParameter(parceirosDAO::cnpj);
		    $params[parceirosDAO::date_insert]=date('Y-m-d H:i:s', time());
		    $model_->setParams($params);
			echo json_encode(parent::create());		
			exit;
		}
		public function update($conditions_params){
		    $params=[];
		    $model_=parent::getModel();
	        if(issetNotEmptyParameter(parceirosDAO::id))$params[parceirosDAO::id]=getParameter(parceirosDAO::id);
	        if(arrayKeyExistsParameter(parceirosDAO::nome))$params[parceirosDAO::nome]=getParameter(parceirosDAO::nome);
	        if(issetParameter(parceirosDAO::id_unidade))$params[parceirosDAO::id_unidade]=getParameter(parceirosDAO::id_unidade);
	        if(issetParameter(parceirosDAO::cnpj))$params[parceirosDAO::cnpj]=getParameter(parceirosDAO::cnpj);
		    $params[parceirosDAO::date_update]=date('Y-m-d H:i:s', time());
            $model_->setParams($params);
			echo json_encode(parent::update($conditions_params));		
			exit;
		}
		public function del($conditions_params){
			echo json_encode(parent::del($conditions_params));		
			exit;
		}
		public function find(){
		    $params=[];
		    $model_=parent::getModel();
	        if(issetNotEmptyParameter(parceirosDAO::id))$params[parceirosDAO::id]=getParameter(parceirosDAO::id);
	        if(arrayKeyExistsParameter(parceirosDAO::nome))$params[parceirosDAO::nome]=getParameter(parceirosDAO::nome);
	        if(issetParameter(parceirosDAO::id_unidade))$params[parceirosDAO::id_unidade]=getParameter(parceirosDAO::id_unidade);
	        if(issetParameter(parceirosDAO::cnpj))$params[parceirosDAO::cnpj]=getParameter(parceirosDAO::cnpj);
	        $model_->setOrder("id", "desc");
            $model_->setParams($params);
            echo json_encode(parent::find());		
            exit;
		}
		public function findByParams($conditions_params){
		    $model_=parent::getModel();
		    $model_->setParams([]);
            parent::setModel($model_);
			echo json_encode(parent::findByParams($conditions_params));
			exit;
		}

		public function __construct(){
			parent::__construct(new parceirosDAO([]));
		}
	}
?>