<?php
namespace App\models;
defined("APPPATH") OR die("Access denied");

use \Core\Database;
use \Core\MasterDom;
use \App\interfaces\Crud;
use \App\controllers\UtileriasLog;

class Profesores{

    public static function getAll(){
      $mysqli = Database::getInstance();
      $query=<<<sql
        SELECT *
        FROM profesores where internacional = 0 order by nombre
sql;
      return $mysqli->queryAll($query);
    }

    public static function getAllInternacional(){
        $mysqli = Database::getInstance();
        $query=<<<sql
        SELECT *
        FROM profesores where internacional = 1 order by nombre
sql;
        return $mysqli->queryAll($query);
    }

    public static function getById($id){
      return "getById"+$id;
    }

    public static function getCursoByClave($clave){
      $mysqli = Database::getInstance();
      $query=<<<sql
      SELECT * 
      FROM cursos 
      WHERE clave = '$clave'
sql;
      return $mysqli->queryOne($query);
    }

    public static function getPreguntasByCursoUsuario($curso){
      $mysqli = Database::getInstance();
      $query=<<<sql
      SELECT pe.*
      FROM preguntas_encuesta pe
      INNER JOIN cursos c
      ON c.id_curso = pe.id_curso

      WHERE c.id_curso = $curso
sql;
      return $mysqli->queryAll($query);
    }

    public static function getRespuestasPorUsuraioTaller($id_registrado,$id_curso){

      $mysqli = Database::getInstance();
      $query=<<<sql
      SELECT re.*, CONCAT (rs.nombre,' ',rs.apellidop,' ',rs.apellidom) AS nombre_registrado
      FROM respuestas_encuesta re
      INNER JOIN registrados rs
      ON re.id_registrado = rs.id_registrado
      INNER JOIN preguntas_encuesta pe
      ON pe.id_pregunta_encuesta = re.id_pregunta_encuesta
      INNER JOIN cursos c
      ON c.id_curso = pe.id_curso

      WHERE rs.id_registrado = $id_registrado and c.id_curso = $id_curso
sql;
      return $mysqli->queryAll($query);

      
    }

    public static function updateVistasByClave($clave,$vistas){
      $mysqli = Database::getInstance();
      $query=<<<sql
        UPDATE cursos SET vistas = '$vistas'
        WHERE clave = '$clave'
sql;
      return $mysqli->update($query);
    }

    public static function updateLike($id_curso, $registrado,$status){
      $mysqli = Database::getInstance();
      $query=<<<sql
        UPDATE likes SET status = '$status'
        WHERE id_curso = '$id_curso' AND id_registrado = '$registrado'
sql;
      return $mysqli->update($query);
    }

    public static function getContenidoByAsignacion($id_registrado,$clave_taller){
      $mysqli = Database::getInstance();
      $query=<<<sql
      SELECT c.nombre, r.nombreconstancia, ac.* FROM asigna_curso ac
      INNER JOIN registrados r
      ON ac.id_registrado = r.id_registrado
      INNER JOIN cursos c
      ON c.id_curso = ac.id_curso
      
      WHERE r.id_registrado = $id_registrado and c.clave = '$clave_taller'
sql;
      return $mysqli->queryAll($query);
    }

    public static function getByIdUser($id){
      $mysqli = Database::getInstance();
      $query=<<<sql
        SELECT id_prueba_covid, fecha_carga_documento, fecha_prueba_covid, tipo_prueba, resultado, documento, status FROM prueba_covid WHERE utilerias_asistentes_id = $id ORDER BY id_prueba_covid ASC;
sql;
      return $mysqli->queryAll($query);
    }

    public static function getlike($id_curso, $registrado){
      $mysqli = Database::getInstance();
      $query=<<<sql
        SELECT * 
        FROM likes
        WHERE id_registrado = $registrado AND id_curso = '$id_curso'
sql;
      return $mysqli->queryOne($query);
    }


    public static function insertLike($curso,$registrado){
      // $fecha_carga_documento = date("Y-m-d");
      $mysqli = Database::getInstance(1);
      $query=<<<sql
      INSERT INTO likes(id_like, id_registrado, id_curso, status) 
      VALUES (null,'$registrado','$curso','1')
sql;

    $id = $mysqli->insert($query);

    //UtileriasLog::addAccion($accion);
    return $id;
      // return "insert"+$data;
  }


  //-------------------------Encuestas-----------------------------///
  public static function insertRespuesta($id_registrado,$id_pregunta_encuesta,$respuesta_registrado){
    $mysqli = Database::getInstance(1);
    $query=<<<sql
      INSERT INTO respuestas_encuesta(id_pregunta_encuesta, id_registrado, respuesta_registrado) 
      VALUES ('$id_pregunta_encuesta','$id_registrado','$respuesta_registrado')
sql;

    $id = $mysqli->insert($query);
    return $id;
}

  public static function getRespuestas($id_registrado,$id_curso){
    $mysqli = Database::getInstance();
    $query=<<<sql
      SELECT * 
      FROM respuestas_encuesta re
      INNER JOIN preguntas_encuesta pe
      ON pe.id_pregunta_encuesta = re.id_pregunta_encuesta
      
      WHERE id_registrado = $id_registrado and pe.id_curso = $id_curso
sql;
    return $mysqli->queryAll($query);
  }
    public static function insert($data){
        $fecha_carga_documento = date("Y-m-d");
        $mysqli = Database::getInstance(1);
        $query=<<<sql
        INSERT INTO prueba_covid (id_prueba_covid, utilerias_asistentes_id, fecha_carga_documento, fecha_prueba_covid, tipo_prueba, resultado, documento, status) VALUES ('',:utilerias_asistentes_id, :fecha_carga_documento, :fecha_prueba_covid, :tipo_prueba, :resultado, :documento, 0);
sql;

    	$parametros = array(
    		':utilerias_asistentes_id'=>$data->_user,
    		':fecha_carga_documento'=>$fecha_carga_documento,
    		':fecha_prueba_covid'=>$data->_fecha_prueba,
        ':tipo_prueba'=>$data->_tipo_prueba,
        ':resultado'=>$data->_resultado,
        ':documento'=>$data->_url
            
    	);
      $id = $mysqli->insert($query,$parametros);
      $accion = new \stdClass();
      $accion->_sql= $query;
      $accion->_parametros = $parametros;
      $accion->_id = $id;

      //UtileriasLog::addAccion($accion);
      return $id;
        // return "insert"+$data;
    }

    public static function update($data){
        return "update"+$data;
    }

    public static function delete($id){
        return "delete"+$id;
    }

    public static function getAsignaCurso($usuario){
      $mysqli = Database::getInstance(true);
      $query =<<<sql
      SELECT r.*, c.nombre AS nombre_curso, c.*
      FROM asigna_curso ac
      INNER JOIN registrados r
      ON ac.id_registrado = r.id_registrado
      INNER JOIN cursos c
      ON c.id_curso = ac.id_curso

      WHERE ac.id_registrado = $usuario
sql;

      return $mysqli->queryAll($query);
  }

  public static function getProgreso($id,$num_curso){
    $mysqli = Database::getInstance(true);
    $query =<<<sql
    SELECT * FROM progresos_cursos
    WHERE id_curso = $num_curso AND id_registrado = $id
sql;

    return $mysqli->queryOne($query);
  }

  public static function insertProgreso($registrado,$curso){
      $mysqli = Database::getInstance(1);
      $query=<<<sql
      INSERT INTO progresos_cursos (id_curso, id_registrado, segundos,fecha_ultima_vista) 
      VALUES ('$curso','$registrado','0', NOW())
sql;

    $id = $mysqli->insert($query);

    return $id;
  }

  public static function updateProgreso($id_curso, $registrado, $segundos){
      $mysqli = Database::getInstance();
      $query=<<<sql
          UPDATE progresos_cursos 
          SET segundos = '$segundos'
          WHERE id_curso = '$id_curso' 
          AND id_registrado = '$registrado'
sql;
      return $mysqli->update($query);
  }

  public static function updateProgresoFecha($id_curso, $registrado, $segundos){
    $mysqli = Database::getInstance();
    $query=<<<sql
        UPDATE progresos_cursos 
        SET segundos = '$segundos', fecha_ultima_vista = NOW()
        WHERE id_curso = '$id_curso' 
        AND id_registrado = '$registrado'
sql;
    return $mysqli->update($query);
  } 
}