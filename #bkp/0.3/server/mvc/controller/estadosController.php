<?php
    require_once ($base_server_path_files.'/server/library/functions.php');
	require_once($base_server_path_files.'/server/mvc/model/estadosDAO.php');
	require_once($base_server_path_files.'/server/library/controller.php');
	
	class estadosController extends controller
	{
		public function create(){
		    $params=[];
		    $model_=parent::getModel();
	        if(issetNotEmptyParameter(estadosDAO::id))$params[estadosDAO::id]=getParameter(estadosDAO::id);
	        if(arrayKeyExistsParameter(estadosDAO::nome))$params[estadosDAO::nome]=getParameter(estadosDAO::nome);
	        if(issetParameter(estadosDAO::sigla))$params[estadosDAO::sigla]=getParameter(estadosDAO::sigla);
		    $params[estadosDAO::date_insert]=date('Y-m-d H:i:s', time());
		    $model_->setParams($params);
			echo json_encode(parent::create());		
			exit;
		}
		public function update($conditions_params){
		    $params=[];
		    $model_=parent::getModel();
	        if(issetNotEmptyParameter(estadosDAO::id))$params[estadosDAO::id]=getParameter(estadosDAO::id);
	        if(arrayKeyExistsParameter(estadosDAO::nome))$params[estadosDAO::nome]=getParameter(estadosDAO::nome);
	        if(issetParameter(estadosDAO::sigla))$params[estadosDAO::sigla]=getParameter(estadosDAO::sigla);
		    $params[estadosDAO::date_update]=date('Y-m-d H:i:s', time());
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
	        if(issetNotEmptyParameter(estadosDAO::id))$params[estadosDAO::id]=getParameter(estadosDAO::id);
	        if(arrayKeyExistsParameter(estadosDAO::nome))$params[estadosDAO::nome]=getParameter(estadosDAO::nome);
	        if(issetParameter(estadosDAO::sigla))$params[estadosDAO::sigla]=getParameter(estadosDAO::sigla);
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
			parent::__construct(new estadosDAO([]));
		}
	}
?>