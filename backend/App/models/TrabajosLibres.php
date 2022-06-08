<?php
namespace App\models;
defined("APPPATH") OR die("Access denied");

use \Core\Database;
use \Core\MasterDom;
use \App\interfaces\Crud;
use \App\controllers\UtileriasLog;

class TrabajosLibres{
   
  public static function getTableTrabajosLibres()
  {
      $mysqli = Database::getInstance(true);
      $query =<<<sql
      SELECT *
      FROM trabajos_libres
sql;
      return $mysqli->queryAll($query);
  }

  public static function getTableTrabajosLibresGrupo1()
  {
      $mysqli = Database::getInstance(true);
      $query =<<<sql
      SELECT *
      FROM trabajos_libres
      WHERE grupo = 1
      ORDER BY no_poster ASC
sql;
      return $mysqli->queryAll($query);
  }

  public static function getTableTrabajosLibresGrupo2()
  {
      $mysqli = Database::getInstance(true);
      $query =<<<sql
      SELECT *
      FROM trabajos_libres
      WHERE grupo = 2
      ORDER BY no_poster ASC
sql;
      return $mysqli->queryAll($query);
  }

  public static function getlike($id_trabajo, $registrado){
    $mysqli = Database::getInstance();
    $query=<<<sql
      SELECT * 
      FROM likes_trabajos
      WHERE id_registrado = $registrado AND id_trabajo = '$id_trabajo'
sql;
    return $mysqli->queryOne($query);
  }

  public static function getlikeOne($registrado){
    $mysqli = Database::getInstance();
    $query=<<<sql
      SELECT * 
      FROM likes_trabajos
      WHERE id_registrado = $registrado
sql;
    return $mysqli->queryOne($query);
  }

  public static function getTrabajoByClave($clave){
    $mysqli = Database::getInstance();
    $query=<<<sql
    SELECT * 
    FROM trabajos_libres 
    WHERE clave = '$clave'
sql;
    return $mysqli->queryOne($query);
  }

  public static function insertLike($trabajo,$registrado){
    // $fecha_carga_documento = date("Y-m-d");
    $mysqli = Database::getInstance(1);
    $query=<<<sql
    INSERT INTO likes_trabajos(id_like_trabajo, id_registrado, id_trabajo, status) 
    VALUES (null,'$registrado','$trabajo','1')
sql;

  $id = $mysqli->insert($query);

  //UtileriasLog::addAccion($accion);
  return $id;
    // return "insert"+$data;
}

}