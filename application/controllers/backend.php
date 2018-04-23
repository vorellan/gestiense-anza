<?php
/**
 * Description of admin.php
 *
 * Creado en 06-10-2010, 01:28:15 AM
 * UTF-8
 *
 * @autho       Felipe Villalobos
 * @mail        mantecoso@gmail.com
 * @package     Controller
 * @empresa     Gertech.cl
 * 
 */
class Backend extends Controller {
    private $data;
    
    function Backend(){
        parent::Controller();
    }

    function index($permiso=''){
	
	
	
        $this->data['pagina'] = 'template/default';
		$this->data['permiso']=$permiso;
        $this->load->view('backend/base',$this->data);
    }

    
}
