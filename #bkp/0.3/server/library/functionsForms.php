<?php
       if (!function_exists("getBetween")){    
        function getBetween($string, $start = "", $end = ""){
            $result="";
            if (strpos($string, $start)) { // required if $start not exist in $string
                $startCharCount = strpos($string, $start) + strlen($start);
                $firstSubStr = substr($string, $startCharCount, strlen($string));
                $result=$firstSubStr;
                if(isset($end) && !empty($end)){
                    $endCharCount = strpos($firstSubStr, $end);
                    $result=substr($firstSubStr, 0, $endCharCount);
                }
                return $result;
            } else {
                return '';
            }
        }
    }
    if (!function_exists("getBodyRequestParamsFiles")){    
        function getBodyRequestParamsFiles(){
            
            ini_set("allow_url_fopen", 1);
            $key="";
            $test_key="";
            $bodyrequest   = @fopen('php://input', 'r');
            $acc_param="";
            $params=[];
            $files_=[];
            if ($bodyrequest)
            {
              $params[$_SERVER['REQUEST_METHOD']]=[];
              $index=0;
              while (!feof($bodyrequest))
              {
                if ($index==0){
                    $key = fread($bodyrequest, 52);
                    $index=$index+52;
                }
                $dataByte=fread($bodyrequest, 1);
                $test_key=$test_key.$dataByte;
                $acc_param=$acc_param.$dataByte;
                $index=$index+1;
                if(strlen($test_key)==52){
                    if($test_key==$key){
                        $acc_param=substr($acc_param,0,-52);
                        $param_name=getBetween($acc_param,     $start = " name=\"",      $end = "\"");
                        $filename=getBetween($acc_param, $start = "; filename=\"", $end = "\"");
                        $param_value=null;
                        $type=null;
                        if(isset($filename) && !empty($filename)){
                            $type=getBetween($acc_param, $start = "Content-Type: ", $end = "\r\n");
                            $param_value=getBetween($acc_param, $start = "Content-Type: ".$type."\r\n\r\n", $end = "");
                            $tmp_name =  tempnam(sys_get_temp_dir(), 'FOO');
                            $handle = fopen($tmp_name, "w");
                            fwrite($handle, $param_value);
                            fclose($handle);
                            $files_[$param_name]=["name"=>$filename,"type"=>$type,"tmp_name"=>$tmp_name,"error"=>0,"size"=>strlen($param_value)];
                        }
                        else{
                            $param_value=getBetween($acc_param, $start = " name=\"".$param_name."\"\r\n\r\n", $end = "\r\n");
                            $params[$_SERVER['REQUEST_METHOD']][$param_name]=$param_value;
                        }
                        $acc_param="";
                    }
                    $test_key=substr($test_key,1);
                
                }
              }
              fclose($bodyrequest);
            }
            
            return ["params"=>$params,"files"=>$files_];
          
        }
    }

    $data=getBodyRequestParamsFiles();
    $GLOBALS["_PUT"]=null;
    if($_SERVER['REQUEST_METHOD']=="PUT"){
      if  (isset($data["params"]["PUT"]) ){
        $GLOBALS["_PUT"]=$data["params"]["PUT"];  
      }
      if  (isset($data["files"]) ){
        $GLOBALS["_FILES"]=$data["files"];
      }
    }
    $GLOBALS["_DELETE"]=null;
    if($_SERVER['REQUEST_METHOD']=="DELETE"){
      if  (isset($data["params"]["DELETE"]) ){
        $GLOBALS["_DELETE"]=$data["params"]["DELETE"];  
      }
      if  (isset($data["files"]) ){
        $GLOBALS["_FILES"]=$data["files"];
      }
    }
            
   
    if (!function_exists("getParameter")){
		function getParameter($parameter)
		{
		    $_DELETE=$GLOBALS["_DELETE"];
		    $_PUT=$GLOBALS["_PUT"];
			$value=null;
			if(($_SERVER['REQUEST_METHOD'] == 'POST')&& (isset($_POST[$parameter]))){
			    $value=$_POST[$parameter];
			}
			else if(($_SERVER['REQUEST_METHOD'] == 'PUT')&& (isset($_PUT[$parameter])))
			{
		        $value=$_PUT[$parameter];
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
		    $_DELETE=$GLOBALS["_DELETE"];
		    $_PUT=$GLOBALS["_PUT"];
		    $value=false;
			if(($_SERVER['REQUEST_METHOD'] == 'POST')&& (isset($_POST[$parameter]))){
			    $value=true;
			}
			else if(($_SERVER['REQUEST_METHOD'] == 'PUT')&& (isset($_PUT[$parameter])))
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
		    $_DELETE=$GLOBALS["_DELETE"];
		    $_PUT=$GLOBALS["_PUT"];
		    $value=false;
   			if(($_SERVER['REQUEST_METHOD'] == 'POST') && isset($_POST) && array_key_exists($parameter,$_POST)){
			    $value=((isset($_POST[$parameter])) && (!empty($_POST[$parameter])));
			}
			else if(($_SERVER['REQUEST_METHOD'] == 'PUT') && isset($_PUT) && array_key_exists($parameter,$_PUT))
			{
			    $value=((isset($_PUT[$parameter])) && (!empty($_PUT[$parameter])));
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
		    $_DELETE=$GLOBALS["_DELETE"];
		    $_PUT=$GLOBALS["_PUT"];
		    $value=false;
   			if(($_SERVER['REQUEST_METHOD'] == 'POST') && isset($_POST) && array_key_exists($parameter,$_POST)){
			    $value=true;
			}
			else if(($_SERVER['REQUEST_METHOD'] == 'PUT') && isset($_PUT) && array_key_exists($parameter,$_PUT))
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
	


	
     if (!function_exists('domainURL')){
    		function domainURL(){
    		    $protocolo = (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS']=="on") ? "https" : "http");
                $url = '://'.$_SERVER['HTTP_HOST'];
                return $protocolo.$url; 
    		}
     }	  

	
?>