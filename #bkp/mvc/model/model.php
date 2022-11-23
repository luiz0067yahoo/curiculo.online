<?php
require($base_server_path_files.'/library/functions.php');
class model{
	private $table;
    private $fields;
    private $params;
    private $joins;
    private $conditions;
    private $having;
    private $groups;
    private $orders;
    private $limit;

	const id="id";
	const date_insert="date_insert";
	const date_update="date_update";

    public function __construct($params,$table,$fields){
        $this->params=$params;
        $this->table=$table;
        $this->fields=$fields;
        $this->fields=array(self::id);
		$this->fields=array_merge($this->fields,$fields);
		array_push($this->fields,self::date_insert);
		array_push($this->fields,self::date_update);
        $this->joins="";
        $this->conditions=[];
        $this->having=[];
        $this->groups=[];
        $this->orders=[];
        $this->limit=[];
    }
    public function cleanFields()
    {
        unset($this->fields);
        $this->fields=[];
    }

    public function addField($field)
    {
        array_push($this->fields,$field);
    }

    public function setFields($newFields)
    {
        unset($this->fields);
        $this->fields=$newFields;
    }

    public function getFields()
    {
        return $this->fields;
    }
    
    public function setJoins($value)
    {//strtoupper
        $this->joins = ($value);
        return $this;
    }
    public function getJoins()
    {
        if($this->joins)
		return $this->joins;
    }
    
	public function setParams($params)
    {//strtoupper
        $this->params=$params;
    }
    public function getParams()
    {
		return $this->params;
    }

	public function setParam($attribute, $value)
    {//strtoupper
        $this->params[$attribute] = ($value);
        return $this;
    }
    public function getParam($attribute)
    {
        if($this->issetParam($attribute))
		return $this->params[$attribute];
    }
    public function unParam($attribute)
    {
        if($this->issetParam($attribute))
            unset($this->params[$attribute]);
		return $this;
    }
  
    public function issetParam($params)
    {
        return isset($this->params[$params]);
    }
    
    public function cleanParams()
    {
        unset($this->params);
        $this->params=[];
    }
    

    public function setOrder($attribute, $value)
    {//strtoupper
        $this->orders[$attribute] = ($value);
        return $this;
    }
    public function getOrder($attribute)
    {
        if($this->issetOrders($attribute))
		return $this->orders[$attribute];
    }
    public function unOrder($attribute)
    {
        if($this->issetOrders($attribute))
            unset($this->orders[$attribute]);
		return $this;
    }
  
    public function issetOrder($params)
    {
        return isset($this->orders[$params]);
    }

    public function cleanOrders()
    {
        unset($this->orders);
    }

    public function addOrder($field)
    {
        array_push($this->orders,$field);
    }

    public function setOrders($newOrders)
    {
        unset($this->orders);
        $this->orders=$newOrders;
    }

    public function getOrders()
    {
        return $this->orders;
    }
    
    public function cleanGroups()
    {
        unset($this->groups);
    }

    public function addGroups($field)
    {
        array_push($this->groups,$field);
    }

    public function setGroups($newGroups)
    {
        unset($this->fields);
        $this->fields=$newGroups;
    }

    public function getGroups()
    {
        return $this->groups;
    }


	public function setHaving($attribute, $value)
    {//strtoupper
        $this->having[$attribute] = ($value);
        return $this;
    }
    public function getHaving($attribute)
    {
        if($this->issetHaving($attribute))
		return $this->having[$attribute];
    }
    public function unHaving($attribute)
    {
        if($this->issetHaving($attribute))
            unset($this->having[$attribute]);
		return $this;
    }
  
    public function issetHaving($attribute)
    {
        return isset($this->having[$attribute]);
    }
    
	public function setRowCount($value)
    {//strtoupper
        $this->limit["row_count"] = $value;
        return $this;
    }
    public function getRowCount()
    {
        if(isset($this->limit["row_count"]))
		return $this->limit["row_count"];
    }

	public function setPage($value)
    {//strtoupper
        $this->limit["page"] = $value;
        return $this;
    }
    public function getPage()
    {
        if(isset($this->limit["page"]))
		return $this->limit["row_count"];
    }
    public  function save()
    {
        try
        {
            if((!$this->issetParam(self::id))||($this->getParam(self::id)=="")){
                $result=DAOqueryInsert($this->table,$this->params);
                if(strrpos($result,"Error")!=-1) {
					return DAOquerySelectLast($this->table,$this->fields,$this->joins);
                }
            }
            else {
				$conditions_params=array(self::id=>$this->params[self::id]);
				$params=array_diff_key($this->params,$conditions_params);
				if(strrpos(DAOqueryUpdate($this->table,$params,$conditions_params),"Error")!=-1)
					return DAOquerySelectById($this->table,$this->fields,$this->joins,$this->params[self::id]);
			}
        }
        catch(Exception $Errorr){
        }
    } 
	
	public  function create()
    {
        try
        {
			if(strrpos((DAOqueryInsert($this->table,$this->params)),"Error")!=-1) 
				return DAOquerySelectLast($this->table,$this->fields,$this->joins);
        }
        catch(Exception $Errorr){}
    }
	
	public  function update()
    {
        try
        {
			$conditions_params=array(self::id=>$this->getParam(self::id));
			$params=array_diff_key($this->getParams(),$conditions_params);
			if(strrpos(DAOqueryUpdate($this->table,$params,$conditions_params),"Error")!=-1)
				return DAOquerySelectById($this->table,$this->fields,$this->joins,$this->getParam(self::id));
        }
        catch(Exception $Errorr){}
    }
	
    public  function findLikeHave(){
        $conditionsParams=$this->getParams();
		foreach ($conditionsParams as $conditions_key => $conditions_value){
		    $conditionsParams[$conditions_key]=["like"=>"%".$conditions_value."%"];
		}
		$this->setParams($conditionsParams);
		return $this->find();
    }
    public  function find()
      {
        try{
            $list=array();
            $title=array();
			$recordsCount=0;
            $result_count=DAOquerySelect($this->table,array("count(".$this->table.".".self::id.") as countID"),$this->joins,$this->params,$this->groups,$this->having,$this->orders,null);
			if(isset($result_count["elements"])){
                $recordsCount=($result_count["elements"][0]["countID"]);
			}
			$orders=[];
			$conditionsParams=$this->getParams();
            $result=DAOquerySelect($this->table,$this->fields,$this->joins,$conditionsParams,$this->groups,$this->having,$this->orders,$this->limit);
			$startRecord=1;
			$endRecord=$recordsCount;
			$pages=1;
			$foot=$startRecord." - ".$endRecord." | $pages/$recordsCount";
			if(is_array($this->limit)&&(count($this->limit)>0)){
				$startRecord=intval($this->limit["page"])*intval ($this->limit["row_count"])+1;
				$endRecord=(intval($this->limit["page"])+1)*intval($this->limit["row_count"]);
				if($recordsCount<$endRecord)
					$endRecord=$recordsCount;
				$pages=ceil((floatval ($recordsCount))/(floatval($this->limit["row_count"])));
				$foot=$startRecord." - ".$endRecord." | $pages/".$this->limit["row_count"];
			}
			if(!is_array($result))
			    $result=["elements"=>[]];
			$result["foot"]=$foot;
			$result["recordsCount"]=$recordsCount;
        	return $result;
        }catch(Exception $Errorr){}
    }
					 
	public  function findById($id)
    {
        try{
            $list=array();
        	return DAOquerySelectById($this->table,$this->fields,$this->joins,$id);
        }catch(Exception $Errorr){}
    }
	
    public  function all()
    {
        try{
            $list=array();
            $title=array();
			$recordsCount=0;
			$this->params=addConditionalOperatorInConditionParams($this->params,"%.%");
			$this->params=["or"=>$this->params];
            $result_count=DAOquerySelect($this->table,array("count(".$this->table.".".self::id.") as countID"),$this->joins,$this->params,$this->groups,$this->having,$this->orders,null);
			if(isset($result_count["elements"])){
                $recordsCount=($result_count["elements"][0]["countID"]);
			}
			$orders=[];
            $result=DAOquerySelect($this->table,$this->fields,$this->joins,$this->params,$this->groups,$this->having,$this->orders,$this->limit);
			$startRecord=1;
			$endRecord=$recordsCount;
			$pages=1;
			$foot=$startRecord." - ".$endRecord." | $pages/$recordsCount";
			if(isset($this->limit)){
				$startRecord=intval($this->limit["page"])*intval ($this->limit["row_count"])+1;
				$endRecord=(intval($this->limit["page"])+1)*intval($this->limit["row_count"]);
				if($recordsCount<$endRecord)
					$endRecord=$recordsCount;
				$pages=ceil((floatval ($recordsCount))/(floatval($this->limit["row_count"])));
				$foot=$startRecord." - ".$endRecord." | $pages/".$this->limit["row_count"];
			}
			if(!is_array($result))
    		    $result=["elements"=>[]];
			$result["foot"]=$foot;
			$result["recordsCount"]=$recordsCount;
        	return $result;
        }catch(Exception $Errorr){}
    }
   
    public  function destroy($id)
    {   
        $list=array();
        try{
            $conditions_params=array(self::id=>$id);
            DAOqueryDelete($this->table,$conditions_params);
    	    $result=DAOquerySelectById($this->table,$this->fields,$this->joins,$id);
			if(isset($result["elements"]))
				$list=$result["elements"];
        }catch(Exception $Error){}
        if(count($list)==0)
		    $this->json_exit =  (array("success"));
		else
		    $this->json_exit =  (array("error"));
	    return $this->json_exit;
    }
	
}
?>