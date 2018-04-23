<?php
class MY_Controller extends Controller {
	function MY_Controller()
	{
		parent::Controller();
		$this->load->config('fireignition');
		if ($this->config->item('fireignition_enabled'))
		{
			if (floor(phpversion()) < 5)
			{
				log_message('error', 'PHP 5 is required to run fireignition');
			} else {
				$this->load->library('FirePHP');
			}
		}
		else 
		{
			$this->load->library('Firephp_fake');
			$this->firephp =& $this->firephp_fake;
		}
	}
}
?>
