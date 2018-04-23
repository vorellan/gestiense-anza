<?php

	function twitter_login_button()
	{
		$return = '<span id="socialize-twitter-login-button"></span>';
		return $return;
	}
	
	function twitter_head()
	{
		$ci =& get_instance();
		
		return '<script src="http://platform.twitter.com/anywhere.js?id='.$ci->config->item('twitter_api_key').'&v=1" type="text/javascript"></script>';
	}
	
	function twitter_footer()
	{
		$ci =& get_instance();
		
		$return = '';
		
		$return .= '<script type="text/javascript">';
		$return .= '$(document).ready(function(){';
		$return .= 'twttr.anywhere(function(T){ ';
	
			$return .= 'T(".socialize-name-twitter").hovercards({linkify: false, expanded: true});';	
			$return .= 'T("#socialize-twitter-login-button").connectButton({size: "large", authComplete: function(user){window.location.reload();}});';
			$return .= 'if (T.isConnected()) {$(".logout").bind("click", function () {twttr.anywhere.signOut();});}';
		
		$return .= '});'; // End twttr.anywhere
		$return .= '});'; // End $(document).ready
		$return .= '</script>';
		
		
		return $return;
	}