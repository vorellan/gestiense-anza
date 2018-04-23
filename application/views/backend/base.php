<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Backend</title>
        <meta name="robots" content="index,follow" />

        <link rel="Stylesheet" type="text/css" href="css/admin/smoothness/jquery-ui-1.7.1.custom.css"  />
		<link rel="stylesheet" type="text/css" href="css/backend/accordeon.css" />
		<link rel="stylesheet" type="text/css" href="css/backend/backend.css" />
        <!-- JavaScript -->
        <script type="text/javascript" src="js/admin/jquery-1.3.2.min.js"></script>
        <script type="text/javascript" src="js/admin/jquery-ui-1.7.1.custom.min.js"></script>
		<script type="text/javascript" src="js/backend/json2.js"></script>
		
		<!-- JQGRID -->
		<link rel="stylesheet" type="text/css" media="screen" href="js/backend/jqgrid/css/jquery-ui-1.7.2.custom.css" />
		<link rel="stylesheet" type="text/css" media="screen" href="js/backend/jqgrid/css/ui.jqgrid.css" />
		<link rel="stylesheet" type="text/css" media="screen" href="js/backend/jqgrid/css/jquery.searchFilter.css" />
		<script src="js/backend/jqgrid/js/jquery.js" type="text/javascript"></script>
		<script src="js/backend/jqgrid/js/i18n/grid.locale-sp.js" type="text/javascript"></script>
		<script src="js/backend/jqgrid/js/jquery.jqGrid.js" type="text/javascript"></script>
		<!-- JQVALIDATE -->
		<script type="text/javascript" src="js/backend/jqvalidate/jquery.validate.js" ></script>
		
		<!-- FLOAT -->
		<script type="text/javascript" src="js/backend/float/jquery.form.js"></script>
		<script type="text/javascript" src="js/backend/float/interface.js"></script>
		<script type="text/javascript" src="js/backend/float/jquery.js"></script>
		
		<!-- CALENDAR -->
		<script type="text/javascript" src="js/backend/jqcalendar/cal.js"></script>
		<link href="js/backend/jqcalendar/css/calendar.css" rel="stylesheet" type="text/css" />
		
		
    </head>
    <body>
        <div "id=loading" style="display:none">Cargando...</div>		
		<div "id=result" style="display:none">Listo...</div>	

		<table class="cuerpo"  align="center">
			<tr>
				<td align="center" valign="top" style="width:746px;">
					<!-- CONTENIDO -->
					<div id="base">
					Cargando..
					</div>
					<!-- FIN CONTENIDO -->
				</td>
				
				<td align="center" valign="top" width="1%" >
				 <?php $this->load->view('backend/menu') ?>
				</td>
			</tr>
		<table>
    </body>
</html>


<script type="text/javascript">


$(document).ready(function(){
	//EFECTO ACORDEON MENU
	$(".accordion h3:first").addClass("active");
	$(".accordion div:not(:first)").hide();
	$(".accordion h3").click(function(){
		$(this).next("div").slideToggle("slow")
		.siblings("div:visible").slideUp("slow");
		$(this).toggleClass("active");
		$(this).siblings("h3").removeClass("active");
	});
	
	//LA PRIMERA VEZ SE CARGA UN MODULO DEFAULT (USUARIO)
	$.ajax({
			type: "POST",
			url: 'index.php?/paciente_controller/cargaModulo',
			success: function(datos){
				$("#base").html(datos);
			}
	});
	
	
	//AJAX - LISTENER DEL MENU
	$("#menu a").click(
		function(evento){
			var controlador = $(this).attr("c");
			$.ajax({
				type: "POST",
				url: controlador,
				success: function(datos){
					$("#base").html(datos);
				}
			});
		}
	);
	
	
	
	
})

function abrirPanel(URL,ancho,alto){
	var params="width="+ancho+",height="+alto+",scrollbars=NO,location=NO,menubar=NO,status=NO,titlebar=NO,toolbar=NO";
	window.open(URL,"Panel",params);
}

function limpiar(id){
	document.getElementById(id).value='';
}

</script>
