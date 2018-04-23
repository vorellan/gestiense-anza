<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// We load helpers first so library constructors can use them :)

$autoload['helper'] = array('url','socialize');

$autoload['libraries'] = array('session','socializeauth', 'socializenetworks');
