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
class admin extends Controller {
    private $data;
    
    function admin(){
        parent::Controller();
    }

    function index(){
        $this->data['pagina'] = 'template/default';
        $this->load->view('admin/template/index',$this->data);
    }

    function lugar(){
        $this->data['titulo'] = 'Lugar';
        $this->data['pagina'] = 'lugar';

        //rescate de informacion

        $this->load->view('template/index',$this->data);
    }
}
