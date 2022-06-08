<?php
namespace App\models;
defined("APPPATH") OR die("Access denied");

use \Core\Database;
use \App\interfaces\Crud;

class LineaGeneral{


    public static function getLineaPrincialAll(){
        $mysqli = Database::getInstance(true);
        $query =<<<sql
        SELECT * FROM especialidades
sql;

        return $mysqli->queryAll($query);
    }

    public static function getPais(){
        $mysqli = Database::getInstance(true);
        $query =<<<sql
        SELECT * FROM especialidades
sql;

        return $mysqli->queryAll($query);
    }
}
