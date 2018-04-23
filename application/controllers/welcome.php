<?php
include(APPPATH.'third_party/elliothaughin/socialize/controllers/socializecontroller'.EXT);

class Welcome extends SocializeController {

    function __construct() {
        parent::__construct();
    }

    function index() {
        //Probando el Login, con facebook, gmail y twitter
        $this->data('something', $this->socializeauth->user());
        $this->data('opengraph', array('test' => 'something'));


        $this->load->view('welcome_message');
    }

    function logout() {
        $this->socializeauth->logout();
        redirect();
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */