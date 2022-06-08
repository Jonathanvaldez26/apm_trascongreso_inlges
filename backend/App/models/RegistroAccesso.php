<?php
namespace App\models;
defined("APPPATH") OR die("Access denied");

use \Core\Database;
use \Core\MasterDom;
use \App\interfaces\Crud;
// use \App\controllers\UtileriasLog;

class RegistroAcceso{


    public static function update($user){
      $mysqli = Database::getInstance(true);
      $query=<<<sql
      UPDATE registros_acceso SET id_linea_principal = :id_linea_principal, nombre = :nombre, segundo_nombre = :segundo_nombre, apellido_materno = :apellido_materno, apellido_paterno = :apellido_paterno, genero = :genero, fecha_nacimiento = :fecha_nacimiento, telefono = :telefono, alergias = :alergias WHERE email = :email;
sql;
      $parametros = array(
        ':id_linea_principal'=>$user->_linea_principal,
        ':nombre'=>$user->_nombre,
        ':segundo_nombre'=>$user->_segundo_nombre,
        ':apellido_paterno'=>$user->_apellido_paterno,
        ':apellido_materno'=>$user->_apellido_materno,
        ':genero'=>$user->_genero,
        ':fecha_nacimiento'=>$user->_fecha_nacimiento,
        ':telefono'=>$user->_telefono,
        ':alergias'=>$user->_alergias,
        ':email'=>$user->_email
        
      );


        $accion = new \stdClass();
        $accion->_sql= $query;
        $accion->_parametros = $parametros;
        $accion->_id = $user->_administrador_id;
        // UtileriasLog::addAccion($accion);
        return $mysqli->update($query, $parametros);
    }

    public static function getDataUser($user){
      $mysqli = Database::getInstance(true);
      $query=<<<sql
      SELECT * FROM registros_acceso WHERE email = '$user'
sql;
      return $mysqli->queryOne($query);
  }


    
}
