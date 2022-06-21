<?php

namespace App\models;
defined("APPPATH") or die("Access denied");

use \Core\Database;
use \Core\MasterDom;
use \App\interfaces\Crud;
use \App\controllers\UtileriasLog;

class Register
{

    public static function insert($register)
    {
        $mysqli = Database::getInstance();
        $query = <<<sql
        INSERT INTO utilerias_administradores(socio,usuario,title,name_user,middle_name,surname,second_surname,telephone,international_code,id_nationality,specialties,modality,id_state,id_country,organization,position_organization,address,organization_country,organization_postal_code,wadd_member,apm_member,APAL, AILANCYP, AMPI, LC,scholarship,business_name_iva,code_iva,payment_method_iva,email_receipt_iva,postal_code_iva,pay_ticket,status,envio_email,date,method_pay,reference,amout_due,sitio) VALUES(:socio,:usuario,:title,:name_user,:middle_name,:surname,:second_surname,:telephone,:international_code,:id_nationality,:specialties,:modality,:id_state, :id_country,:organization,:position_organization,:address,:organization_country,:organization_postal_code,:wadd_member,:apm_member,:APAL, :AILANCYP, :AMPI, :LC, :scholarship,:business_name_iva,:code_iva,:payment_method_iva,:email_receipt_iva,:postal_code_iva, null, 0,0,now(),:method_pay, :reference, :amout_due,:sitio)                        
sql;

        $parametros = array(
            ':socio' => '',
            ':usuario' => $register->_email,
            ':title' => $register->_title,
            ':name_user' => $register->_name,
            ':middle_name' => $register->_middle_name,
            ':surname' => $register->_surname,
            ':second_surname' => $register->_second_surname,
            ':telephone' => $register->_telephone,
            ':international_code' => $register->_international_code,
            ':id_nationality' => $register->_nationality,
            ':specialties' => $register->_specialties,
            ':modality' => $register->_modality,
            ':id_state' => $register->_state,
            ':method_pay' => $register->_method_pay,
            ':id_country' => $register->_residence,
            ':organization' => $register->_organization,
            ':position_organization' => $register->_position,
            ':address' => $register->_address,
            ':organization_country' => $register->_organization_country,
            ':organization_postal_code' => $register->_organization_postal_code,
            ':wadd_member' => $register->_wadd_member,
            ':apm_member' => $register->_apm_member,
            ':APAL' => $register->_APAL,
            ':AILANCYP' => $register->_AILANCYP,
            ':AMPI' => $register->_AMPI,
            ':LC' => $register->_LC,
            ':scholarship' => '',
            ':business_name_iva' => $register->_business_name_iva,
            ':code_iva' => $register->_code_iva,
            ':payment_method_iva' => $register->_payment_method_iva,
            ':email_receipt_iva' => $register->_email_receipt_iva,
            ':postal_code_iva' => $register->_postal_code_iva,
            ':reference' => $register->_reference_user,
            ':amout_due' => $register->_costo,
            ":sitio" => 1
        );

        $id = $mysqli->insert($query, $parametros);
        $accion = new \stdClass();
        $accion->_sql = $query;
        $accion->_parametros = $parametros;
        $accion->_id = $id;

        return $id;
    }

    public static function getByCost($pais){
        $mysqli = Database::getInstance(true);
        $query =<<<sql
         SELECT c.cost_enero_marzo FROM categorias c 
         JOIN categorias_costos cc ON cc.id_categoria = c.id_categoria 
         WHERE cc.id_pais = $pais;

sql;
        return $mysqli->queryOne($query);
    }

    public static function getUser($email){
        $mysqli = Database::getInstance(true);
        $query =<<<sql
        SELECT * FROM utilerias_administradores  WHERE usuario = '$email'
sql;
    
        return $mysqli->queryAll($query);
    }

    public static function getUserById($id){
        $mysqli = Database::getInstance(true);
        $query =<<<sql
        SELECT * FROM utilerias_administradores  WHERE user_id = '$id'
sql;
    
        return $mysqli->queryAll($query);
    }

    public static function getCountryAll()
    {
        $mysqli = Database::getInstance();
        $query = <<<sql
      SELECT * FROM paises ORDER BY country ASC
sql;
        return $mysqli->queryAll($query);
    }

    public static function getState($pais)
    {
        $mysqli = Database::getInstance();
        $query = <<<sql
     SELECT * FROM estados WHERE id_pais = $pais;
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

      public static function getPaisById($id){       
        $mysqli = Database::getInstance();
        $query=<<<sql
        SELECT * FROM paises WHERE id_pais = $id 
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
