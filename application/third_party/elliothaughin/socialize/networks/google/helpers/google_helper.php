<?php

	function google_head()
	{
		return socialize_view('header', 'google', TRUE);
	}
	
	function google_footer()
	{
		return socialize_view('footer', 'google', TRUE);
	}
	
	function google_login_button()
	{
		return socialize_view('login_button', 'google', TRUE);
	}