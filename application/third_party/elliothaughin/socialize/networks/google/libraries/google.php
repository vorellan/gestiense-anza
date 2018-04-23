<?php

	class Google {
		
		private $_obj = NULL;
		private $_user = NULL;
		
		function __construct()
		{
			$this->_obj =& get_instance();
			
			$this->_obj->load->config('google');
			$this->_obj->load->helper('google');
			
			$this->_get_cookie();
		}
		
		public function get_user_id()
		{
			return ( empty($this->_user['id']) ) ? FALSE : $this->_user['id'];
		}
		
		public function logged_in()
		{
			return ( $this->_user === NULL ) ? FALSE : TRUE;
		}
		
		public function socialize_user()
		{
			if ( !$this->logged_in() ) return NULL;
			
			$me = $this->_user;
			
			$user = new stdClass();
			$user->name = $this->_user['name'];

			return $user;
		}
		
		public function logout()
		{
			$this->_obj->load->helper('cookie');
			delete_cookie('fcauth'.$this->_obj->config->item('google_site_id'));
		}
		
		private function _get_cookie()
		{
			if ( !isset($_COOKIE['fcauth'.$this->_obj->config->item('google_site_id')]) ) return NULL;
			
			$cookie = $_COOKIE['fcauth'.$this->_obj->config->item('google_site_id')];
			if ( empty($cookie) ) return NULL;
			
			// Let's try and get our profile.
			$url = 'http://www.google.com/friendconnect/api/people/@me/@self?fcauth='.$cookie;
		
			$ch = curl_init();
			
			$opts = array(
				CURLOPT_CONNECTTIMEOUT 	=> 10,
				CURLOPT_RETURNTRANSFER 	=> TRUE,
				CURLOPT_TIMEOUT        	=> 60,
				CURLOPT_USERAGENT      	=> 'codeigniter-socialize-1.0',
				CURLOPT_URL				=> $url
			);

			curl_setopt_array($ch, $opts);

			$result = curl_exec($ch);
			curl_close($ch);
			
			$user = json_decode($result);
			
			if ( !isset($user->entry->id) || !is_object($user->entry) ) return NULL;
			
			$this->_user = 	array(
								'id' 	=> $user->entry->id,
								'name' 	=> $user->entry->displayName
							);
			
			return TRUE;
		}
	}