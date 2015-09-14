<?php

class View{
    private $view;
    private $model;
    private function __construct(){
        $this->model = Model::getInstance();
    }
    
    public static function getInstance(){
        static $instance = null;
        if ($instance == null){
            $instance = new View();
        }
        return $instance;
    }
    
    public function SHOW($arg){
        switch($arg){
            default:
                $index = file_get_contents("templates/index.html");
                $data = $this->model->getData();
                $index = preg_replace("/{{data}}/",$data,$index);
                if(!isset($_SESSION["error"])){
                    $_SESSION["error"] = "";
                }
                $index = preg_replace("/{{msg}}/",$_SESSION["error"],$index);
                $_SESSION["error"] = "";
                echo $index;
        }
    }
}



?>