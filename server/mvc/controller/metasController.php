<?php
    require_once ($base_server_path_files.'/server/library/functions.php');
	require_once($base_server_path_files.'/server/mvc/model/metasDAO.php');
	require_once($base_server_path_files.'/server/library/controller.php');
	
	class metasController extends controller
	{
		public function create(){
		    $params=[];
		    $model_=parent::getModel();
	        if(issetNotEmptyParameter(metasDAO::id))$params[metasDAO::id]=getParameter(metasDAO::id);
	        if(arrayKeyExistsParameter(metasDAO::titulo))$params[metasDAO::titulo]=getParameter(metasDAO::titulo);
	        if(issetParameter(metasDAO::mes))$params[metasDAO::mes]=getParameter(metasDAO::mes);
	        if(issetParameter(metasDAO::valor))$params[metasDAO::valor]=getParameter(metasDAO::valor);
	        if(issetParameter(metasDAO::status))$params[metasDAO::status]=getParameter(metasDAO::status);
	        if(issetParameter(metasDAO::descritivo))$params[metasDAO::descritivo]=getParameter(metasDAO::descritivo);
		    $params[metasDAO::date_insert]=date('Y-m-d H:i:s', time());
		    $model_->setParams($params);
			echo json_encode(parent::create());		
			exit;
		}
		public function update($conditions_params){
		    $params=[];
		    $model_=parent::getModel();
	        if(issetNotEmptyParameter(metasDAO::id))$params[metasDAO::id]=getParameter(metasDAO::id);
	        if(arrayKeyExistsParameter(metasDAO::titulo))$params[metasDAO::titulo]=getParameter(metasDAO::titulo);
	        if(issetParameter(metasDAO::mes))$params[metasDAO::mes]=getParameter(metasDAO::mes);
	        if(issetParameter(metasDAO::valor))$params[metasDAO::valor]=getParameter(metasDAO::valor);
	        if(issetParameter(metasDAO::status))$params[metasDAO::status]=getParameter(metasDAO::status);
	        if(issetParameter(metasDAO::descritivo))$params[metasDAO::descritivo]=getParameter(metasDAO::descritivo);
		    $params[metasDAO::date_update]=date('Y-m-d H:i:s', time());
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
	        if(issetNotEmptyParameter(metasDAO::id))$params[metasDAO::id]=getParameter(metasDAO::id);
	        if(arrayKeyExistsParameter(metasDAO::titulo))$params[metasDAO::titulo]=getParameter(metasDAO::titulo);
	        if(issetParameter(metasDAO::mes))$params[metasDAO::mes]=getParameter(metasDAO::mes);
	        if(issetParameter(metasDAO::valor))$params[metasDAO::valor]=getParameter(metasDAO::valor);
	        if(issetParameter(metasDAO::status))$params[metasDAO::status]=getParameter(metasDAO::status);
	        if(issetParameter(metasDAO::descritivo))$params[metasDAO::descritivo]=getParameter(metasDAO::descritivo);
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
			parent::__construct(new metasDAO([]));
		}
	}
?>