<?php

namespace App\Core;

use PDO;

class Model {

    private static $conexion;
    
    public static function getConn(){

        try {
            if(!isset(self::$conexion)){
                self::$conexion = new PDO("mysql:host=db;port=3306;dbname=dbname;", "root", "root123");
            }
        } catch (\PDOException $e) {
            print "Error: " . $e->getMessage();
        }
   
        return self::$conexion;
    }

}
