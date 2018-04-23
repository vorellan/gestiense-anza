<?php if(!isset($nombreTab)) $nombreTab='';  ?>
<div id="comandosGrid<?=$nombreTab?>">
	<table id="tbComandosGrid" width="100%">
		<tr>
			
			<td nowrap class="insertar" >
			<a href="#" id="btnInsertar<?=$nombreTab?>" >Insertar</a> | 
			<a href="#" id="btnVer<?=$nombreTab?>"  c="index.php?/<?=$controller?>/VER_ENTIDAD">Ver/Editar</a> | 
			<a href="#" id="btnEliminar<?=$nombreTab?>" >Eliminar</a> | 
			<?php if(!$nombreTab || $inputBuscador){?>
			<a href="#" id="btnFiltrar<?=$nombreTab?>" >Filtrar</a>
			<?php }?>
			</td>
			
			
			<td class="modulo">
			Modulo: <?=$nombreModulo?>
			</td>
		</tr>
	</table>
</div>


<div id="comandosForm<?=$nombreTab?>" style="display:none">
	<table id="tbComandosForm" width="100%">
		<tr>
			<td nowrap class="insertar" >
			<a href="#" id="btnVolver<?=$nombreTab?>" >Volver</a> | 
			</td>
		</tr>
	</table>
</div>



<script type="text/javascript">

//SCRIPT COMANDOS
$("#btnInsertar<?=$nombreTab?>").click(
	function(evento){
		$('#mensaje<?=$nombreTab?>').fadeOut(500);
		$('#dataGrid<?=$nombreTab?>').fadeOut(10);
		$('#dataForm<?=$nombreTab?>').fadeIn(10);
		$('#form<?=$nombreTab?>Standard').attr("action","index.php?/<?=$controller?>/insertar");
		$('#btnEnvio<?=$nombreTab?>').attr("value","Insertar");
		$('#comandosGrid<?=$nombreTab?>').hide();
		$('#comandosForm<?=$nombreTab?>').show();
		//LIMPIAR EL FORM
		$('#form<?=$nombreTab?>Standard').reset();	
		//SI HAY TAB SE DEBE PONER COMO DEFAULT LA FK QUE CORRESPONDA
		<?php if($nombreTab){?>
			fk<?=$nombreTab?>Default();
		<?php } ?>
	}
);

$("#btnVer<?=$nombreTab?>").click(
	function(evento){
		$('#mensaje<?=$nombreTab?>').fadeOut(500);
		var id;
		id = jQuery("#grid<?=$nombreTab?>").getGridParam('selarrrow');
		form<?=$nombreTab?>Edit(id);
	}
);


$("#btnEliminar<?=$nombreTab?>").click(
	function(evento){
		$('#mensaje<?=$nombreTab?>').fadeOut(500);
		var id;
		id = jQuery("#grid<?=$nombreTab?>").getGridParam('selarrrow');
		var rs = confirm("Esta seguro de eliminar la entidad: "+id)
		if (rs){
			eliminar<?=$nombreTab?>(id);
		}
	}
);

$("#btnVolver<?=$nombreTab?>").click(
	function(evento){
		$('#mensaje<?=$nombreTab?>').fadeOut(500);
		$('#dataGrid<?=$nombreTab?>').fadeIn(10);
		$('#dataForm<?=$nombreTab?>').fadeOut(10);
		$('#comandosGrid<?=$nombreTab?>').show();
		$('#comandosForm<?=$nombreTab?>').hide();	
		<?php if(!$nombreTab){ ?>
		$('#tab').hide();//SIEMPRE SE OCULTA EL TAB
		<?php }?>
	}
);


$("#btnFiltrar<?=$nombreTab?>").click(
	function(evento){
		$('#mensaje<?=$nombreTab?>').fadeOut(500);
		mygrid<?=$nombreTab?>[0].toggleToolbar();
	}
);
//////////////////////

//SE DEFINE LA FUNCION RESET PARA UN LIMPIAR UN FORMULARIO
jQuery.fn.reset = function () {
  $(this).each (function() { this.reset(); });
}


</script>




