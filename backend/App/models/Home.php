<?php
namespace App\models;
defined("APPPATH") OR die("Access denied");

use \Core\Database;
use \Core\MasterDom;
use \App\interfaces\Crud;
use \App\controllers\UtileriasLog;

class Home{

    public static function getCountByUser($id){
      $mysqli = Database::getInstance();
      $query=<<<sql
    SELECT count(*) as count from pickup where utilerias_asistentes_id = '$id';
sql;
      return $mysqli->queryAll($query);
    }

    public static function getCountPickUp($id){
        $mysqli = Database::getInstance();
        $query=<<<sql
        SELECT count(*) as count from pickup where utilerias_asistentes_id = '$id';
sql;
        return $mysqli->queryOne($query);
    }

    public static function getQRById($id){
      $mysqli = Database::getInstance(true);
      $query=<<<sql
      SELECT ra.*
      FROM registros_acceso ra
      INNER JOIN utilerias_asistentes ua
      ON  ra.id_registro_acceso = ua.id_registro_acceso

      WHERE ua.utilerias_asistentes_id = '$id'
sql;
      return $mysqli->queryOne($query);
  }

  public static function getDataUser($user){
    $mysqli = Database::getInstance(true);
    $query=<<<sql
    SELECT * FROM utilerias_administradores WHERE usuario = '$user'
sql;
    return $mysqli->queryOne($query);
  }

  public static function getItinerarioAsistente($id){
    $mysqli = Database::getInstance(true);
    $query=<<<sql
    SELECT 
      i.id_itinerario,
      cao.nombre as aerolinea_origen, 
      caeo.nombre as aerolinea_escala_origen, 
      cad.nombre as aerolinea_destino, 
      caed.nombre as aerolinea_escala_destino,
      i.fecha_escala_salida,
      i.hora_escala_salida,
      i.fecha_escala_regreso,
      i.hora_escala_regreso,
      i.fecha_salida, 
      i.hora_salida, 
      i.fecha_regreso, 
      i.hora_regreso,
      i.nota,        
      a.aeropuerto as aeropuerto_salida, 
      ae.aeropuerto as aeropuerto_escala_salida, 
      aa.aeropuerto as aeropuerto_regreso,
      aae.aeropuerto as aeropuerto_escala_regreso,        
      concat(ra.nombre, " ", ra.segundo_nombre, " ", ra.apellido_paterno, " ", ra.apellido_materno) as nombre 
    FROM itinerario i 
    INNER JOIN catalogo_aerolinea cao on cao.id_aerolinea = i.aerolinea_origen 
    LEFT JOIN catalogo_aerolinea caeo on caeo.id_aerolinea = i.aerolinea_escala_origen
    INNER JOIN catalogo_aerolinea cad on cad.id_aerolinea = i.aerolinea_destino
    LEFT JOIN catalogo_aerolinea caed on caed.id_aerolinea = i.aerolinea_escala_destino
    INNER JOIN aeropuertos a on a.id_aeropuerto = i.aeropuerto_salida 
    LEFT JOIN aeropuertos ae on ae.id_aeropuerto = i.aeropuerto_escala_salida
    INNER JOIN aeropuertos aa on aa.id_aeropuerto = i.aeropuerto_regreso
    LEFT JOIN aeropuertos aae on aae.id_aeropuerto = i.aeropuerto_escala_regreso
    INNER JOIN utilerias_asistentes ua on ua.utilerias_asistentes_id = i.utilerias_asistentes_id 
    INNER JOIN registros_acceso ra on ra.id_registro_acceso = ua.id_registro_acceso
    WHERE ua.utilerias_asistentes_id = $id
    
sql;
    return $mysqli->queryAll($query);
  }


  public static function getAllUsers(){
    $mysqli = Database::getInstance(true);
    $query =<<<sql
    SELECT r.*
    FROM registrados r
sql;

    return $mysqli->queryAll($query);
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

  public static function getAsignaCursoByUser($registrado, $curso){
    $mysqli = Database::getInstance(true);
    $query =<<<sql
    SELECT *
    FROM asigna_curso
    WHERE id_registrado = '$registrado' AND id_curso = '$curso'
sql;

    return $mysqli->queryOne($query);
  }

  public static function insertCursos($registrado, $curso){
    $mysqli = Database::getInstance(1);
    $query=<<<sql
    INSERT INTO asigna_curso (
        id_asigna_curso, 
        id_registrado, 
        id_curso, 
        fecha_asignacion,
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
}