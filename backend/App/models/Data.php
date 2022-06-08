<?php

namespace App\models;

defined("APPPATH") or die("Access denied");

use \Core\Database;
use \Core\MasterDom;
use \App\interfaces\Crud;
use \App\controllers\UtileriasLog;

class Data
{

  public static function update($user)
  {
    $mysqli = Database::getInstance(true);
    $query = <<<sql
    UPDATE registros_acceso SET especialidad = :especialidad, nombre = :nombre, segundo_nombre = :segundo_nombre, apellido_materno = :apellido_materno, apellido_paterno = :apellido_paterno, genero = :genero, pais = :pais, telefono = :telefono, alergia = :alergia, alergia_cual = :alergia_cual, politica = 1  WHERE email = :email;
sql;
    $parametros = array(
      ':especialidad' => $user->_especialidad,
      ':nombre' => $user->_nombre,
      ':segundo_nombre' => $user->_segundo_nombre,
      ':apellido_paterno' => $user->_apellido_paterno,
      ':apellido_materno' => $user->_apellido_materno,
      ':genero' => $user->_genero,
      ':pais' => $user->_pais,
      ':telefono' => $user->_telefono,
      ':alergia' => $user->_alergia,
      ':alergia_cual' => $user->_alergia_cual,
      ':email' => $user->_email

    );


    $accion = new \stdClass();
    $accion->_sql = $query;
    $accion->_parametros = $parametros;
    $accion->_id = $user->_administrador_id;
    // UtileriasLog::addAccion($accion);
    return $mysqli->update($query, $parametros);
  }

  public static function updateAccount($user)
  {
    $mysqli = Database::getInstance(true);
    $query = <<<sql
    UPDATE utilerias_administradores SET specialties = :especialidad, name_user = :nombre, middle_name = :segundo_nombre ,surname = :apellido_paterno, second_surname = :apellido_materno, telephone = :telefono, international_code = :international_code,id_nationality = :id_pais, 	id_state = :id_estado, specialties = :especialidad  WHERE usuario = :email;
sql;
    $parametros = array(
      ':nombre' => $user->_nombre,
      ':segundo_nombre'=>$user->_segundo_nombre,
      ':apellido_paterno' => $user->_apellido_paterno,
      ':apellido_materno' => $user->_apellido_materno,
      ':id_estado' => $user->_estado,
      ':id_pais' => $user->_pais,
      ':international_code' => $user->_cod_telefono,
      ':telefono' => $user->_telefono,
      ':especialidad' => $user->_especialidad,
      ':email' => $user->_email

    );


    $accion = new \stdClass();
    $accion->_sql = $query;
    $accion->_parametros = $parametros;
    $accion->_id = $user->_administrador_id;
    // UtileriasLog::addAccion($accion);
    return $mysqli->update($query, $parametros);
  }

  public static function updateAccountFiscal($user)
  {
    $mysqli = Database::getInstance(true);
    $query = <<<sql
    UPDATE utilerias_administradores SET business_name_iva = :business_name_iva, code_iva = :code_iva, payment_method_iva = :payment_method_iva,postal_code_iva = :postal_code_iva, email_receipt_iva = :email_receipt_iva  WHERE usuario = :email_user;
sql;
    $parametros = array(
      ':business_name_iva' => $user->_business_name_iva,
      ':code_iva'=>$user->_code_iva,
      ':payment_method_iva' => $user->_payment_method_iva,
      ':postal_code_iva' => $user->_postal_code_iva,
      ':email_receipt_iva' => $user->_email_receipt_iva,      
      ':email_user' => $user->_email_user

    );



    // $accion = new \stdClass();
    // $accion->_sql = $query;
    // $accion->_parametros = $parametros;
    // $accion->_id = $user->_administrador_id;
    // UtileriasLog::addAccion($accion);
    return $mysqli->update($query, $parametros);
  }

  public static function updateSatatusDatos($user)
  {
    $mysqli = Database::getInstance(true);
    $query = <<<sql
    UPDATE registrados SET datos = 1 WHERE email = :email;
sql;

    $parametros = array(
      ':email' => $user->_email
    );
    return $mysqli->update($query, $parametros);
  }

  public static function insert($register)
  {
    $mysqli = Database::getInstance();
    $query = <<<sql
        INSERT INTO utilerias_asistentes VALUES(null,:id_registro_acceso,:usuario,:contrasena,:politica,1)                        
sql;

    $parametros = array(
      ':id_registro_acceso' => $register->_id_registro_acceso,
      ':usuario' => $register->_email,
      ':contrasena' => $register->_password,
      ':politica' => $register->_politica
    );

    $id = $mysqli->insert($query, $parametros);
    $accion = new \stdClass();
    $accion->_sql = $query;
    $accion->_parametros = $parametros;
    $accion->_id = $id;

    return $id;
  }

  public static function getInfoUserById($id)
  {
    $mysqli = Database::getInstance(true);
    $query = <<<sql
        SELECT * FROM registrados
        WHERE id_registrado = $id
sql;

    return $mysqli->queryOne($query);
  }
}
