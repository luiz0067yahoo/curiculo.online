<?php
require_once($base_server_path_files.'/server/library/model.php');
class logsDAO extends model
{
	const table="logs";
	const token="token";
	const username="username";
	const start_session="start_session";
	const end_session="end_session";
    public function __construct($model_attributes){
		parent::__construct($model_attributes,self::table,[self::token,self::username,self::start_session,self::end_session]);
    }
	public function createLog($username){
	    $now_date_time=(new DateTimeImmutable());
	    $params=[];
        $params[logsDAO::token]=$this->createToken($username);
        $params[logsDAO::username]=hash('sha512',$username);
	    $params[logsDAO::start_session]=date("Y-m-d H:i:s",$now_date_time->getTimestamp());
	    $params[logsDAO::end_session]  =date("Y-m-d H:i:s",$now_date_time->modify(connect::time_session)->getTimestamp());
	    $params[logsDAO::date_insert]  =date('Y-m-d H:i:s',$now_date_time->getTimestamp());
	    $this->setParams($params);
		return (parent::create());		
	}
	public function createToken($username){
	    $token=gen_uuid();
	    while($this->existsUsernameToken($username,$token)){
	        $token=gen_uuid();
	    }
	    return $token;
	}
	public function existsUsernameToken($username,$token){
	    $exits=false;
	    $conditions_params=[];
        $conditions_params[logsDAO::token]=$token;
        $conditions_params[logsDAO::username]=hash('sha512',$username);
	    $result= (parent::findByParams($conditions_params));
	    if(
	        (isset($result) && !empty($result) && is_array($result) && count($result)>0)
	        &&
	        (isset($result["elements"]) && !empty($result["elements"]) && is_array($result["elements"]) && count($result["elements"])>0)
	        &&
	        (isset($result["elements"][0]) && !empty($result["elements"][0]) && is_array($result["elements"][0]) && count($result["elements"][0])>0)
	    ){
	        $exits=true;
	    }
	    return $exits;
	}
}
?>