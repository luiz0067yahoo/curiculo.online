<?php
    $GLOBALS["_PUT"]=null;
    if($_SERVER['REQUEST_METHOD'] == 'PUT') {
        $form_data= json_encode(file_get_contents("php://input"));
        $key_size=52;
        $key=substr($form_data, 1, $key_size);
        $acc_params=explode($key,$form_data);
        array_shift($acc_params);
        array_pop($acc_params);
        foreach ($acc_params as $item){
            $start_key=' name=\"';
            $end_key='\"\r\n\r\n';
            $start_key_pos=strpos($item,$start_key)+strlen($start_key);
            $end_key_pos=strpos($item,$end_key);
            
            $key=substr($item, $start_key_pos, ($end_key_pos-$start_key_pos));
            
            $end_value='\r\n';
            $value=substr($item, $end_key_pos+strlen($end_key), -strlen($end_value));
            $_PUT[$key]=$value;
        }
        $GLOBALS["_PUT"]=$_PUT;
    }

	if (!function_exists("getParameter")){
		function getParameter($parameter)
		{
			$value=null;
			if(($_SERVER['REQUEST_METHOD'] == 'POST')&& (isset($_POST[$parameter]))){
			    $value=$_POST[$parameter];
			}
			else if(($_SERVER['REQUEST_METHOD'] == 'PUT')&& (isset($GLOBALS["_PUT"][$parameter])))
			{
			        $value=$GLOBALS["_PUT"][$parameter];
			}
			else if(($_SERVER['REQUEST_METHOD'] == 'DELETE')&& (isset($_DELETE[$parameter]))){
			    $value=$_DELETE[$parameter];
			}
			else if(($_SERVER['REQUEST_METHOD'] == 'PATCH')&& (isset($_PATCH[$parameter]))){
			    $value=$_PATCH[$parameter];
			}
			else if(isset($_GET[$parameter])){
			    $value=$_GET[$parameter];
			}
			return $value;
		}
	}	
	
	if (!function_exists("issetParameter")){
		function issetParameter($parameter)
		{
		    $value=false;
			if(($_SERVER['REQUEST_METHOD'] == 'POST')&& (isset($_POST[$parameter]))){
			    $value=true;
			}
			else if(($_SERVER['REQUEST_METHOD'] == 'PUT')&& (isset($GLOBALS["_PUT"][$parameter])))
			{
			    $value=true;
			}
			else if(($_SERVER['REQUEST_METHOD'] == 'DELETE')&& (isset($_DELETE[$parameter]))){
			    $value=true;
			}
			else if(($_SERVER['REQUEST_METHOD'] == 'PATCH')&& (isset($_PATCH[$parameter]))){
			    $value=true;
			}
			else if(isset($_GET[$parameter])){
			    $value=true;
			}
			return $value;
		}
	}
	if (!function_exists("issetEmpty")){
		function issetNotEmptyParameter($parameter)
		{
		    $value=false;
		    		    $value=false;
   			if(($_SERVER['REQUEST_METHOD'] == 'POST') && isset($_POST) && array_key_exists($parameter,$_POST)){
			    $value=((isset($_POST[$parameter])) && (!empty($_POST[$parameter])));
			}
			else if(($_SERVER['REQUEST_METHOD'] == 'PUT') && isset($GLOBALS["_PUT"]) && array_key_exists($parameter,$GLOBALS["_PUT"]))
			{
			    $value=((isset($GLOBALS["_PUT"][$parameter])) && (!empty($GLOBALS["_PUT"][$parameter])));
			}
			else if(($_SERVER['REQUEST_METHOD'] == 'DELETE') && isset($_DELETE) && array_key_exists($parameter,$_DELETE)){
			    $value=((isset($_DELETE[$parameter])) && (!empty($_DELETE[$parameter])));
			}
			else if(($_SERVER['REQUEST_METHOD'] == 'PATCH') && isset($_PATCH) && array_key_exists($parameter,$_PATCH)){
			    $value=((isset($_PATCH[$parameter])) && (!empty($_PATCH[$parameter])));
			}
			else if(isset($_GET[$parameter]) && isset($_GET) && array_key_exists($parameter,$_GET)){
			    $value=((isset($_GET[$parameter])) && (!empty($_GET[$parameter])));
			}
			return $value;	
		}
	}
	if (!function_exists("arrayKeyExistsParameter")){
		function arrayKeyExistsParameter($parameter)
		{
		    $value=false;
   			if(($_SERVER['REQUEST_METHOD'] == 'POST') && isset($_POST) && array_key_exists($parameter,$_POST)){
			    $value=true;
			}
			else if(($_SERVER['REQUEST_METHOD'] == 'PUT') && isset($GLOBALS["_PUT"]) && array_key_exists($parameter,$GLOBALS["_PUT"]))
			{
			    $value=true;
			}
			else if(($_SERVER['REQUEST_METHOD'] == 'DELETE') && isset($_DELETE) && array_key_exists($parameter,$_DELETE)){
			    $value=true;
			}
			else if(($_SERVER['REQUEST_METHOD'] == 'PATCH') && isset($_PATCH) && array_key_exists($parameter,$_PATCH)){
			    $value=true;
			}
			else if(isset($_GET[$parameter]) && isset($_GET) && array_key_exists($parameter,$_GET)){
			    $value=true;
			}
			return $value;	
		}
	}

	
	if (!function_exists("getIDYouTube")) {
		function getIDYouTube($url){
            $parts = parse_url($url);
            if(isset($parts['query'])){
                parse_str($parts['query'], $qs);
                if(isset($qs['v'])){
                    return $qs['v'];
                }else if(isset($qs['vi'])){
                    return $qs['vi'];
                } 
            }
            if(isset($parts['path'])){
                $path = explode('/', trim($parts['path'], '/'));
                return $path[count($path)-1];
            }
            return false;
        }
		
	}
	
    if (!function_exists("setIDYouTube")){
		function setIDYouTube(){
              return "http://www.youtube.com/watch?v=$id";
        }
	}	
	
	if (!function_exists("createAuthenticityToken")){
		function createAuthenticityToken(){
            if(!isset($_SESSION)) session_start();
            $_SESSION["AuthenticityToken"]=hash('sha512', time());
            return $_SESSION["AuthenticityToken"];
        }
       
	}
	
	
	if (!function_exists("checkAuthenticityToken")){
		function checkAuthenticityToken($AuthenticityToken){
            if(!isset($_SESSION)) session_start();
            if($_SESSION["AuthenticityToken"]!=$AuthenticityToken){
                echo "Erro de autenticação de token";
                exit();
            }
        }
	}	
	
	
	
    if (!function_exists("getAuthenticityToken")){
		function getAuthenticityToken(){
            if(!isset($_SESSION)) session_start();
            else if(isset($_SESSION["AuthenticityToken"])) return $_SESSION["AuthenticityToken"];
        }
	}	
   

     if (!function_exists('domainURL')){
    		function domainURL(){
    		    $protocolo = (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS']=="on") ? "https" : "http");
                $url = '://'.$_SERVER['HTTP_HOST'];
                return $protocolo.$url; 
    		}
     }	  

	
?>