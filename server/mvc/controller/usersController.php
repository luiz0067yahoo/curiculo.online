<?php
    require_once ($base_server_path_files.'/server/connect.php');
    require_once ($base_server_path_files.'/server/library/functions.php');
	require_once($base_server_path_files.'/server/mvc/model/usersDAO.php');
	require_once($base_server_path_files.'/server/mvc/model/logsDAO.php');
	require_once($base_server_path_files.'/server/library/controller.php');
	
	class usersController extends controller
	{
	    
	    public function emailExists($e_mail){
	        $params=[];
		    $model_=parent::getModel();
	        $params[usersDAO::e_mail_crypto]=hash('sha512',$e_mail);
            $model_->setParams($params);
            $model_->cleanFields();
            $model_->addField(usersDAO::id);
            $model_->addField(usersDAO::e_mail_crypto);
            $result=parent::find();
            
            if(
                (
                    isset($result["elements"]) 
                    && !empty($result["elements"])
                )
                && is_array($result["elements"])
                && count($result["elements"]) >0
            )
            {
                return true;
            }
            else{
                return false;
            }
	    }
    	public function usernameExists($username){
	        $params=[];
		    $model_=parent::getModel();
	        $params[usersDAO::username]=hash('sha512',$username);
            $model_->setParams($params);
            $model_->cleanFields();
            $model_->addField(usersDAO::username);
            $model_->addField(usersDAO::id);
            $result=parent::find();
            
            if(
                (
                    isset($result["elements"]) 
                    && !empty($result["elements"])
                )
                && is_array($result["elements"])
                && count($result["elements"]) >0
            )
            {
                return true;
            }
            else{
                return false;
            }
	    }
	    public function getAttemptsByUsername($username){
	        $attempts=0;
		    $params=[];
		    $model_=parent::getModel();
	        $params[usersDAO::username]=hash('sha512',$username);
            $model_->setParams($params);
            $model_->cleanFields();
            $model_->addField(usersDAO::id);
            $model_->addField(usersDAO::attempts);
            $result=parent::find();
            if(
                (
                    isset($result["elements"]) 
                    && !empty($result["elements"])
                )
                && is_array($result["elements"])
                && count($result["elements"]) >0
            )
            {
                if(
                    isset($result["elements"][0][usersDAO::attempts]) 
                    && !empty($result["elements"][0][usersDAO::attempts])
                ){
                    $attempts=intval($result["elements"][0][usersDAO::attempts]);
                }
            }
            return $attempts;
	    }
    	public function usernamePasswordExists($username,$password){
	        $params=[];
    	    $model_=parent::getModel();
            $params[usersDAO::username]=hash('sha512',$username);
            $params[usersDAO::password]=hash('sha512',$password);
            $model_->setParams($params);
            $model_->cleanFields();
            $model_->addField(usersDAO::id);
            $model_->addField(usersDAO::username);
            $model_->addField(usersDAO::password);
            $result=parent::find();
            $result= (
                (isset($result["elements"]) && !empty($result["elements"]))
                && is_array($result["elements"])
                && count($result["elements"]) >0
                &&
                (isset($result["elements"][0][usersDAO::username]) && !empty($result["elements"][0][usersDAO::username]))
                &&
                (isset($result["elements"][0][usersDAO::password]) && !empty($result["elements"][0][usersDAO::password]))
                &&
                (
                    $result["elements"][0][usersDAO::username]==hash('sha512',$username)
                    &&
                    $result["elements"][0][usersDAO::password]==hash('sha512',$password)
                )
            );
            return $result;
	    }
	    public function resetAttempts($username){
		    $params=[];
		    $model_=parent::getModel();
		    $attempts=$this->getAttemptsByUsername($username);
		    $attempts=0;
	        $params[usersDAO::attempts]=$attempts;
            $model_->setParams($params);
            $result=parent::update([usersDAO::username=>hash('sha512',$username)]);
            return $attempts;
		}
		public function resetPassword($username,$password){
		    $params=[];
		    $model_=parent::getModel();
	        $params[usersDAO::password]=hash('sha512',$password);
            $model_->setParams($params);
            $result=parent::update([usersDAO::username=>hash('sha512',$username)]);
            return $attempts;
		}
	    public function incAttempts($username){
		    $params=[];
		    $model_=parent::getModel();
		    $attempts=$this->getAttemptsByUsername($username);
		    $attempts=$attempts+1;
	        $params[usersDAO::attempts]=$attempts;
            $model_->setParams($params);
            $result=parent::update([usersDAO::username=>hash('sha512',$username)]);
            return $attempts;
		}
	    public function activeUser($username,$code){
	        $attempts=-1;
	        if(
    	        (isset($username) && !empty($username))
    	        &&
    	        (isset($code) && !empty($code))
    	    )
	        {
    		    $params=[];
    		    $model_=parent::getModel();
    	        $params[usersDAO::attempts]=0;
                $model_->setParams($params);
                $user=$this->findByUserName($username);
                if(isset($user) && !empty($user)){
                    $user[usersDAO::code_time];
                    $codetime=strtotime($user[usersDAO::code_time]);
                    $date_limit = strtotime("+2 days",$codetime);
                    if($date_limit>time()){
                        $attempts=$this->resetAttempts($username);
                    }
                }
	        }
            return $attempts;
		}
        public function changePassword($username,$code,$password){
	        $attempts=-1;
	        if(
    	        (isset($username) && !empty($username))
    	        &&
    	        (isset($code) && !empty($code))
    	    )
	        {
    		    $params=[];
    		    $model_=parent::getModel();
    	        $params[usersDAO::attempts]=0;
                $model_->setParams($params);
                $user=$this->findByUserName($username);
                if(isset($user) && !empty($user)){
                    $user_code=$user[usersDAO::code];
                    if($user_code==$code){
                        $attempts=$this->resetPassword($username,$password);
                        $attempts=$this->resetAttempts($username);
                    }
                }
	        }
            return $attempts;
		}
        public function create(){
		    $result=[];
		    if($this->usernameExists($username=getParameter(usersDAO::username))){
		        if(!(isset($result["erro"]) && !empty($result["erro"]))){
		            $result["erro"]=[];
		        }
		        $result["erro"]["username"]="username already exists.";
		    }
		    if($this->emailExists($e_mail=getParameter(usersDAO::e_mail))){
		        if(!(isset($result["erro"]) && !empty($result["erro"]))){
		            $result["erro"]=[];
		        }
		        $result["erro"]["e_mail"]="A e-mail already exists.";
		    }
		    
	        if(isset($result["erro"]) && !empty($result["erro"])){
	            HTTPStatus(400);
	        }
	        
	        else{
    		    $params=[];
    		    $model_=parent::getModel();
                $model_->cleanFields();
                $model_->addField(usersDAO::id);
                $model_->addField(usersDAO::name);
                $model_->addField(usersDAO::e_mail);
                $model_->addField(usersDAO::cell_phone);
                $model_->addField(usersDAO::telephone);
    	        if(issetNotEmptyParameter(usersDAO::name))$params[usersDAO::name]=getParameter(usersDAO::name);
    	        if(issetNotEmptyParameter(usersDAO::username))$params[usersDAO::username]=hash('sha512',getParameter(usersDAO::username));
    	        if(issetNotEmptyParameter(usersDAO::password))$params[usersDAO::password]=hash('sha512',getParameter(usersDAO::password));
    	        if(issetNotEmptyParameter(usersDAO::e_mail))$params[usersDAO::e_mail_crypto]=hash('sha512',getParameter(usersDAO::e_mail));
    	        if(issetNotEmptyParameter(usersDAO::e_mail))$params[usersDAO::e_mail]=getParameter(usersDAO::e_mail);
    	        if(issetNotEmptyParameter(usersDAO::cell_phone))$params[usersDAO::cell_phone]=getParameter(usersDAO::cell_phone);
    	        if(issetNotEmptyParameter(usersDAO::telephone))$params[usersDAO::telephone]=getParameter(usersDAO::telephone);
    	        $params[usersDAO::code]=hash('sha512', time());
    	        $params[usersDAO::code_time]=date('Y-m-d H:i:s', time());
    	        $params[usersDAO::date_insert]=date('Y-m-d H:i:s', time());
                $model_->setParams($params);
                $result=parent::create();
                unset($result["params"]);
            }
			echo json_encode($result);
            exit;
	    }
	    public function update($conditions_params){
	        $conditions_params[usersDAO::username]=["!="=>connect::user_app_default];
		    $params=[];
		    $model_=parent::getModel();
	        if(issetNotEmptyParameter(usersDAO::name))$params[usersDAO::name]=getParameter(usersDAO::name);
	        if(issetNotEmptyParameter(usersDAO::username))$params[usersDAO::username]=hash('sha512',getParameter(usersDAO::username));
	        if(issetNotEmptyParameter(usersDAO::password))$params[usersDAO::password]=hash('sha512',getParameter(usersDAO::password));
	        if(issetNotEmptyParameter(usersDAO::e_mail_crypto))$params[usersDAO::e_mail_crypto]=hash('sha512',getParameter(usersDAO::e_mail));
	        if(issetNotEmptyParameter(usersDAO::e_mail))$params[usersDAO::e_mail]=getParameter(usersDAO::e_mail);
	        if(issetNotEmptyParameter(usersDAO::cell_phone))$params[usersDAO::cell_phone]=getParameter(usersDAO::cell_phone);
	        if(issetNotEmptyParameter(usersDAO::telephone))$params[usersDAO::telephone]=getParameter(usersDAO::telephone);
	        $params[usersDAO::code]=hash('sha512', time());
	        $params[usersDAO::code_time]=date('Y-m-d H:i:s', time());
	        $params[usersDAO::date_update]=date('Y-m-d H:i:s', time());
            $model_->setParams($params);
            $model_->cleanFields();
            $model_->addField(usersDAO::id);
            $model_->addField(usersDAO::name);
            $model_->addField(usersDAO::e_mail);
            $model_->addField(usersDAO::cell_phone);
            $model_->addField(usersDAO::telephone);
            $result=parent::update($conditions_params);
            if(isset($result["params"]))unset($result["params"]);
			echo json_encode($result);
			exit;
		}
		public function del($conditions_params){
		    $conditions_params[usersDAO::username]=["!="=>connect::user_app_default];
			echo json_encode(parent::del($conditions_params));		
			exit;
		}
		public function find(){
		    $params=[];
		    $model_=parent::getModel();
	        if(issetNotEmptyParameter(usersDAO::id))$params[usersDAO::id]=getParameter(usersDAO::id);
	        if(issetNotEmptyParameter(usersDAO::name))$params[usersDAO::name]=getParameter(usersDAO::name);
	        if(issetNotEmptyParameter(usersDAO::username))$params[usersDAO::username]=hash('sha512',getParameter(usersDAO::username));
	        if(issetNotEmptyParameter(usersDAO::password))$params[usersDAO::password]=hash('sha512',getParameter(usersDAO::password));
	        if(issetNotEmptyParameter(usersDAO::e_mail_crypto))$params[usersDAO::e_mail_crypto]=hash('sha512',getParameter(usersDAO::e_mail));
	        if(issetNotEmptyParameter(usersDAO::e_mail))$params[usersDAO::e_mail]=getParameter(usersDAO::e_mail);
	        if(issetNotEmptyParameter(usersDAO::cell_phone))$params[usersDAO::cell_phone]=getParameter(usersDAO::cell_phone);
	        if(issetNotEmptyParameter(usersDAO::telephone))$params[usersDAO::telephone]=getParameter(usersDAO::telephone);
	        $params[usersDAO::username]=["!="=>connect::user_app_default];
            $model_->setParams($params);
            $model_->setOrder("id", "desc");
            $model_->cleanFields();
            $model_->addField(usersDAO::id);
            $model_->addField(usersDAO::name);
            $model_->addField(usersDAO::e_mail);
            $model_->addField(usersDAO::cell_phone);
            $model_->addField(usersDAO::telephone);
            $model_->setOrder("id", "desc");
            parent::setModel($model_);
            $result=parent::find();
            unset($result["params"]);
			echo json_encode($result);
			exit;
		}
		public function findByParams($conditions_params){
		    $conditions_params[usersDAO::username]=["!="=>connect::user_app_default];
		    $model_=parent::getModel();
		    $model_->setParams([]);
            $model_->cleanFields();
            $model_->addField(usersDAO::id);
            $model_->addField(usersDAO::name);
            $model_->addField(usersDAO::e_mail);
            $model_->addField(usersDAO::cell_phone);
            $model_->addField(usersDAO::telephone);
            $model_->setOrder("id", "desc");
            parent::setModel($model_);
			$result=parent::findByParams($conditions_params);
            unset($result["params"]);
			echo json_encode($result);
			exit;
		}
		public function findByUserName($username){
		    
		    $conditions_params[usersDAO::username]=["!="=>connect::user_app_default];
	        $params=[];
		    $model_=parent::getModel();
		    if(connect::user_app_default==$username){
	            $params[usersDAO::username]=null;
	        }
	        else{
	            $params[usersDAO::username]=hash('sha512',$username);
	        }
            $model_->setParams($params);
            $model_->cleanFields();
            $model_->addField(usersDAO::id);
            $model_->addField(usersDAO::name);
            $model_->addField(usersDAO::username);
            $model_->addField(usersDAO::password);
            $model_->addField(usersDAO::e_mail);
            $model_->addField(usersDAO::cell_phone);
            $model_->addField(usersDAO::telephone);
            $model_->addField(usersDAO::code);
            $model_->addField(usersDAO::code_time);
            $result=parent::find();
            if(
                (
                    isset($result["elements"]) 
                    && !empty($result["elements"])
                )
                && is_array($result["elements"])
                && count($result["elements"]) >0
            )
            {
                $result=$result["elements"][0];
            }
            else{
                $result=null;
            }
            return $result;
	    }
		public function login($username,$password){
		    $result=[];
		    $maxattempts=5;
		    $result["max".usersDAO::attempts]=$maxattempts;
		    $attempts=$this->getAttemptsByUsername($username);
		    if($attempts>=0 && $attempts<$maxattempts){
    		    if($this->usernameExists($username)){
                    if($this->usernamePasswordExists($username,$password))
                    {
                        $key=connect::JWT_key;
                        $log=(new logsDAO([]))->createLog($username)["elements"][0];
                        $result["token"]=createToken($username,$key,$jti=$log["token"],$nbf=strtotime($log["start_session"]),$exp=strtotime($log["end_session"]),strtotime($iat=$log["date_insert"]));
                        $this->resetAttempts($username);
                        unset($result["max".usersDAO::attempts]);
                    }
                    else{
                        $result[usersDAO::attempts]=$this->incAttempts($username);
                        if(!(isset($result["erro"]) && !empty($result["erro"]))){
    		                $result["erro"]=[];
        		        }
        		        $result["erro"]["access_denied"]="Password invalid";
                    }
    		    }
    		    else{
    		         if(!(isset($result["erro"]) && !empty($result["erro"]))){
    	                $result["erro"]=[];
    		        }
    		        $result["erro"]["access_denied"]="User or password invalid";
    		    }
		    }
		    else if($attempts>0){
		        if(!(isset($result["erro"]) && !empty($result["erro"]))){
	                $result["erro"]=[];
		        }
		        $result[usersDAO::attempts]=$attempts;
		        $result["erro"]["user_block"]="attempts exceeded";
		    }
		    else{
                unset($result[usersDAO::attempts]);
                unset($result["max".usersDAO::attempts]);
		        $result["erro"]["user_block"]="user disabled check your e-mail";
		    }
            unset($result["params"]);
            unset($result["elements"]);
            return $result;
		}
		public function auth(){
		    $username=getParameter(usersDAO::username);
		    $password=getParameter(usersDAO::password);
		    $result=$this->login($username,$password);
            if((isset($result["erro"]) && !empty($result["erro"]))){
                HTTPStatus(401);
            }		    
			echo json_encode($result);
			exit;
		}
        public function recovery(){
            //	$code=hash('sha512', time());
            //  $code_time=date('Y-m-d H:i:s', time());
        }
		public function __construct(){
			parent::__construct(new usersDAO([]));
		}
        function checkToken($token,$key) {
            $part = explode(".",$token);
            $header = $part[0];
            $payload = $part[1];
            $signature = $part[2];
            $valid = hash_hmac('sha512',"$header.$payload",$key,true);
            $valid = base64_encode($valid);
            $header = base64_decode($header);
            $header = json_decode($header);
            $payload = base64_decode($payload);
            $payload = json_decode($payload);
           if(  
               ($signature == $valid)
               &&
               (
                   ($payload->exp >=(new DateTime())->getTimestamp())
                   &&
                   ($payload->nbf <=(new DateTime())->getTimestamp())
               )
            ){
                return (new logsDAO([]))->existsUsernameToken($payload->audi,$payload->jti);          
            }else{
                return false;          
               
            }
        }
        function controlAccessToken() {
            $token=getBearerToken();
            if($this->checkToken($token,$key=connect::JWT_key)){
                return getUserName($token,$key=connect::JWT_key);
            }
            else{
                header('HTTP/1.1 401 Unauthorized');
                exit;
            }
        }
   	}
?>