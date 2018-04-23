<meta property="fb:admins" content="<?php echo $this->config->item('facebook_admins')?>" />
<meta property="fb:app_id" content="<?php echo $this->config->item('facebook_app_id')?>" />
<meta property="og:site_name" content="<?php echo $this->config->item('facebook_site_name')?>" /> 

<?php if ( !empty($opengraph) ):?>
<?php foreach ( $opengraph as $key => $value ):?>
	<meta property="og:<?php echo $key?>" content="<?php echo $value ?>" />
<?php endforeach;?>
<?php endif;?>