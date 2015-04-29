<?php
ini_set('display_errors','1'); error_reporting(E_ALL);
session_start();
include "restaurants_model.php";
include "restaurants_view.php";

function dump($var){
    echo "<pre>".var_dump($var)."</pre>";
}

class Controller{
    private $view;
    private $model;
    public function __construct(){
        $this->view = View::getInstance();
        $this->model = Model::getInstance();
    }
    
    public function exec($arg){
        if(empty($_POST)){
            $this->view->SHOW("default");
            return;
        }
        switch($arg["command"]){
            case "add":
                $this->model->addData($arg);
                $this->view->SHOW("default");
                break;
            case "delete":
                if($this->model->deleteData($arg) == ERROR){
                    echo "delete unsuccessful";
                }else{
                    echo "delete successful";
                }
                break;
            case "edit":
                if($this->model->editData($arg) == ERROR){
                    echo "update unsucessful";
                }else{
                    echo "update successful";
                }
                break;
            default:
                return;
        }
    }
}

$controller = new Controller();
$controller->exec($_POST);
?>