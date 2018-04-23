<?php

	function facebook_xmlns()
	{
		return socialize_view('xmlns', 'facebook', TRUE);
	}
	
	function facebook_app_id()
	{
		$ci =& get_instance();
		
		return $ci->config->item('facebook_app_id');
	}
	
	function facebook_picture($who = 'me')
	{
		$ci =& get_instance();

		$img = $ci->facebook->get_domain_url('graph').$who.'/picture';

		$cookie = $ci->facebook->get_cookie();
		
		if ( !empty($cookie['access_token']) )
		{
			$img .= '?access_token='.$cookie['access_token'];
		}
		
		return $img;
	}
	
	function facebook_head()
	{
		return socialize_view('header', 'facebook', TRUE);
	}
	
	function facebook_footer()
	{
		return socialize_view('footer', 'facebook', TRUE);
	}
	
	function facebook_login_button()
	{
		return socialize_view('login_button', 'facebook', TRUE);
	}