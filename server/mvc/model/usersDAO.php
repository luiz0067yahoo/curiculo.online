<?php
require_once($base_server_path_files.'/server/library/model.php');
class usersDAO extends model
{
	const table="users";
	const name="name";
	const username="username";
	const password="password";
	const e_mail="e_mail";
	const e_mail_crypto="e_mail_crypto";
	const cell_phone="cell_phone";
	const telephone="telephone";
	const code="code";
	const code_time="code_time";
	const attempts="attempts";
    public function __construct($model_attributes){
		parent::__construct($model_attributes,self::table,[self::name,self::username,self::password,self::e_mail,self::e_mail_crypto,self::cell_phone,self::telephone,self::code,self::code_time,self::attempts]);
    }
}
?>