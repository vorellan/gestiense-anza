<?php

class SocializeController extends Controller {

	function __construct()
	{
		parent::Controller();
		
		parse_str($_SERVER['QUERY_STRING'], $_GET);
		
		$this->load->add_package_path(APPPATH.'third_party/elliothaughin/socialize/');
		$this->_autoload();
	}
	
	private function _autoload()
	{
		$this->load->model('socialize_migration_model');
		
		$autoload = array();
		
		include(APPPATH.'third_party/elliothaughin/socialize/config/autoload'.EXT);
		foreach ( $autoload as $type => $files )
		{
			$type = ($type == 'libraries') ? 'library' : $type;
			
			foreach ( $files as $file )
			{
				$this->load->$type($file);
			}
		}
	}
	
	public function data($key, $value)
	{
		$this->load->vars(array($key => $value));
	}
}

/* End of file socializecontroller.php */
/* Location: ./elliothaughin/socialize/cotrollers/socializecontroller.php */