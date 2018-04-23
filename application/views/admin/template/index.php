<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>AdminTheme - Ultimate Admin Panel Solution</title>
        <meta name="robots" content="index,follow" />

        <link rel="stylesheet" type="text/css" media="all" href="css/admin/style.css" />
        <link rel="Stylesheet" type="text/css" href="css/admin/smoothness/jquery-ui-1.7.1.custom.css"  />
        <!--[if IE 7]><link rel="stylesheet" href="css/admin/ie.css" type="text/css" media="screen, projection" /><![endif]-->
        <!--[if IE 6]><link rel="stylesheet" href="css/admin/ie6.css" type="text/css" media="screen, projection" /><![endif]-->
        <link rel="stylesheet" type="text/css" href="js/markitup/skins/markitup/style.css" />
        <link rel="stylesheet" type="text/css" href="js/markitup/sets/default/style.css" />
        <link rel="stylesheet" type="text/css" href="css/admin/superfish.css" media="screen">
            <!--[if IE]>
                    <style type="text/css">
		  .clearfix {
		    zoom: 1;     /* triggers hasLayout */
		    display: block;     /* resets display for IE/Win */
		    }  /* Only IE can see inside the conditional comment
		    and read this CSS rule. Don't ever use a normal HTML
		    comment inside the CC or it will close prematurely. */
		</style>
	<![endif]-->
            <!-- JavaScript -->
            <script type="text/javascript" src="js/admin/jquery-1.3.2.min.js"></script>
            <script type="text/javascript" src="js/admin/jquery-ui-1.7.1.custom.min.js"></script>
            <script type="text/javascript" src="js/admin/hoverIntent.js"></script>
            <script type="text/javascript" src="js/admin/superfish.js"></script>
            <script type="text/javascript">
                // initialise plugins
                jQuery(function(){
                    jQuery('ul.sf-menu').superfish();
                });

            </script>
            <script type="text/javascript" src="js/admin/excanvas.pack.js"></script>
            <script type="text/javascript" src="js/admin/jquery.flot.pack.js"></script>
            <script type="text/javascript" src="js/markitup/jquery.markitup.pack.js"></script>
            <script type="text/javascript" src="js/markitup/sets/default/set.js"></script>
            <script type="text/javascript" src="js/admin/custom.js"></script>

         <!--[if IE]><script language="javascript" type="text/javascript" src="excanvas.pack.js"></script><![endif]-->
    </head>
    <body>
        <div class="container" id="container">
            <div  id="header">
                <?php $this->load->view('admin/template/header') ?>
            </div><!-- end header -->
            <div id="content" >
                <?php $this->load->view('admin/template/menu') ?>
                <?php $this->load->view('admin/'.$pagina) ?>
            </div><!-- end #content -->
            <div  id="footer" class="clearfix">
                <?php $this->load->view('admin/template/footer') ?>
            </div><!-- end #footer -->
        </div><!-- end container -->
    </body>
</html>
