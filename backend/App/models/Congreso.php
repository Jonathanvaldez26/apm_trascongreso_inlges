<?php
namespace App\models;
defined("APPPATH") OR die("Access denied");

use \Core\Database;
use \Core\MasterDom;
use \App\interfaces\Crud;
use \App\controllers\UtileriasLog;

class Congreso{

    public static function getAll(){
      $mysqli = Database::getInstance();
      $query=<<<sql
        SELECT * FROM cursos;
sql;
      return $mysqli->queryAll($query);
    }

    public static function getAllCursosNotInUser($id){
      $mysqli = Database::getInstance();
      $query=<<<sql
      SELECT c.*
      FROM cursos c
      WHERE c.id_curso not in (SELECT id_curso FROM asigna_curso WHERE  id_registrado = $id) ORDER BY c.id_curso ASC
sql;
      return $mysqli->queryAll($query);
    }

    public static function getAllProductCursosNotInUser($id){
      $mysqli = Database::getInstance();
      $query=<<<sql
      SELECT p.*
      FROM productos p
      WHERE p.id_producto not in (SELECT id_producto FROM asigna_producto WHERE  user_id = $id) and p.es_curso = 1 ORDER BY p.id_producto ASC
sql;
      return $mysqli->queryAll($query);
    }

    public static function getAllProductCongresosNotInUser($id){
      $mysqli = Database::getInstance();
      $query=<<<sql
      SELECT p.*
      FROM productos p
      WHERE p.id_producto not in (SELECT id_producto FROM asigna_producto WHERE  user_id = $id) and p.es_congreso = 1 ORDER BY p.id_producto ASC
sql;
      return $mysqli->queryAll($query);
    }

    public static function getProductosPendientesPago($user_id,$id_producto){
      $mysqli = Database::getInstance();
      $query=<<<sql
      SELECT * FROM pendiente_pago WHERE id_producto = $id_producto AND user_id = $user_id 
sql;
      return $mysqli->queryAll($query);
    }

    public static function getProductCart($user_id,$id_producto){
      $mysqli = Database::getInstance();
      $query=<<<sql
      SELECT * FROM carrito WHERE id_producto = $id_producto AND user_id = $user_id and status = 1
sql;
      return $mysqli->queryAll($query);
    }

    public static function insertProductCart($data){
      $mysqli = Database::getInstance();
      $query=<<<sql
      INSERT INTO carrito(id_producto, user_id, status) VALUES ('$data->_id_producto','$data->_user_id',1)
sql;
      $id = $mysqli->insert($query);
   
      return $id;
    }

    public static function getProductsNumber($user_id){
      $mysqli = Database::getInstance();
      $query=<<<sql
      SELECT count(1) as total_productos FROM carrito WHERE user_id = $user_id and status = 1
sql;
      return $mysqli->queryAll($query);

    }

    public static function getCarritoByIdUser($user_id){
      $mysqli = Database::getInstance();
      $query=<<<sql
      SELECT c.id_carrito,pro.id_producto,pro.nombre,pro.precio_publico,pro.precio_socio,pro.tipo_moneda,pro.caratula,pro.es_curso,pro.es_servicio,pro.es_congreso,ua.amout_due,ua.wadd_member,ua.apm_member,ua.APAL,ua.AILANCYP,ua.AMPI,ua.LC
      FROM productos pro
      INNER JOIN carrito c ON(c.id_producto = pro.id_producto)
      INNER JOIN utilerias_administradores ua ON(c.user_id = ua.user_id)
      WHERE c.user_id = $user_id and c.status = 1
sql;
      return $mysqli->queryAll($query);

    } 
    
    public static function getCarritoByIdUserTicket($user_id,$clave){
      $mysqli = Database::getInstance();
      $query=<<<sql
      SELECT c.id_carrito,pro.id_producto,pro.nombre,pro.precio_publico,pro.precio_socio,pro.tipo_moneda,pro.caratula,pro.es_curso,pro.es_servicio,pro.es_congreso,ua.amout_due,ua.wadd_member,ua.apm_member,ua.APAL,ua.AILANCYP,ua.AMPI,ua.LC
      FROM productos pro
      INNER JOIN carrito c ON(c.id_producto = pro.id_producto)
      INNER JOIN utilerias_administradores ua ON(c.user_id = ua.user_id)
      INNER JOIN pendiente_pago pp ON (pp.id_producto = c.id_producto)
      WHERE c.user_id = $user_id AND pp.clave = '$clave'
sql;
      return $mysqli->queryAll($query);

    } 

    public static function getTicketUser($user_id,$clave){
      $mysqli = Database::getInstance();
      $query=<<<sql
      SELECT pro.id_producto,pro.nombre,pro.precio_publico,pro.precio_socio,pro.tipo_moneda,pro.caratula,pro.es_curso,pro.es_servicio,pro.es_congreso,ua.amout_due,ua.wadd_member,ua.apm_member,ua.APAL,ua.AILANCYP,ua.AMPI,ua.LC
      FROM productos pro         
      INNER JOIN pendiente_pago pp ON (pp.id_producto = pro.id_producto)
      INNER JOIN utilerias_administradores ua ON(pp.user_id = ua.user_id)
      WHERE pp.user_id = $user_id AND pp.clave = '$clave'
sql;
      return $mysqli->queryAll($query);

    } 

    public static function deleteItem($id){
      $mysqli = Database::getInstance();
//       $query=<<<sql
//       DELETE FROM carrito WHERE id_carrito = $id
// sql;
    $query=<<<sql
      UPDATE carrito SET status = 0  WHERE id_carrito = $id
sql;  
      return $mysqli->delete($query);

    }  
    

    public static function getProductosPendientesPagoTicket($user_id,$id_producto){
      $mysqli = Database::getInstance();
      $query=<<<sql
      SELECT pp.*, p.nombre 
      FROM pendiente_pago pp
      INNER JOIN productos p ON (pp.id_producto = p.id_producto)
      WHERE pp.id_producto = $id_producto AND pp.user_id = $user_id 
sql;
      return $mysqli->queryAll($query);
    }

    public static function getProductoById($id_producto){
      $mysqli = Database::getInstance();
      $query=<<<sql
      SELECT id_producto,nombre,precio_publico,precio_socio,tipo_moneda 
      FROM productos      
      WHERE id_producto = $id_producto
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

    public static function getVideoCongresoByClave($clave){
      $mysqli = Database::getInstance();
      $query=<<<sql
      SELECT * 
      FROM videos_congreso 
      WHERE clave = '$clave'
sql;
      return $mysqli->queryOne($query);
    }

    public static function getVideoCongresoProgreso($id,$num_curso){
      $mysqli = Database::getInstance(true);
      $query =<<<sql
      SELECT * FROM progresos_productocongreso
      WHERE id_video_congreso = $num_curso AND user_id = $id
sql;
  
      return $mysqli->queryOne($query);
    }


    public static function insertVideoCongresoProgreso($registrado,$curso){
      $mysqli = Database::getInstance(1);
      $query=<<<sql
      INSERT INTO progresos_productocongreso (id_video_congreso, user_id, segundos,fecha_ultima_vista) 
      VALUES ('$curso','$registrado','0', NOW())
sql;
  
    $id = $mysqli->insert($query);
  
    return $id;
  }

    public static function getVideoCongresoByAsignacion($id_registrado,$id_producto){
      $mysqli = Database::getInstance();
      $query=<<<sql
      SELECT p.nombre, uad.name_user as nombre_usuario, ap.* FROM asigna_producto ap
      INNER JOIN utilerias_administradores uad
      ON ap.user_id = uad.user_id
      INNER JOIN productos p
      ON p.id_producto = ap.id_producto      
      WHERE uad.user_id = $id_registrado and p.id_producto = '$id_producto'
sql;
      return $mysqli->queryAll($query);
    }

    public static function getVideoProgreso($id,$num_curso){
      $mysqli = Database::getInstance(true);
      $query =<<<sql
      SELECT * FROM progresos_productocongreso
      WHERE id_video_congreso = $num_curso AND user_id = $id
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

    public static function getPreguntasByProductCursoUsuario($curso){
      $mysqli = Database::getInstance();
      $query=<<<sql
      SELECT pe.*
      FROM preguntas_encuesta_curso pe
      INNER JOIN productos p
      ON p.id_producto = pe.id_producto
      WHERE p.id_producto = $curso
sql;
      return $mysqli->queryAll($query);
    }

//     public static function getTallerById($id){
//       $mysqli = Database::getInstance(true);
//       $query =<<<sql
//       SELECT * FROM cursos
//       WHERE id_curso = $id
// sql;

//       return $mysqli->queryOne($query);
//   }

    public static function getPorductById($id){
      $mysqli = Database::getInstance(true);
      $query =<<<sql
      SELECT * FROM productos
      WHERE id_producto = $id
sql;

    return $mysqli->queryOne($query);
}

    public static function insertAsignaProducto($data){

      $mysqli = Database::getInstance();
      $query = <<<sql
      INSERT INTO asigna_producto (user_id,id_producto,fecha_asignacion,status) VALUES(:user_id,:id_producto,NOW(),1)                        
sql;

      $parametros = array(
          ':user_id' => $data->_user_id,
          ':id_producto' => $data->_id_producto
      );

      $id = $mysqli->insert($query, $parametros);

      return $id;
        
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

    public static function updateLikeProductos($id_curso, $registrado,$status){
      $mysqli = Database::getInstance();
      $query=<<<sql
        UPDATE likes_product_curso SET status = '$status'
        WHERE id_producto = '$id_curso' AND user_id = '$registrado'
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

    public static function getContenidoProdductCursoByAsignacion($id_registrado,$clave_taller){
      $mysqli = Database::getInstance();
      $query=<<<sql
      SELECT p.nombre, uad.name_user as nombre_usuario, ap.* FROM asigna_producto ap
      INNER JOIN utilerias_administradores uad
      ON ap.user_id = uad.user_id
      INNER JOIN productos p
      ON p.id_producto = ap.id_producto      
      WHERE uad.user_id = $id_registrado and p.clave = '$clave_taller'
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

    public static function getlikeProductCurso($id_curso, $registrado){
      $mysqli = Database::getInstance();
      $query=<<<sql
        SELECT * 
        FROM  likes_product_curso
        WHERE user_id = $registrado AND id_producto = '$id_curso'
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

  public static function insertLikeProducto($curso,$registrado){
    // $fecha_carga_documento = date("Y-m-d");
    $mysqli = Database::getInstance(1);
    $query=<<<sql
    INSERT INTO likes_product_curso(id_like, user_id, id_producto, status) 
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

public static function insertRespuestaProductCurso($id_registrado,$id_pregunta_encuesta,$respuesta_registrado){
  $mysqli = Database::getInstance(1);
  $query=<<<sql
    INSERT INTO respuestas_encuesta_productcurso(id_pregunta_encuesta, user_id, respuesta_registrado) 
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

  public static function getRespuestasCurso($id_registrado,$id_curso){
    $mysqli = Database::getInstance();
    $query=<<<sql
      SELECT * 
      FROM respuestas_encuesta_productcurso re
      INNER JOIN preguntas_encuesta_curso pe
      ON pe.id_pregunta_encuesta = re.id_pregunta_encuesta      
      WHERE user_id = $id_registrado and pe.id_producto = $id_curso
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
      WHERE ac.id_registrado = $usuario ORDER BY c.id_curso
sql;

      return $mysqli->queryAll($query);
  }

  public static function getAsignaProducto($usuario){
    $mysqli = Database::getInstance(true);
    $query =<<<sql
    SELECT uad.*, p.nombre AS nombre_curso, p.*
    FROM asigna_producto ap
    INNER JOIN utilerias_administradores uad
    ON ap.user_id = uad.user_id
    INNER JOIN productos p
    ON p.id_producto = ap.id_producto
    WHERE ap.user_id = $usuario and p.es_curso = 1 ORDER BY p.id_producto ASC
sql;

    return $mysqli->queryAll($query);
}

public static function getAsignaProductoCongreso($usuario){
  $mysqli = Database::getInstance(true);
  $query =<<<sql
  SELECT uad.*, p.nombre AS nombre_curso, p.*
  FROM asigna_producto ap
  INNER JOIN utilerias_administradores uad
  ON ap.user_id = uad.user_id
  INNER JOIN productos p
  ON p.id_producto = ap.id_producto
  WHERE ap.user_id = $usuario and p.es_congreso = 1
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

  public static function getProductProgreso($id,$num_curso){
    $mysqli = Database::getInstance(true);
    $query =<<<sql
    SELECT * FROM progresos_productocursos
    WHERE id_producto = $num_curso AND user_id = $id
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

  public static function insertProductCursoProgreso($registrado,$curso){
    $mysqli = Database::getInstance(1);
    $query=<<<sql
    INSERT INTO progresos_productocursos (id_producto, user_id, segundos,fecha_ultima_vista) 
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

  public static function updateProgresoFechaProducto($id_curso, $registrado, $segundos){
    $mysqli = Database::getInstance();
    $query=<<<sql
        UPDATE progresos_productocursos 
        SET segundos = '$segundos', fecha_ultima_vista = NOW()
        WHERE id_producto = '$id_curso' 
        AND user_id = '$registrado'
sql;
    return $mysqli->update($query);
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

  /* Pendiente de Pago */
  public static function inserPendientePago($data){ 
    $mysqli = Database::getInstance(1);
    $query=<<<sql
    INSERT INTO pendiente_pago (id_producto, user_id, reference, clave,fecha, monto, tipo_pago, status,comprado_en) VALUES (:id_producto, :user_id, :reference,:clave,:fecha, :monto, :tipo_pago, :status,1);
sql;

  $parametros = array(
    ':id_producto'=>$data->_id_producto,
    ':user_id'=>$data->_user_id,
    ':reference'=>$data->_reference,
    ':clave'=>$data->_clave,
    ':fecha'=>$data->_fecha,
    ':monto'=>$data->_monto,
    ':tipo_pago'=>$data->_tipo_pago,
    ':status'=>$data->_status
        
  );
  $id = $mysqli->insert($query,$parametros);
  // $accion = new \stdClass();
  // $accion->_sql= $query;
  // $accion->_parametros = $parametros;
  // $accion->_id = $id;

  //UtileriasLog::addAccion($accion);
  return $id;
    // return "insert"+$data;
}
}