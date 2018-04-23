<br>
<div id="tab"></div>
<script type="text/javascript">
	//AJAX - LISTENER DEL MENU-TAB
	$("#menuTab a").click(
		function(evento){
			var id = $('#id').attr("value");
			var controlador = $(this).attr("c");
			var controlador=controlador=controlador+'/false/'+id;
				
			$.ajax({
				type: "POST",
				url: controlador,
				success: function(datos){
					$("#tab").html(datos);
					$('#tab').show();//SE MUESTRA EL TAB
				}
			});
		}
	);
</script>