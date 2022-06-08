<?php
namespace App\controllers;
defined("APPPATH") OR die("Access denied");

use \Core\View;
use \Core\Controller;
use \App\models\Patrocinadores AS PatrocinadoresDao;

class Patrocinadores extends Controller{

    private $_contenedor;

    function __construct(){
        parent::__construct();
        $this->_contenedor = new Contenedor;
        View::set('header',$this->_contenedor->header());
        View::set('footer',$this->_contenedor->footer());
    }

    public function getUsuario(){
      return $this->__usuario;
    }

    public function index() {
     $extraHeader =<<<html
      <link id="pagestyle" href="/assets/css/style.css" rel="stylesheet" />
      <title>
            Home - AMETD
      </title>
html;

        $patrocinadores = '';
        $card_patrocinadores = '';

        $patrocinadores =  PatrocinadoresDao::getTablePatrocinadores($_SESSION['id_patrocinadores']);

        foreach ($patrocinadores as $key => $value) {
            

            $card_patrocinadores .= <<<html
                
            <div class="col-12 col-md-3 text-center" style="margin-bottom: 15px">
                <div class="card card-body card-course p-0 border-radius-15" style="margin-bottom: 20px">
                <img class="caratula-img border-radius-15" src="/img_patrocinadores/{$value['img']}">
                </div>
            </div>
html;

}


        View::set('header',$this->_contenedor->header($extraHeader));
        //View::set('permisos_mexico',$permisos_mexico);
        //View::set('tabla',$tabla);
        View::set('card_patrocinadores',$card_patrocinadores);
        View::render("patrocinadores");
    }
}