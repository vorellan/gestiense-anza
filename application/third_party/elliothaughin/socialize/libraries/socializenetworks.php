<?php

	class SocializeNetworks {
		
		private $_obj;
		private $_networks = array();
		
		function __construct()
		{
			$this->_obj =& get_instance();
			$this->_obj->load->config('socializenetworks');
			
			$this->_get_networks();
			$this->_autoload();
		}
		
		private function _autoload()
		{
			foreach ( $this->_networks as $network )
			{
				$this->_obj->load->add_package_path(APPPATH.'third_party/elliothaughin/socialize/networks/'.$network.'/');
				$this->_obj->load->library($network);
				
				if ( $this->_obj->$network->logged_in() )
				{
					$this->_obj->socializeauth->network_login($network, $this->_obj->$network->get_user_id());
				}
			}
		}
		
		private function _get_networks()
		{
			$this->_obj->load->helper('file');
			
			$directories = get_dir_file_info(APPPATH.'third_party/elliothaughin/socialize/networks/');
			$enabled = $this->_obj->config->item('socializenetworks_enabled');
			
			foreach ( $directories as $directory => $info )
			{
				if ( in_array($directory, $enabled) && (strpos($directory, '.') === FALSE) && !in_array($directory, $this->_networks) )
				{
					$this->_networks[] = $directory;
				}
			}
		}
		
		public function networks()
		{
			return $this->_networks;
		}
	}