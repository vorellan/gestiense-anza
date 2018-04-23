<?php

	class SocializeAuth {
		
		private $_obj;
		private $_user 					= NULL;
		private $_connected_networks 	= array();
		private $_table_users_networks 	= '_socialize_users_networks';
		private $_table_users 			= '_socialize_users';
		private $_session_key 			= 'socialize_user';
		private $_encryption_key		= 'somethinglovely';
		private $_cookie_key			= '_socialize_previous_auth';
		
		function __construct()
		{
			$this->_obj =& get_instance();
			$this->_obj->load->helper('cookie');
			
			$this->_get_session();
		}
		
		private function _get_session()
		{
			$user = $this->_obj->session->userdata($this->_session_key);
			
			if ( !empty($user->user_id) )
			{
				$this->_get_user($user->user_id);
			}
		}
		
		public function logged_in()
		{
			return ( $this->_user === NULL ) ? FALSE : TRUE;
		}
		
		public function user()
		{
			return $this->_user;
		}
		
		public function connected($network)
		{
			return ( empty($this->_connected_networks[$network]) ) ? FALSE : TRUE;
		}
		
		public function native_login()
		{
			
		}
		
		public function network_login($network, $network_user_id)
		{
			if ( $this->connected($network) ) return TRUE;
			
			if ( $this->_user !== NULL )
			{
				if ( !empty($this->_user->socialize_networks[$network]) && is_array($this->_user->socialize_networks[$network]) && in_array($network_user_id, $this->_user->socialize_networks[$network]) )
				{
					$this->_connected_networks[$network] = $network_user_id;
					return TRUE;
				}
				else
				{
					// User was native, will now be social too.
					
					$this->_associate_user_with_network($this->_user, $network, $network_user_id);
				}
			}
			else
			{
				$user = $this->_social_get_user($network, $network_user_id);
				
				// Try to get the user by social id
				if ( $this->_social_get_user($network, $network_user_id) )
				{
					$this->_connected_networks[$network] = $network_user_id;
					return TRUE;
				}
				else 
				{
					// First let's check for a cookie.
					$this->_obj->load->library('encrypt');
					
					$cookie = get_cookie($this->_cookie_key);
					$user_id = $this->_obj->encrypt->decode($cookie, $this->_encryption_key);
					
					if ( $this->_get_user($user_id) )
					{
						$this->_associate_user_with_network($this->_user, $network, $network_user_id);
					}
					else
					{
						// no luck? create them a user :)
						$this->_create_user($this->_obj->$network->socialize_user(), $network, $network_user_id);
					}
				}
			}
		}
		
		public function logout()
		{
			foreach ( $this->_connected_networks as $network => $network_user_id )
			{
				$this->_obj->$network->logout();
			}
			
			$this->_obj->session->unset_userdata($this->_session_key);
			$this->_user = NULL;
		}
		
		private function _create_user($socialize_user, $network = NULL, $network_user_id = NULL)
		{
			$socialize_user->name = $socialize_user->name;
			$socialize_user->password = sha1($network.$network_user_id.mt_rand());

			$this->_obj->db->insert($this->_table_users, $socialize_user);
			
			$user_id = $this->_obj->db->insert_id();
			$this->_get_user($user_id);
			
			$this->_associate_user_with_network($this->_user, $network, $network_user_id);
		}
		
		private function _associate_user_with_network($user, $network, $network_user_id)
		{
			$users_network = array(
									'user_id' => $user->user_id,
									'network' => $network,
									'network_user_id' => $network_user_id
								);
								
			$this->_obj->db->insert($this->_table_users_networks, $users_network);
			
			$this->_get_user($user->user_id);
		}
		
		private function _social_get_user($network, $network_user_id)
		{
			$this->_obj->db->where('network', $network);
			$this->_obj->db->where('network_user_id', $network_user_id);
			
			$query = $this->_obj->db->get($this->_table_users_networks, 1);
			
			$_get_user = FALSE;
			
			if ( $query->num_rows() == 1 )
			{
				$user_network = $query->row();
				$_get_user = $this->_get_user($user_network->user_id);
			}
			
			return $_get_user;
		}
		
		private function _get_user($user_id)
		{
			$this->_obj->db->where('user_id', $user_id);
			$query = $this->_obj->db->get($this->_table_users, 1);
			
			$user = NULL;
			
			if ( $query->num_rows() == 1 )
			{
				$user = $query->row();
				
				$this->_obj->db->select('network');
				$this->_obj->db->select('network_user_id');
				$this->_obj->db->where('user_id', $user_id);
				
				$query = $this->_obj->db->get($this->_table_users_networks);
				
				if ( $query->num_rows() > 0 )
				{
					$user->socialize_networks = array();
					$socialize_networks = $query->result();
					
					foreach ( $socialize_networks as $connection )
					{
						$user->socialize_networks[$connection->network][] = $connection->network_user_id;
					}
				}
				
				$this->_user = $user;
				
				$this->_obj->session->set_userdata($this->_session_key, $this->_user);
				
				// We should set a cookie telling us we've previously logged in.
				// This is only a temporary measure.
				
				$this->_obj->load->library('encrypt');
				
				$cookie = array(
				                   'name'   => $this->_cookie_key,
				                   'value'  => $this->_obj->encrypt->encode($this->_user->user_id, $this->_encryption_key),
				                   'expire' => '15768000',
				                   'path'   => '/'
				               );

				set_cookie($cookie);
				
				return TRUE;
			}
			
			$this->_user = $user;
			$this->_obj->session->unset_userdata($this->_session_key);
			
			return FALSE;
		}
	}