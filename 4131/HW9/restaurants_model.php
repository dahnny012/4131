<?php
define("ERROR", 0);
define("SUCCESS",1);

class Model{
    private $db;
    private $model;
    private $template;
    public $error = "";
    private $security;
    private function __construct(){
        include "database.php";
        $this->template = file_get_contents("templates/restaurant_row.html");
        $this->db = $db;
    }
    
    public static function getInstance(){
        static $instance = null;
        if ($instance == null){
            $instance = new Model();
        }
        return $instance;
    }
    
    public function editData($data){
        unset($data["command"]);
        $edit = $this->db->prepare($this->generateUpdateSql($data));
        $values = array_keys($data);
        foreach($values as $key){
            $target = ":$key";
            $data[$key] = Security::check($data[$key],$key);
            if(!empty($data[$key])){
                $edit->bindParam($target,$data[$key]);
            }else{
                return ERROR;
            }
        }
        $edit->execute();
        if($edit->rowCount() < SUCCESS){
            return ERROR;
        }
    }
    
    public function getData(){
        $data = $this->db->prepare("SELECT * FROM tbl_restaurants");
        $data->execute();
        $buffer ="";
        while($row = $data->fetch(PDO::FETCH_ASSOC)){
            $buffer .= $this->format($row);
        }
        return $buffer;
    }
    
    public function addData($data){
        unset($data["command"]);
        $sql = $this->generateAddSql($data);
        if(!empty($sql)){
            $add = $this->db->prepare($sql);
            $count =1;
            $values = array_keys($data);
            foreach($values as $key){
				$data[$key] = Security::check($data[$key],$key);
				if(empty($data[$key])){
					return ERROR;
				}
				$add->bindParam($count,$data[$key]);
				$count++;
            }
            $add->execute();
            if($add->rowCount() < 1){
                return error("Restaurant may already exist");
            }
        }
    }
    
    public function deleteData($data){
        $name = trim($data["name"]);
        $delete = $this->db->prepare("DELETE FROM tbl_restaurants where res_name = ?");
        echo $name;
        $delete->bindParam(1,$name);
        $delete->execute();
        if($delete->rowCount() < 1){
            return ERROR;
        }
    }
    
    public function format($row){
        $values = array_keys($row);
        $buffer = $this->template;
        foreach($values as $key){
            $regex = "/{{".$key."}}/";
            $buffer = preg_replace($regex,$row[$key],$buffer);
        }
        return $buffer;
    }
    
    public function generateAddSql($data){
        $values = array_keys($data);
        /*
        INSERT INTO table_name (column1,column2,column3,...)
        VALUES (value1,value2,value3,...);
        */
        $SQL = "INSERT INTO tbl_restaurants (";
        $buffer = ") VALUES (";
        foreach($values as $key){
            if(Security::check($data[$key],$key)){
                $buffer .= "?,";
                $key = "res_".$key;
                $SQL .= $key.",";
            }else{
                return "";
            }
        }
        $SQL = rtrim($SQL, ",");
        $buffer = rtrim($buffer, ",");
        $buffer .= ")";
        return $SQL.$buffer;
    }
    
    
    public function generateUpdateSql($data){
        $sql = "UPDATE tbl_restaurants SET res_name = :name,".
        "res_type = :type,".
        "res_phone = :phone,".
        "res_ratings = :ratings,".
        "res_url = :url,".
        "res_address = :address,".
        "res_hours = :hours ".
        "Where res_name = :name";
        return $sql;
    }
}

function error($err){
    $_SESSION['error'] = $err;
    return ERROR;
}

class Security{
    private static $urlRegex = "/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/";
    private static $phoneRegex = "/^[0-9]{3}-[0-9]{3}-[0-9]{4}$/";
    private static $ratingRegex = "/^\d+(\.)?\d*$/";
    private static $initialized = false;
    
    private static function initialize()
    {
    	if (self::$initialized)
    		return;
    	self::$initialized = true;
    }
    public static function check($input,$type){
        $input = trim($input);
        if(empty($input)){
            return error("Enter Non-Empty Values");
        }
        switch($type){
            case "url":
                if(!preg_match(self::$urlRegex,$input)){
                    error("Enter a Valid Url");
                    return "";
                 }
                break;
            case "phone":
                if(!preg_match(self::$phoneRegex,$input)){
                    return error("Enter a Valid Phone Number");
                    return "";
                }
                break;
            case "ratings":
                if(!preg_match(self::$ratingRegex,$input)){
                    return error("Enter a Valid Rating");
                    return "";
                }
                break;
            default:
                $input = strip_tags($input,"<br></br>");
                $input = nl2br($input);
        }
        return $input;
    } 
}


?>
