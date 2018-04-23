<?php

	class Socialize_migration_model extends CI_Model {
		
		private $_config_table = '_socialize_config';
		private $_migration_latest = 3;
		
		function __construct()
		{
			parent::CI_Model();
			
			$this->_obj =& get_instance();
			
			$migration_current = $this->_get_migration_current();
			
			if ( $migration_current < $this->_migration_latest )
			{
				$this->_obj->load->dbforge();
				$this->dbforge = $this->_obj->dbforge;
				
				while ( $migration_current < $this->_migration_latest )
				{
					$process = $migration_current + 1;
					$method = 'migration_'.$process;
					
					$this->$method();
					$this->_save_migration_current($process);
					
					$migration_current++;
				}
			}
		}
		
		private function _get_migration_current()
		{
			if ( !$this->db->table_exists($this->_config_table) ) return 0;
			
			$this->db->where('config_key', 'migration_current');
			$query = $this->db->get($this->_config_table);
			
			if ( $query->num_rows() == 0 ) return 0;
			
			$row = $query->row();
			
			return intval($row->config_key);
		}
		
		private function _save_migration_current($value)
		{
			$this->db->where('config_key', 'migration_current');
			$this->db->update($this->_config_table, array('config_value' => $value));
		}
		
		private function migration_1()
		{
			if ( !$this->db->table_exists($this->_config_table) )
			{
				$cols = array(
					'config_id' => array('type' => 'INT', 'constraint' => 9, 'unsigned' => TRUE, 'auto_increment' => TRUE),
					'config_key' => array('type' => 'VARCHAR', 'constraint' => 50, 'null' => FALSE),
					'config_value' => array('type' => 'TEXT','null' => FALSE),
				);
				
				$this->dbforge->add_key('config_id', TRUE);
				$this->dbforge->add_field($cols);
				
				$this->dbforge->create_table($this->_config_table, TRUE);
				
				$this->db->insert($this->_config_table, array('config_key' => 'migration_current', 'config_value' => '0'));
			}
		}
		
		private function migration_2()
		{
			if ( !$this->db->table_exists('_socialize_users_networks') )
			{
				$cols = array(
					'id' => array('type' => 'INT', 'constraint' => 9, 'unsigned' => TRUE, 'auto_increment' => TRUE),
					'user_id' => array('type' => 'INT', 'constraint' => 9, 'unsigned' => TRUE, 'null' => FALSE),
					'network_user_id' => array('type' => 'VARCHAR', 'constraint' => 150, 'null' => FALSE),
					'network' => array('type' => 'VARCHAR', 'constraint' => 15, 'null' => FALSE)
				);
				
				$this->dbforge->add_key('id', TRUE);
				$this->dbforge->add_field($cols);
				
				$this->dbforge->create_table('_socialize_users_networks', TRUE);
			}
		}
		
		private function migration_3()
		{
			if ( !$this->db->table_exists('_socialize_users') )
			{
				$cols = array(
					'user_id' => array('type' => 'INT', 'constraint' => 9, 'unsigned' => TRUE, 'auto_increment' => TRUE),
					'password' => array('type' => 'VARCHAR', 'constraint' => 40, 'null' => FALSE),
					'name' => array('type' => 'VARCHAR', 'constraint' => 150, 'null' => FALSE)
				);
				
				$this->dbforge->add_key('user_id', TRUE);
				$this->dbforge->add_field($cols);
				
				$this->dbforge->create_table('_socialize_users', TRUE);
			}
		}
	}