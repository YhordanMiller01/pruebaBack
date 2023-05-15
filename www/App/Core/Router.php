<?php

namespace App\Core;

class Router{

    private $controller;

    private $method;

    private $controllerMethod;

    private $params = [];

    function __construct(){
        
        $url = $this->parseURL();

        if(file_exists("../App/Controllers/" . ucfirst($url[2]) . ".php")){

            $this->controller = $url[2];
            unset($url[2]);

        }elseif(empty($url[2])){

            echo "Hola Api Rest";

            exit;

        }else{
            http_response_code(404);
            echo json_encode(["erro" => "Recurso no encontrado"]);

            exit;
        }

        require_once "../App/Controllers/" . ucfirst($this->controller) . ".php";

        $this->controller = new $this->controller;

        $this->method = $_SERVER["REQUEST_METHOD"];

        switch($this->method){
            case "GET":

                if(isset($url[2])){
                    $this->controllerMethod = "find";
                    $this->params = [$url[2]];
                }else{
                    $this->controllerMethod = "index";
                }
                
                break;

            case "POST":
                $this->controllerMethod = "store";
                break;

            case "PUT":
                $this->controllerMethod = "update";
                if(isset($url[3]) && is_numeric($url[3])){
                    $this->params = [$url[3]];
                }else{
                    http_response_code(400);
                    echo json_encode(["erro" => "Es necesario un id, que exista"]);
                    exit;
                }
                break;

            case "DELETE":
                $this->controllerMethod = "delete";
                if(isset($url[3]) && is_numeric($url[3])){
                    $this->params = [$url[3]];
                }else{
                    http_response_code(400);
                    echo json_encode(["erro" => "Es necesario un id, que exista"]);
                    exit;
                }
                break;

            default: 
                echo "Método no soportado";
                exit;
                break;
        }

        call_user_func_array([$this->controller, $this->controllerMethod], $this->params);
        
    }

    private function parseURL(){
        return explode("/", $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"]);
    }

}