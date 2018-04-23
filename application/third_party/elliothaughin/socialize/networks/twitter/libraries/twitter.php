<?php

	class Twitter {
		
		private $_obj = NULL;
		private $_user = NULL;
		private $_twitter_cookie_key = 'twitter_anywhere_identity';
		
		function __construct()
		{
			$this->_obj =& get_instance();
			
			$this->_obj->load->config('twitter');
			$this->_obj->load->helper('twitter');
			
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
			$user->name = $this->_user['username'];

			return $user;
		}
		
		public function logout()
		{
			setcookie($this->_twitter_cookie_key);
		}
		
		private function _get_cookie()
		{
			if ( !isset($_COOKIE[$this->_twitter_cookie_key]) ) return NULL;
			
			$cookie = $_COOKIE[$this->_twitter_cookie_key];
			
			$parts = explode(':', $cookie);
			if ( count($parts) !== 2 ) return NULL;
			
			$user_id = $parts[0];
			$hash = $parts[1];
			
			// Todo calculate and double check digest
			// Digest::SHA1.hexdigest(user_id + consumer_secret)
			
			if ( empty($user_id) ) return NULL;
			
			$this->_user = 	array(
								'id' => $user_id,
								'username' => strtolower('elliothaughin')
							);
			
			return TRUE;
		}
		
		/*
		 * Not enabled yet is a way to do a serverside auth using the oauth 2.0 from the @anywhere login.
		 * 
		 * However, twitter have announced that they will be doing this soon
		 * so, I've decided not to use the traditional oAuth 1.0 on the serverside and instead
		 * hold out till we can do @anywhere server-side
		 * 
		 * This just means that right now all we can do with twitter is a simple auth.
		 * And some contact cards etc.
		 * 
		 */
	}