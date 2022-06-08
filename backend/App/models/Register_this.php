<?php

namespace App\models;
defined("APPPATH") or die("Access denied");

use \Core\Database;
class Register
{

//     public static function getUserRegister($email){
//         $mysqli = Database::getInstance(true);
//         $query =<<<sql
//         SELECT r.*, p.pais, e.estado
//         FROM registrados r 
//         INNER JOIN paises p
//         ON p.id_pais = r.id_pais
//         INNER JOIN estados e
//         ON e.id_estado = r.id_estado
//         WHERE email = '$email'
// sql;

//         return $mysqli->queryAll($query);
//     }

    public static function getUserRegister($email){
      $mysqli = Database::getInstance(true);
      $query =<<<sql
      SELECT uad.*, p.pais, e.estado
        FROM utilerias_administradores uad 
        INNER JOIN paises p
        ON p.id_pais = uad.id_nationality
        INNER JOIN estados e
        ON e.id_estado = uad.id_state
        WHERE usuario = '$email'
sql;

      return $mysqli->queryAll($query);
  }

//     public static function getUser($email){
//       $mysqli = Database::getInstance(true);
//       $query =<<<sql
//       SELECT * FROM registrados  WHERE email = '$email'
// sql;

//       return $mysqli->queryAll($query);
//   }

  public static function getUser($email){
    $mysqli = Database::getInstance(true);
    $query =<<<sql
    SELECT * FROM registrados  WHERE email = '$email'
sql;

    return $mysqli->queryAll($query);
}

  public static function getUserByClave($clave){
    $mysqli = Database::getInstance(true);
    $query =<<<sql
    SELECT * FROM registrados  WHERE clave = '$clave'
sql;

    return $mysqli->queryAll($query);
}

    public static function getUserRegistrate($email){
      $mysqli = Database::getInstance(true);
      $query =<<<sql
      SELECT * FROM utilerias_asistenes WHERE email = '$email'
sql;

      return $mysqli->queryAll($query);
  }

  public static function getUserRegisterTrue($email){
    $mysqli = Database::getInstance(true);
    $query =<<<sql
    SELECT * FROM registros_acceso WHERE email = '$email' and politica is NULL
sql;

    return $mysqli->queryAll($query);
}

    public static function update($registro){
        $mysqli = Database::getInstance(true);
        $query=<<<sql
      UPDATE registros_acceso SET code = :code WHERE email = :email
sql;
        $parametros = array(
            ':code'=>$registro->_code,
            ':email'=>$registro->_email
        );
        $accion = new \stdClass();
        $accion->_sql= $query;
        $accion->_parametros = $parametros;
        $accion->_id = $registro->_email;
        return $mysqli->update($query, $parametros);
    }

    public static function updatePolitica($registro){
      $mysqli = Database::getInstance(true);
      $query=<<<sql
    UPDATE registros_acceso SET politica = :politica WHERE email = :email
sql;
      $parametros = array(
          ':politica'=>$registro->_politica,
          ':email'=>$registro->_email
      );
      $accion = new \stdClass();
      $accion->_sql= $query;
      $accion->_parametros = $parametros;
      $accion->_id = $registro->_email;
      return $mysqli->update($query, $parametros);
  }

    public static function updateImg($user){
        $mysqli = Database::getInstance(true);
        // var_dump($user);
        $query=<<<sql
        UPDATE registrados SET avatar_img = ''  WHERE email = :email;
sql;
        $parametros = array(
          ':email'=>$user->_email
        );
  
  
          $accion = new \stdClass();
          $accion->_sql= $query;
          $accion->_parametros = $parametros;
          $accion->_id = $user->_administrador_id;
          // UtileriasLog::addAccion($accion);
         $mysqli->update($query, $parametros);



        $query1=<<<sql
        UPDATE registrados SET avatar_img = :img  WHERE email = :email;
sql;
        $parametros1 = array(
          ':img'=>$user->_img,
          ':email'=>$user->_email
          
        );
  
  
          $accion = new \stdClass();
          $accion->_sql= $query1;
          $accion->_parametros = $parametros1;
          $accion->_id = $user->_administrador_id;
          // UtileriasLog::addAccion($accion);
          return $mysqli->update($query1, $parametros1);
      }

      public static function getPais(){       
        $mysqli = Database::getInstance();
        $query=<<<sql
        SELECT * FROM paises
sql;
        return $mysqli->queryAll($query);
      }

      public static function getStateByCountry($id_pais){
        $mysqli = Database::getInstance(true);
        $query =<<<sql
        SELECT * FROM estados where id_pais = '$id_pais'
sql;
      
        return $mysqli->queryAll($query);
      }

      public static function getAllEspecialidades(){
        $mysqli = Database::getInstance();
        $query=<<<sql
        SELECT * FROM especialidades
sql;
        return $mysqli->queryAll($query);
        
    }

}
