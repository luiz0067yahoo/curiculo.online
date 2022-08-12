<?php
	if (!function_exists("BlockSQLInjection")) {
		function BlockSQLInjection($str)
		{
			return str_replace("'","''",$str);
		}
	}	
	
	if (!function_exists("resultDataFieldByTitle")) {
	    function resultDataFieldByTitle($result,$Field,$index){
	        if 
	        (
	            (isset($result))
	            &&(isset($result["elements"]))
	            &&(count($result["elements"])>$index)
	        )
	            return $result["elements"][$index][array_search($Field,$result["title"])];
	        else
	            return null;
	    }
	    
	}
	
	
	if (!function_exists("DAOquery")) {
	    function DAOquery($sql,$paramsQuery,$select_execute,$limitParams){
			$data=array();
			$result=array();
	        if ($sql!="")
    		try {
    		    $Statement__ = null;
    			$Statement__ = connect::getInstance()->prepare($sql);
			    if (isset($limitParams)&& !empty($limitParams)&&(is_array($limitParams))&&(count($limitParams)>0))
    				if (
    					(isset($limitParams["offset"]))
    					&&
    					(isset($limitParams["row_count"]))
    				){
						
        		        $Statement__->bindValue(':offset', $limitParams["offset"],PDO::PARAM_INT);
        		        $Statement__->bindValue(':row_count', $limitParams["row_count"],PDO::PARAM_INT);
    				}
					
    			if (is_array($paramsQuery))
    			foreach ($paramsQuery as $key_param => $value){
    			     if((is_array($paramsQuery[$key_param]))&&( substr(array_keys($paramsQuery[$key_param])[0],0,1)!=":")){//not bind start operator whith :
						$Statement__->bindParam(":".$key_param,array_values($paramsQuery[$key_param])[0]);
    			     }
        			 else{
    			        $Statement__->bindParam(":".$key_param,$paramsQuery[$key_param],PDO::PARAM_STR);
        			 }
					
    			}
    			if ($Statement__->execute()) {
					
					if($select_execute==true){
						while ($result_= $Statement__->fetch(PDO::FETCH_ASSOC)) 
						{
							array_push($data,$result_);
						}
						$result_=null;
					}
    			}
				$Statement__ = null;
				$result= array("params"=>$paramsQuery,"elements"=>$data);
    		}
    		catch (PDOException $error) {
    		   $result= 'Error: ' . $error->getMessage();
				
    		}
	        return $result;
	    }
	}
	
	
	if (!function_exists("DAOqueryInsert")) {
	    function DAOqueryInsert($table,$params){
	        try {
	            $sql="INSERT INTO  ".$table;
    	        $fields_array=array_keys($params);
    	        $field_str=implode(",",$fields_array);
    	        $field_params_str=":".join(",:",$fields_array);
    	        $sql.=" (".$field_str.") VALUES (".$field_params_str.");";
                DAOquery($sql,$params,false,null);
                DAOquery("commit;","",false,null);
                return true;
	        }
	        catch (PDOException $error) {
	            //echo json_encode($error);
	            return false;
	        }
	    }
	}
	
	
	if (!function_exists("DAOqueryUpdate")) {
	    function DAOqueryUpdate($table,$params,$conditionsParams){
	        try {
    	        $fields_values="";
    	        $conditions="";
    	        foreach ($params as $key => $value  )
    	            $fields_values.=($fields_values=="")?" ".$key." = :".$key." "  : ", ".$key." = :".$key." ";
    	        foreach ($conditionsParams as $key => $value  )
    	            $conditions=($conditions=="")?"(".$key." = :".$key.")"  : " and (".$key." = :".$key.")";
    	        $sql="UPDATE ".$table." SET ".$fields_values." WHERE ( ".$conditions." );";
    	        $params=($params+$conditionsParams);
    	        DAOquery($sql,$params,false,null);
                DAOquery("commit;","",false,null);
                return true;
	        }
	        catch (PDOException $error) {
	            return false;
	        }
	    }
	}
	
	if (!function_exists("DAOqueryDelete")) {
	    function DAOqueryDelete($table,$conditionsParams){
	        $conditions="";
	        foreach ($conditionsParams as $key => $value  ){
	            $conditions=($conditions=="")?"(".$key." = :".$key.")"  : " and (".$key." = :".$key.")";
	        }
	        $sql="DELETE FROM ".$table." WHERE (".$conditions.")";
	        return DAOquery($sql,$conditionsParams,false,null);
	    }
	}

	
	
	if (!function_exists("createCondition")) {
	    function createCondition($table,$key,$conditionalOperator,$paramName,$value){
            if( substr($conditionalOperator,0,1)!=":"){//not bind start operator whith :
                $paramName=":".str_replace(".","_",$paramName);
            }
            else{
                $conditionalOperator=substr($conditionalOperator,1);
                $paramName="(".BlockSQLInjection($value).")";
            }

	        $conditions="";
            $relationalOperatorNot="";
            
            if(is_null($value)){
                if ($conditionalOperator=="!=")
                    $relationalOperatorNot="not";
                $conditionalOperator="is";
            }
            else if($conditionalOperator=="%."){
                
                $value="%".$value;
                $conditionalOperator="like";
            }
            else if($conditionalOperator==".%"){
                $value=$value."%";
                $conditionalOperator="like";
            }
            else if($conditionalOperator=="%.%"){
                $value="%".$value."%";
                $conditionalOperator="like";
            }
            
            if(
                (!strpos($key,"."))
                &&(!strpos($key," as "))
	            &&!((substr($key, 0,1)=="(") && (substr($key,-1)==")"))
	            )
                $conditions.="(".$table.".".$key." ".$conditionalOperator." ".$paramName.")";  
            else
                $conditions.="(".$key." ".$conditionalOperator." ".$paramName.")";
            

	        return $relationalOperatorNot." ".$conditions;
	    }
	}
	
	if (!function_exists("createConditions")) {
	    function createConditions($table,$conditionsParams,$relationalOperator){
	        $conditions="";
	        if(is_array($conditionsParams))
	        //for($i=0;$i<count($conditionsParams);$i++){
	          //  $key=(array_keys($conditionsParams)[$i]);
	           // $value=(array_values($conditionsParams)[$i]);
	        //}
	        foreach ($conditionsParams as $key => $value  ){
    	        $condition="";
	            $conditionalOperator="=";
	            if(empty($relationalOperator))
	                $relationalOperator="and";
	            if(is_int($key)&&is_array($value))
	                $condition=createConditions($table,$value,$key);
	            else if (($key=="or")||($key=="and")||($key=="xor")){
	                $condition="(".createConditions($table,$value,$key).")";
	            }
	            else{ 
	                $paramName=$key;
	                if (is_array($value)){
                        $endPosition=(count($value)-1);
                        if($endPosition>0)
                            $paramName=array_values($value)[0];
                        if(count(explode(":", $paramName))>1){
                            $paramName=explode(":", $paramName)[1];
                            $paramName=explode(")", $paramName)[0];
                            $paramName=explode("(", $paramName)[0];
                            $paramName=explode("+", $paramName)[0];
                            $paramName=explode("-", $paramName)[0];
                            $paramName=explode("*", $paramName)[0];
                            $paramName=explode("|", $paramName)[0];
                            $paramName=explode("&", $paramName)[0];
	                    }
                        $conditionalOperator=(array_keys($value)[0]!=0)?"=":array_keys($value)[0];    
                        $value_value=array_values($value)[$endPosition];    
                        $condition=createCondition($table,$key,$conditionalOperator,$paramName,$value_value);
	                }
	                else $condition=createCondition($table,$key,$conditionalOperator,$paramName,$value);
	            }
	            if(!empty($condition))
                    $conditions.=($conditions=="")?$condition:" $relationalOperator ".$condition;
	        }
	        return $conditions;
	    }
	}
	if (!function_exists("paramsByConditions")) {
	    function paramsByConditions($allParams){
	        $conditionsParams=[];
	        if(is_array($allParams))
	        foreach ($allParams as $key => $value  ){
	            if(is_int($key)&&is_array($value))
	                $conditionsParams+=paramsByConditions($value);
	            else 	            
	            if (($key=="or")||($key=="and")||($key=="xor")){
	                $conditionsParams+=paramsByConditions($value);
	            }
	            else{
                    $paramName=$key;
	                if (is_array($value)){
                        $endPosition=(count($value)-1);
                        $paramName=($endPosition==0)?$key:array_values($value)[0];
                        if(count(explode(":", $paramName))>1){
                            $paramName=explode(":", $paramName)[1];
                            $paramName=explode(")", $paramName)[0];
                            $paramName=explode("(", $paramName)[0];
                            $paramName=explode("+", $paramName)[0];
                            $paramName=explode("-", $paramName)[0];
                            $paramName=explode("*", $paramName)[0];
                            $paramName=explode("|", $paramName)[0];
                            $paramName=explode("&", $paramName)[0];
                        }
                        $value=array_values($value)[$endPosition];    
	                }
                    $paramName=str_replace(".","_",$paramName);
                    
                    $conditionsParams[$paramName]=$value;
	            }
	        }
	        return $conditionsParams;
	    }
	}
	
	if (!function_exists("addConditionalOperatorInConditionParams")) {
	    function addConditionalOperatorInConditionParams($conditionParams,$conditionalOperator){
	        foreach ($conditionParams as $key => $value  ){
	            if(!is_array($conditionParams[$key]))
	                $conditionParams[$key]=[$conditionalOperator=>$value];
	        }
	        return $conditionParams;
	    }
	}
	
	
	
	
	if (!function_exists("DAOquerySelect")) {
	    function DAOquerySelect($table,$fields_params,$joins,$conditionsParams,$groups,$having,$orders,$limitParams){
	        $sql="";
	        $fields_str="";
			
	        foreach ($fields_params as $fields_key => $fields_value){
	            if(!(
                    (strpos($fields_value,"."))
                ||  (strpos($fields_value," as "))
	            ||  ((substr($fields_value, 0)=="(")&&(substr($fields_value,-1)==")"))
	            ))
	                $fields_params[$fields_key]=$table.".".$fields_value;
	        }
	        $fields_str= implode(",",$fields_params);
	        $sql="SELECT ".$fields_str." FROM ".$table." ".$joins;
	        $conditions=createConditions($table,$conditionsParams,"");
	        if ($conditions!="")
	          $sql.=" WHERE (".$conditions.")";
	        $groups_str="";
	        if(is_array($groups)){
    	        foreach ($groups as $fields_key => $fields_value){
    	            if(!strpos($fields_value,"."))
    	                $groups[$fields_key]=$table.".".$fields_value;
    	        }
    	        $groups_str= implode(",",$groups);
	            if ($groups_str!="")
	                $sql.=" GROUP BY ".$groups_str." ";
	        }
	        if(is_array($having)){
                $conditions=createConditions($table,$having,"");
	            if ($conditions!="")
	                $sql.=" HAVING  (".$conditions.") ";
	        }
			$params_=paramsByConditions($conditionsParams)+paramsByConditions($having);
	        $orders_str="";  
	        if(is_array($orders))
                foreach ($orders as $fields_key => $type_order){
	            if(!(
                    (strpos($fields_key,"."))
                ||  (strpos($fields_key," as "))
	            ||  ((substr($fields_key, 0)=="(")&&(substr($fields_key,-1)==")"))
	            ))
                    $order=$table.".".$fields_key." ".$type_order;
                else
	                $order=$fields_key." ".$type_order;
                    
                if($orders_str=="") $orders_str=$order;
                else $orders_str.=" ,".$order;

	        }  
	        if ($orders_str!="")
	          $sql.=" ORDER BY ".$orders_str." ";

			if (isset($limitParams)&& !empty($limitParams)&& is_array($limitParams)&&(count($limitParams)>0))
				if (
					(isset($limitParams["page"]))
					&&
					(isset($limitParams["row_count"]))
				){
					$row_count=BlockSQLInjection($limitParams["row_count"]);
					$row_count=intval($row_count);
					$page=BlockSQLInjection($limitParams["page"]);
					$offset=intval($row_count)*intval($page-1);
					$limitParams["offset"]=$offset;
					$sql.=" limit :offset , :row_count ";
    			}
	        return DAOquery($sql,$params_,true,$limitParams);
	    }
	}
	
	if (!function_exists("DAOquerySelectLast")) {
	    function DAOquerySelectLast($table,$fields_params,$joins){
	        foreach ($fields_params as $fields_key => $fields_value){
	            if(!strpos($fields_value,"."))
	                $fields_params[$fields_key]=$table.".".$fields_value;
	        }
	        $fields= implode(",",$fields_params);
	        $sql="SELECT ".$fields." FROM ".$table." ".$joins." ORDER BY  ".$table.".id DESC limit 0,1";
			
	        return DAOquery($sql,"",true,null);
	    }
	}
	
	
	if (!function_exists("DAOquerySelectById")) {
	    function DAOquerySelectById($table,$fields_params,$joins,$id){
	        $conditionsParams=["id"=>$id];
			$limitParams=["page"=>1,"row_count"=>1];
	        return DAOquerySelect($table,$fields_params,$joins,$conditionsParams,"","","",$limitParams);
	    }
	}