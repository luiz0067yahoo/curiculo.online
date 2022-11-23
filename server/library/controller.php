<?php
	include($base_server_path_files.'/server/library/functions.php');
	class controller{
		protected $model;
		private	$action;
		private	$params;
		protected $settingsImagesUpload;
		public function __construct($model){
            header("Content-Type: application/json; charset=UTF-8");    

			$this->model=$model;
			$this->action=BlockSQLInjection(getParameter("action"));
			$this->findParams=getParameter("findParams");
			if((getParameter("page")!="")&&(getParameter("row_count")!="")){    	
				$this->model->limit["page"]=getParameter("page");
				$this->model->limit["row_count"]=getParameter("row_count");
			}
			if(!isset($this->model->limit["page"]))
			    $this->model->limit["page"]=0;
			if(!isset($this->model->limit["row_count"]))
			    $this->model->limit["row_count"]=10;
			$this->settingsImagesUpload=[];
		}
	    public function upload($call_back_function){
		    $files_uploads=uploadImageRedimencion($this->settingsImagesUpload);
		    $biggerCountFiles=0;
		    $result=[];
		    foreach ($files_uploads as $key => $files){
		        if(($biggerCountFiles==0)||($bigger<count($files)))
		            $biggerCountFiles=count($files);
		    }
    		for($i=0;$i<$biggerCountFiles;$i++){
		        foreach ($files_uploads as $key => $files){
		            
    		        if (count($files)>$i){
    		            $this->model->setParam($key,$files[$i]);
    		            if(empty($files[$i]))
		                    $this->model->unParam($key);
    		        }
    		    }
    		    if(isset($result["data"]))
		            $result["data"]+=call_user_func($call_back_function)["data"];
		        else
		            $result=call_user_func($call_back_function);
		        if (!empty($this->model->getParam("id")));//is update only one file photo
		            break;
		    }
		    return $result;
	    }
		public function getModel(){
			return $this->model;
		}
		public function setModel($model){
			$this->model=$model;
		}
		public function create(){
			return($this->model->create());
		}
		public function update($conditions_params){
			return($this->model->update($conditions_params));
		}
		public function save(){
			return($this->model->save());
		}
		public function del($conditions_params){
			return($this->model->destroy($conditions_params));
		}
		public function find(){
			return($this->model->findLikeHave());
		}
    	public function All(){
			return($this->model->all());
		}
		public function findByParams($conditions_params){
			return($this->model->findByParams($conditions_params));
		}
	}
?>