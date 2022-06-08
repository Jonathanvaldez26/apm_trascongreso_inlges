<?php
namespace App\models;
defined("APPPATH") OR die("Access denied");

use \Core\Database;
use \App\interfaces\Crud;

class Login{

    public static function getById($usuario){
        $mysqli = Database::getInstance(true);
        $query =<<<sql
        SELECT ua.*, ra.nombre FROM utilerias_asistentes ua INNER JOIN registros_acceso ra WHERE ua.id_registro_acceso = ra.id_registro_acceso and ua.usuario LIKE :usuario
sql;
        $params = array(
            ':usuario'=> $usuario->_usuario,
            // ':password'=>$usuario->_password
        );

        return $mysqli->queryOne($query,$params);
    }

    public static function getUserRAById($usuario){
        $mysqli = Database::getInstance(true);
        $query =<<<sql
        SELECT * FROM utilerias_administradores
        WHERE usuario LIKE :usuario
sql;
        $params = array(
            ':usuario'=> $usuario->_usuario,
            // ':password'=>$usuario->_password
        );

        return $mysqli->queryOne($query,$params);
        
    }

    public static function getAllUsers(){
        $mysqli = Database::getInstance(true);
        $query =<<<sql
        SELECT r.*
        FROM registrados r
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

      public static function insert($data){
        $mysqli = Database::getInstance(1);
        $query=<<<sql
        INSERT INTO registrados(nombre, apellidop, apellidom, email, prefijo, especialidad, telefono, id_pais, id_estado,identificador)
        VALUES(:nombre, :apellidop,:apellidom, :email, :prefijo, :especialidad, :telefono, :pais, :estado, :identificador);
  sql;
  
            $parametros = array(
  
            ':nombre'=>$data->_nombre,
            ':apellidop'=>$data->_apellidop,
            ':apellidom'=>$data->_apellidom,
            ':email'=>$data->_email,
            ':prefijo'=>$data->_prefijo,
            ':especialidad'=>$data->_especialidad,
            ':telefono'=>$data->_telefono,
            ':pais'=>$data->_pais,
            ':estado'=>$data->_estado,
            ':identificador'=>$data->_identificador
  
            );
            $id = $mysqli->insert($query,$parametros);
            return $id;
          
      }

    public static function getFreeCourses(){
        $mysqli = Database::getInstance(true);
        $query =<<<sql
        SELECT *
        FROM cursos
        WHERE free = 1
sql;

        return $mysqli->queryAll($query);
    }

//     public static function getAsignaCurso($usuario){
//         $mysqli = Database::getInstance(true);
//         $query =<<<sql
//         SELECT r.*
//         FROM registrados r  
//         WHERE r.email = '$usuario'
// sql;

//         return $mysqli->queryAll($query);
//     }

    public static function insertCursos($registrado, $curso){
        $mysqli = Database::getInstance(1);
        $query=<<<sql
        INSERT INTO asigna_curso (
            id_asigna_curso, 
            id_registrado, 
            id_curso, 
            fecha_asignacion,
            tiene_escala,
            status)

        VALUES (
            null, 
            $registrado, 
            $curso, 
            NOW(), 
            1)
sql;
        // $parametros = array(
        //     ':utilerias_asistentes_id'=>$data->_utilerias_asistentes_id,
        //     ':utilerias_administradores_id'=>$data->_utilerias_administradores_id,
        //     ':clave'=>$data->_clave,
        //     ':escala'=>$data->_escala,
        //     ':url'=>$data->_url,
        //     ':nota'=>$data->_notas
        // );

        $id = $mysqli->insert($query);

        // $accion = new \stdClass();
        // $accion->_sql= $query;
        // $accion->_id_asistente = $data->_utilerias_asistentes_id;
        // $accion->_titulo = "Pase de abordar";
        // $accion->_descripcion = 'Un ejecutivo ha cargado su '.$accion->_titulo;
        // $accion->_id = $id;

        $log = new \stdClass();
        $log->_sql= $query;
        // $log->_parametros = $parametros;
        $log->_id = $id;
    
    return $id;

}

    public static function getUser($usuario){
        $mysqli = Database::getInstance(true);
        $query =<<<sql
        SELECT *
        FROM utilerias_administradores  
        WHERE usuario = '$usuario'
sql;

        return $mysqli->queryAll($query);
    }

    public static function getUserByEmail($email){
        $mysqli = Database::getInstance(true);
        $query =<<<sql
        SELECT *
        FROM utilerias_administradores 
        WHERE usuario = '$email'
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

    public static function getPais(){       
        $mysqli = Database::getInstance();
        $query=<<<sql
        SELECT * FROM paises
sql;
        return $mysqli->queryAll($query);
      }

//     public static function getUser($usuario){
//         $mysqli = Database::getInstance(true);
//         $query =<<<sql
//         SELECT * FROM utilerias_asistentes WHERE usuario = '$usuario'
// sql;

//         return $mysqli->queryAll($query);
//     }
}
