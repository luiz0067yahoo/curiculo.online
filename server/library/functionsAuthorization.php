<?php
    if (!function_exists("HTTPStatus")){ 
        function HTTPStatus($num) {
            $http = array(
                100 => 'HTTP/1.1 100 Continue',
                101 => 'HTTP/1.1 101 Switching Protocols',
                200 => 'HTTP/1.1 200 OK',
                201 => 'HTTP/1.1 201 Created',
                202 => 'HTTP/1.1 202 Accepted',
                203 => 'HTTP/1.1 203 Non-Authoritative Information',
                204 => 'HTTP/1.1 204 No Content',
                205 => 'HTTP/1.1 205 Reset Content',
                206 => 'HTTP/1.1 206 Partial Content',
                300 => 'HTTP/1.1 300 Multiple Choices',
                301 => 'HTTP/1.1 301 Moved Permanently',
                302 => 'HTTP/1.1 302 Found',
                303 => 'HTTP/1.1 303 See Other',
                304 => 'HTTP/1.1 304 Not Modified',
                305 => 'HTTP/1.1 305 Use Proxy',
                307 => 'HTTP/1.1 307 Temporary Redirect',
                400 => 'HTTP/1.1 400 Bad Request',
                401 => 'HTTP/1.1 401 Unauthorized',
                402 => 'HTTP/1.1 402 Payment Required',
                403 => 'HTTP/1.1 403 Forbidden',
                404 => 'HTTP/1.1 404 Not Found',
                405 => 'HTTP/1.1 405 Method Not Allowed',
                406 => 'HTTP/1.1 406 Not Acceptable',
                407 => 'HTTP/1.1 407 Proxy Authentication Required',
                408 => 'HTTP/1.1 408 Request Time-out',
                409 => 'HTTP/1.1 409 Conflict',
                410 => 'HTTP/1.1 410 Gone',
                411 => 'HTTP/1.1 411 Length Required',
                412 => 'HTTP/1.1 412 Precondition Failed',
                413 => 'HTTP/1.1 413 Request Entity Too Large',
                414 => 'HTTP/1.1 414 Request-URI Too Large',
                415 => 'HTTP/1.1 415 Unsupported Media Type',
                416 => 'HTTP/1.1 416 Requested Range Not Satisfiable',
                417 => 'HTTP/1.1 417 Expectation Failed',
                500 => 'HTTP/1.1 500 Internal Server Error',
                501 => 'HTTP/1.1 501 Not Implemented',
                502 => 'HTTP/1.1 502 Bad Gateway',
                503 => 'HTTP/1.1 503 Service Unavailable',
                504 => 'HTTP/1.1 504 Gateway Time-out',
                505 => 'HTTP/1.1 505 HTTP Version Not Supported',
            );
         
            header($http[$num]);
 
    }

    }
    if (!function_exists("gen_uuid")){ 
        function gen_uuid() {
            return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
                // 32 bits for "time_low"
                mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),
        
                // 16 bits for "time_mid"
                mt_rand( 0, 0xffff ),
        
                // 16 bits for "time_hi_and_version",
                // four most significant bits holds version number 4
                mt_rand( 0, 0x0fff ) | 0x4000,
        
                // 16 bits, 8 bits for "clk_seq_hi_res",
                // 8 bits for "clk_seq_low",
                // two most significant bits holds zero and one for variant DCE1.1
                mt_rand( 0, 0x3fff ) | 0x8000,
        
                // 48 bits for "node"
                mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
            );
        }
    }
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

    if (!function_exists("createToken")){ 
        function createToken($username,$key,$jti,$nbf,$exp,$iat) {
            $header = [
               'alg' => 'HS512',
               'typ' => 'JWT'
            ];
            $header = json_encode($header);
            $header = base64_encode($header);
            $payload = [
               'jti' => $jti,
               'iss' => $_SERVER['SERVER_NAME'],
               'audi' => $username,
               'sub' =>  $_SERVER["REQUEST_URI"],
               'nbf' => $nbf,
               'exp' => $exp,
               'iat' => $iat,
            ];
            $payload = json_encode($payload);
            $payload = base64_encode($payload);

            $signature = hash_hmac('sha512',"$header.$payload",$key,true);
            $signature = base64_encode($signature);
            
            return "$header.$payload.$signature";
        }
    }
     
    if (!function_exists("getUserName")){ 
        function getUserName($token,$key) {
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
            return $payload->audi;
        }
    }
    if (!function_exists("getPayload")){ 
        function getPayload($token,$key) {
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
            return $payload;
        }
    }
    
    if (!function_exists("checkToken")){ 
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
                return true;          
            }else{
                return false;          
               
            }

        }
    }
    
    if (!function_exists("controlAccessToken")){ 
        function controlAccessToken($key) {
            $token=getBearerToken();
            if(checkToken($token,$key)){
                return getUserName($token,$key);
            }
            else{
                header('HTTP/1.1 401 Unauthorized');
                exit;
            }
        }
    }
   
    
	if (!function_exists("recovery")) {
	    //
		function recovery(
		    $email,
		    $smtp_server,
		    $server_email,
		    $server_password,
		    $title,
		    $url_recovery
		){	
		    $result=[];
            $mensagem_erro="";
			try { 
				$result=DAOquery("SELECT id,username,e_mail FROM users where (e_mail=:e_mail)",["email"=>hash('sha512', $email)],true,"");
				if((isset($result))&&(isset($result["data"]))){
					if(count($result["data"])==0){
                        header('HTTP/1.1 401 Unauthorized');
                        exit;
					}
					else{
						$id	= resultDataFieldByTitle($result,"id",0);
						$username=resultDataFieldByTitle($result,"username",0);
						$code=hash('sha512', time());
                        $code_time=date('Y-m-d H:i:s', time());
                        DAOquery("update users set code=:code,code_time=:code_time where(id=:id)",["id"=>$id,"code"=>$code,"code_time"=>$code_time],false,"");
                        sendEmail(
            			    $smtp_server,
            			    $server_email,
            			    $server_password,
            			    $title,
            			    getParameter("e_mail"),
            			    $username,
            			    $url_recovery,
            			);
            			$result["username"]=$username;
            			$result["email"]=$email;
                        
					}
				}
				
			}catch (PDOException $error) {
				 
			}
			return $result;
		}
	}
	
	if (!function_exists("updateTimeLogin")){
		function updateTimeLogin($username_)
		{
		    $username=hash('sha512', $username_);
			$sql="select id from users u where u.username=:username limiti 1";
			$result=DAOquery($sql,array("username"=>$username),true," ");
			$sql="select max(l.id) as lastID from login l where l.id_user=:id_user";
			$id_user=null;
			if((isset($result["data"]))&&(count($result["data"])>=1)){
			    $id_user=$result["DATA"][0]["id"];
			}
		
			$result=DAOquery($sql,array("username"=>$username,"id_user"=>$id_user),true," ");
			if((isset($result["data"]))&&(count($result["data"])>=1)){
				$id_login= $result["data"][0]["lastID"];
				$sql="update login  set end_date=:end_date,end_hour=:end_hour  where(id_user=:id_user) and(id=:id);";
				$result=DAOquery($sql,array("id_user"=>$id_user,"id"=>$id_login,"end_date"=>date("Y-m-d"),"end_hour"=>date("H:i:s")),false," ");
			}
		}
	}
	
	if (!function_exists("sessionCount")){
		function sessionCount($username,$limit_time=(10*60))//ten minutes
		{
		    $result_time="";
		    $start_session=null;
		    $sql="select max(l.id) as lastID from login l where l.id_user=:id_user";
			$id_user=null;
			if((isset($result["data"]))&&(count($result["data"])>=1)){
			    $id_user=$result["DATA"][0]["id"];
			}

			if(isset($id_user) && !empty($id_user)){
				$sql="select l.end_date,l.end_hour from login l where(id_user=:id_user) and(l.id=(SELECT MAX(t.ID) from login t where(t.id_user=:id_user)))";
				$result=DAOquery($sql,array("id_user"=>$id),true,"");
				if((isset($result["data"]))&&(count($result["data"])>=1)){
					$end_hour= $result["data"][0]["end_hour"];
					$end_date= $result["data"][0]["end_date"];
					$start_session=DateTime::createFromFormat("Y-m-d G:i:s", $end_date." ".$end_hour)->getTimestamp();
				}
				$now= time();
				$minutes=$now-$start_session;
				$result_time=$limit_time-$minutes;
			}
			return  $result_time;
		}
	}
  
?>