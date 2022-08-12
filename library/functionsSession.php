<?php
    if (!function_exists("getAuthorizationHeader")){ 
        function getAuthorizationHeader(){
            $headers = null;
            if (isset($_SERVER['Authorization'])) {
                $headers = trim($_SERVER["Authorization"]);
            }
            else if (isset($_SERVER['HTTP_AUTHORIZATION'])) { //Nginx or fast CGI
                $headers = trim($_SERVER["HTTP_AUTHORIZATION"]);
            } elseif (function_exists('apache_request_headers')) {
                $requestHeaders = apache_request_headers();
                // Server-side fix for bug in old Android versions (a nice side-effect of this fix means we don't care about capitalization for Authorization)
                $requestHeaders = array_combine(array_map('ucwords', array_keys($requestHeaders)), array_values($requestHeaders));
                //print_r($requestHeaders);
                if (isset($requestHeaders['Authorization'])) {
                    $headers = trim($requestHeaders['Authorization']);
                }
            }
            return $headers;
        }
    }

/**
 * get access token from header
 * */
    if (!function_exists("getBearerToken")){ 
        function getBearerToken() {
            $headers = getAuthorizationHeader();
            // HEADER: Get the access token from the header
            if (!empty($headers)) {
                if (preg_match('/Bearer\s(\S+)/', $headers, $matches)) {
                    return $matches[1];
                }
            }
            return null;
        }
    }



	if (!function_exists("sessionCount")){
		function sessionCount()
		{
			$time_= "00:00";
			if(!isset($_SESSION)) session_start();
			if(isset($_SESSION["id"])){
				$sessao_inicio=$_SESSION["time"];
				$id=$_SESSION["id"];
				$sql="select l.data_fim,l.hora_fim from login l where(id_usuarios=:id_usuarios) and(l.id=(SELECT MAX(t.ID) from login t where(t.id_usuarios=:id_usuarios)))";
				$result=DAOquery($sql,array("id_usuarios"=>$id),true,"");
				if((isset($result["data"]))&&(count($result["data"])>=1)){
					$index_data_fim=0;
					$index_hora_fim=1;
					$hora_fim= $result["data"][0][$index_hora_fim];
					$data_fim= $result["data"][0][$index_data_fim];
					$sessao_inicio=DateTime::createFromFormat("Y-m-d G:i:s", $data_fim." ".$hora_fim)->getTimestamp();
				}
				
				$time_= "00:00";
				$agora= time();
				$_SESSION["time"]=$agora;
				$minutos=$agora-$sessao_inicio;
				$dez_minutos=10*60;
				$restantes=$dez_minutos-$minutos;
				if ($restantes<=0){
					session_destroy();
				}
				else{
					 $time_= date("i:s",$restantes);
				}
			}
			return  $time_;

		}
	}
	if (!function_exists("updateTimeLogin")){
		function updateTimeLogin()
		{
			if(!isset($_SESSION)) session_start();
			$sessao_inicio=$_SESSION["time"];
			$id=$_SESSION["id"];
			$sql="select l.id from login l where(id_usuarios=:id_usuarios) and(l.id=(SELECT MAX(t.ID) from login t where(t.id_usuarios=:id_usuarios)))";
			$result=DAOquery($sql,array("id_usuarios"=>$id),true," ");
			if((isset($result["data"]))&&(count($result["data"])>=1)){
				$index_id=0;
				$id_login= $result["data"][0][$index_id];
				$sql="update login  set data_fim=:data_fim,hora_fim=:hora_fim  where(id_usuarios=:id_usuarios) and(id=:id);";
				$result=DAOquery($sql,array("id_usuarios"=>$id,"id"=>$id_login,"data_fim"=>date("Y-m-d"),"hora_fim"=>date("H:i:s")),false," ");
			}
		}
	}
	
	if (!function_exists("userActiveName")){
		function userActiveName()
		{
			$nome="";
			if(!isset($_SESSION)) session_start();
			$id=$_SESSION["id"];
			$result=DAOquerySelectById("usuarios",array("nome"),"",$id);
			if((isset($result["data"]))&&(count($result["data"])>=1)){
				$index_nome=0;
				$nome= $result["data"][0][$index_nome];
			}
			return $nome;
		}
	}
	
	if (!function_exists("controlAcess")){
		function controlAcess()
		{
		    if(!isset($_SESSION)) session_start();
		    if(sessionCount()=="00:00"){ 
				exit();
				return false;
			}
			else {
				updateTimeLogin();
				return true;
			}
		}
	}
	
	if (!function_exists("verify")){
		function verify()
		{
			header('P3P: CP="CAO PSA OUR"');
			if(sessionCount()=="00:00") logout();
			else updateTimeLogin();
		}
	}
	
	if (!function_exists("logout")){
		function logout()
		{
			if(!isset($_SESSION)) session_start();
			session_destroy();		
			$URL=$_SERVER['REQUEST_SCHEME']."://".$_SERVER['HTTP_HOST']."/admin/login";
			exit(header("location:$URL"));
			exit;
		}
	}
	
	if (!function_exists("login")) {
		function login($login_,$senha){	
			$login=hash('sha512', $login_);
			$senha=hash('sha512', $senha);
            $mensagem_erro="";
			try { 
				$result=DAOquery("select id,login,senha,nome,tentativas from usuarios  where (login=:login)",array("login"=>$login),true,"");
				if((isset($result))&&(isset($result["data"]))){
					if(count($result["data"])==0)
				    	$mensagem_erro="Usuário ou senha inválido";
					else{
						$record_id	= resultDataFieldByTitle($result,"id",0);
						$record_tentativas=resultDataFieldByTitle($result,"tentativas",0);
						$record_login=resultDataFieldByTitle($result,"login",0);
						$record_senha=resultDataFieldByTitle($result,"senha",0);
						$record_nome=resultDataFieldByTitle($result,"nome",0);
						if(($record_senha==$senha)&&($record_login==$login)){
							if(!isset($_SESSION)) session_start();
							$_SESSION["id"]		= $record_id;
							$_SESSION["login"]	= $login_;
							$_SESSION["usuario"]= $record_nome;
							$_SESSION["time"]	= time();
							DAOquery("update usuarios set code='',code_time=null,tentativas=0 where(id=:id)",array("id"=>$record_id),false,"");
							DAOquery("insert into login (id_usuarios,hora_inicio,hora_fim,data_inicio,data_fim) values (:id_usuarios,:hora_inicio,:hora_fim,:data_inicio,:data_fim)",
							array(
								"id_usuarios"=>$record_id,
								"hora_inicio"=>date("H:i:s"),
								"hora_fim"=>date("H:i:s"),
								"data_inicio"=>date("Y-m-d"),
								"data_fim"=>date("Y-m-d")
							)
							,false,"");
						}
						else if($record_tentativas>=5) $mensagem_erro="Usuário bloqueado já fora usadas 5 tentativas tente recuperar a conta com link <b>Esqueceu a senha</b> acima";
						else
						{
							DAOquery("update usuarios set tentativas=:tentativas where(id=:id)",array("id"=>$record_id,"tentativas"=>($record_tentativas+1)),false,"");
							$mensagem_erro="Usuário ou senha inválido você possue ainda mais ".(5-$record_tentativas)." tentativas";
						}
						unset($record_id);
						unset($record_tentativas);
						unset($record_login);
						unset($record_senha);
						unset($record_nome);
					}
					unset($result);
				}
				unset($result);
			}catch (PDOException $error) {
				 
			}
			unset($login);
			unset($senha);
			return ["mensagem_erro"=>$mensagem_erro];
		}
	}


	if (!function_exists("recovery")) {
		function recovery($email){	
            $mensagem_erro="";
			try { 
				$result=DAOquery("SELECT id,nome,e_mail FROM usuarios where (e_mail=:e_mail)",["email"=>hash('sha512', $email)],true,"");
				if((isset($result))&&(isset($result["data"]))){
					if(count($result["data"])==0)
				    	$mensagem_erro="O e-mail informado $email não pertence a nenhum usuario cadastrado";
					else{
						$id	= resultDataFieldByTitle($result,"id",0);
						$nome=resultDataFieldByTitle($result,"nome",0);
						$code=hash('sha512', time());
                        $code_time=date('Y-m-d H:i:s', time());
                        DAOquery("update usuarios set code=:code,code_time=:code_time where(id=:id)",["id"=>$id,"code"=>$code,"code_time"=>$code_time],false,"");
                        sendEmail(
            			    "smtp.hostinger.com.br",
            			    "naoresponda@tooeste.com.br",
            			    "]!xY/>Lv3",
            			    "Recuperar senha de $nome do site ".$_SERVER['HTTP_HOST'],
            			    getParameter("e_mail"),
            			    $nome,
            			    domainURL()."/admin/email_recuperar_senha?acao=recuperar_senha&nome=$nome&e_mail=$email"
            			);
                        $mensagem_successo= "<b>$nome</b> foi enviado uma mensagem para recuperar sua senha para o e-mail <b>$email</b>.".
                        "<br>".
                        "<br>Por favor verifique a caixa de entrada do e-mail <b>$email</b>."
                        ;

					}
				}
				
			}catch (PDOException $error) {
				 
			}
			return ["mensagem_erro"=>$mensagem_erro];
		}
	}

?>