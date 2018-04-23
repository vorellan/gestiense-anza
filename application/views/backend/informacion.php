<!-- CONTENIDO -->
<div class="mensaje" id="mensaje<?=$nombreTab?>"></div>

<?php if(!$inputBuscador){
$this->load->view('backend/comandos');
}?>


<div id="dataGrid<?=$nombreTab?>">
	<table id="grid<?=$nombreTab?>" class="scroll" cellpadding="0" cellspacing="0"></table>
	<div id="paginador<?=$nombreTab?>" class="scroll" style="text-align:center;"></div>
</div>

<?php if(!$inputBuscador){?>
<div id="dataForm<?=$nombreTab?>" style="display:none">
	<form id="form<?=$nombreTab?>Standard" name="form<?=$nombreTab?>Standard"   >
	
	
	<table  class="tabla_form" >
		<tr>
		<th>ID</th>
		<td><input type="text" size="30" id="id" name="id" value="" class="readonly" readonly ></input></td>
		</tr>
		<tr>
			<th>FECHA</th>
			<td><input type="text" size="30" id="fecha" name="fecha" value="" class="required"  ></input></td>
		</tr>
		<tr>
			<th>HORA</th>
			<td><input type="text" size="30" id="hora" name="hora" value="" class="required"  ></input></td>
		</tr>
		<tr>
			<th>INFORMACION</th>
			<td><input type="text" size="30" id="informacion" name="informacion" value="" class="required"  ></input></td>
		</tr>
		<tr>
			<th>SECCION_ID</th>
			<td><input type="hidden" id="seccion_id" name="seccion_id" value="" ><input type="text" size="30" id="seccion_id_aux" name="seccion_id_aux" value="" class="required readonly"  readonly ></input>

			<span id="ib_seccion_id" class="ibButton"></span>
			<span id="clean_seccion_id" class="cleanButton" onclick="javascript:limpiar('seccion_id');limpiar('seccion_id_aux')"></span></td>
		</tr>
		<tr>
			<th>PROFESOR ID</th>
			<td><input type="hidden" id="profesor_id" name="profesor_id" value="" ><input type="text" size="30" id="profesor_id_aux" name="profesor_id_aux" value="" class="required readonly"  readonly ></input>

			<span id="ib_profesor_id" class="ibButton"></span>
			<span id="clean_profesor_id" class="cleanButton" onclick="javascript:limpiar('profesor_id');limpiar('profesor_id_aux')"></span></td>
		</tr>
		<tr>
			<th>USUARIO ID</th>
			<td><input type="hidden" id="usuario_id" name="usuario_id" value="" ><input type="text" size="30" id="usuario_id_aux" name="usuario_id_aux" value="" class="required readonly"  readonly ></input>

			<span id="ib_usuario_id" class="ibButton"></span>
			<span id="clean_usuario_id" class="cleanButton" onclick="javascript:limpiar('usuario_id');limpiar('usuario_id_aux')"></span></td>
		</tr>
		<tr>
			<th>ASIGNATURA ID</th>
			<td><input type="hidden" id="asignatura_id" name="asignatura_id" value="" ><input type="text" size="30" id="asignatura_id_aux" name="asignatura_id_aux" value="" class="required readonly"  readonly ></input>

			<span id="ib_asignatura_id" class="ibButton"></span>
			<span id="clean_asignatura_id" class="cleanButton" onclick="javascript:limpiar('asignatura_id');limpiar('asignatura_id_aux')"></span></td>
		</tr>
		
		
		
		
		
		
		
		<tr>
			<th colspan="2"><input id="btnEnvio<?=$nombreTab?>" type="submit" value=""></input></th>
		</tr>
	
	</table>
	
	
	</form>
	
	<?php $this->load->view('backend/common_ib'); ?>
	
</div>
<?php } ?> 



<script type="text/javascript">
$('#fecha').simpleDatepicker();
//SCRIPT grid
var mygrid<?=$nombreTab?>=jQuery("#grid<?=$nombreTab?>").jqGrid({
    url:'index.php?/<?=$controller?>/grid/<?=$keyTab?>',  
    datatype: "json",
    width:900,
    height:'auto',
    colNames:['ID','FECHA','HORA','INFORMACION','SECCION','PROFESOR','USUARIO','ASIGNATURA'],//@
    colModel:[//@
        {name:'id',index:'id', width:60},
		{name:'fecha',index:'fecha', width:60},
		{name:'hora',index:'hora', width:60},
		{name:'informacion',index:'informacion', width:60},
		{name:'seccion_id',index:'seccion_id', width:60},
		{name:'profesor_id',index:'profesor_id', width:60},
		{name:'usuario_id',index:'usuario_id', width:60},
		{name:'asignatura_id',index:'asignatura_id', width:60}
    ],
    pager: jQuery('#paginador<?=$nombreTab?>'),
    rowNum:15,
	rowList:[10,20,30],
    sortname: 'id',//@
   	mtype: "POST",
    viewrecords: true,
    sortorder: "asc",
    caption: "<?=$nombreModulo?>",
	multiselect:true,
	
    gridComplete: function() { 
		var firstrow = $("#grid<?=$nombreTab?> tr").attr('id');
		jQuery("#grid<?=$nombreTab?>").setSelection(firstrow);
	},
	
	onCellSelect: function(id , iCol , cellcontent, target) { 																				
		jQuery("#grid<?=$nombreTab?>").resetSelection();
		jQuery("#grid<?=$nombreTab?>").setSelection(id);
	},
	
	ondblClickRow:function(id){
		<?php if(!$inputBuscador){ ?>
		jQuery("#grid<?=$nombreTab?>").resetSelection();
		jQuery("#grid<?=$nombreTab?>").setSelection(id);
		form<?=$nombreTab?>Edit(id);
		<?php }else{ ?>
		fk_informacion_id(id);//@ 
		<?php } ?> 
	}
	
});

//////////////////////

 
<?php if(!$nombreTab || $inputBuscador){ ?>
//SCRIPT FILTRO
mygrid<?=$nombreTab?>.filterToolbar();//DECLARO FILTRO
	<?php if(!$inputBuscador){?>
	mygrid<?=$nombreTab?>[0].toggleToolbar();//OCULTO FILTRO PARA LA PRIMERA VEZ SI ES QUE NO ES INPUT BUSCADOR
	<?php } ?>
//SE ADAPTAN LOS NOMBRES DE LOS FILTROS //@
$("#gs_id").attr("id","f_id<?=$nombreTab?>");
$("#gs_fecha").attr("id","f_fecha<?=$nombreTab?>");
$("#gs_hora").attr("id","f_hora<?=$nombreTab?>");
$("#gs_informacion").attr("id","f_informacion<?=$nombreTab?>");
$("#gs_seccion_id").attr("id","f_seccion_id<?=$nombreTab?>");
$("#gs_profesor_id").attr("id","f_profesor_id<?=$nombreTab?>");
$("#gs_usuario_id").attr("id","f_usuario_id<?=$nombreTab?>");
$("#gs_asignatura_id").attr("id","f_asignatura_id<?=$nombreTab?>");



var timeoutHnd<?=$nombreTab?>;
jQuery("table .ui-search-toolbar :input").keyup(function(e){
	if(timeoutHnd<?=$nombreTab?>) {
		clearTimeout(timeoutHnd<?=$nombreTab?>); 
	}
	timeoutHnd<?=$nombreTab?> = setTimeout(grid<?=$nombreTab?>Reload,500);
});

function grid<?=$nombreTab?>Reload(){//@
	var f_id = jQuery("#f_id<?=$nombreTab?>").val();
	var f_fecha = jQuery("#f_fecha<?=$nombreTab?>").val();
	var f_hora = jQuery("#f_hora<?=$nombreTab?>").val();
	var f_informacion = jQuery("#f_informacion<?=$nombreTab?>").val();
	var f_seccion_id = jQuery("#f_seccion_id<?=$nombreTab?>").val();
	var f_profesor_id = jQuery("#f_profesor_id<?=$nombreTab?>").val();
	var f_usuario_id = jQuery("#f_usuario_id<?=$nombreTab?>").val();
	var f_asignatura_id = jQuery("#f_asignatura_id<?=$nombreTab?>").val();


	//@
	jQuery("#grid<?=$nombreTab?>").setGridParam({url:"index.php?/<?=$controller?>/grid/<?=$keyTab?>",postData:{"livesearch":true,"f_id":f_id,"f_fecha":f_fecha,"f_hora":f_hora,"f_informacion":f_informacion,"f_seccion_id":f_seccion_id,"f_profesor_id":f_profesor_id,"f_usuario_id":f_usuario_id,"f_asignatura_id":f_asignatura_id},page:1}).trigger("reloadGrid");
}
//////////////////////
<?php } ?>

//SCRIPT ELIMINAR
function eliminar<?=$nombreTab?>(id){	
	//ELIMINACION
	$.ajax({
		type: "POST",
		url: 'index.php?/<?=$controller?>/eliminar/'+id,
		
		success: function(datos) {
			json=JSON.parse(datos);
			$('#mensaje<?=$nombreTab?>').html(json.msg);
			$('#mensaje<?=$nombreTab?>').fadeIn(500);
			$('#mensaje<?=$nombreTab?>').fadeOut(2000);
			if(json.exito){//SE HACE LA ELIMINACIÓN CORRECTAMENTE
				$('#dataGrid<?=$nombreTab?>').fadeIn(500);
				$('#dataForm<?=$nombreTab?>').fadeOut(500);
				$('#comandosGrid<?=$nombreTab?>').show();
				$('#comandosForm<?=$nombreTab?>').hide();
				jQuery("#grid<?=$nombreTab?>").clearGridData(true);
				jQuery("#grid<?=$nombreTab?>").setGridParam({url:"index.php?/<?=$controller?>/grid/<?=$keyTab?>",postData:{"livesearch":true},page:1}).trigger("reloadGrid");
			}
        }
		
	});
}
//////////////////////

//SCRIPT FORMULARIOS
function form<?=$nombreTab?>Edit(id){
	$('#dataGrid<?=$nombreTab?>').fadeOut(500);
	$('#dataForm<?=$nombreTab?>').fadeIn(500);
	$('#form<?=$nombreTab?>Standard').attr("action","index.php?/<?=$controller?>/editar/"+id);
	$('#btnEnvio<?=$nombreTab?>').attr("value","Editar");
	$('#comandosGrid<?=$nombreTab?>').hide();
	$('#comandosForm<?=$nombreTab?>').show();
	
	//TRAER DATA PARA LLENAR EL FORM
	$.ajax({
		type: "POST",
		url: "index.php?/<?=$controller?>/verEntidad/"+id,
		success: function(data){
			json=JSON.parse(data);
			//LLENAR EL FORMULARIO CON LOS DATOS //@
			$('#form<?=$nombreTab?>Standard')[0].id.value=json.id;
			$('#form<?=$nombreTab?>Standard')[0].fecha.value=json.fecha;
			$('#form<?=$nombreTab?>Standard')[0].hora.value=json.hora;
			$('#form<?=$nombreTab?>Standard')[0].informacion.value=json.informacion;
			$('#form<?=$nombreTab?>Standard')[0].seccion_id.value=json.seccion_id;
			$('#form<?=$nombreTab?>Standard')[0].seccion_id_aux.value=json.seccion_id+' ['+json.seccion_id_aux+']';
			$('#form<?=$nombreTab?>Standard')[0].profesor_id.value=json.profesor_id;
			$('#form<?=$nombreTab?>Standard')[0].profesor_id_aux.value=json.profesor_id+' ['+json.profesor_id_aux+']';
			$('#form<?=$nombreTab?>Standard')[0].usuario_id.value=json.usuario_id;
			$('#form<?=$nombreTab?>Standard')[0].usuario_id_aux.value=json.usuario_id+' ['+json.usuario_id_aux+']';
			$('#form<?=$nombreTab?>Standard')[0].asignatura_id.value=json.asignatura_id;
			$('#form<?=$nombreTab?>Standard')[0].asignatura_id_aux.value=json.asignatura_id+' ['+json.asignatura_id_aux+']';

		}
	});
	
	//SE MUESTRAN LOS IB BUTTON DE ESTE MODULO********************************
	$('#ib_lugar_id').show();
	$('#clean_lugar_id').show();
}

    
// Interceptamos el evento submit
$("#form<?=$nombreTab?>Standard").submit(function(){
	//Formulario valido
	if(!$(this).valid()) return false;
	// Enviamos el formulario usando AJAX
	var url = $(this).attr("action");
    $.ajax({
        type: 'POST',
        url: url,
        data: $(this).serialize(),
        // Mostramos un mensaje con la respuesta de PHP
        success: function(datos) {
			json=JSON.parse(datos);
			$("#mensaje<?=$nombreTab?>").html(json.msg);
			$('#mensaje<?=$nombreTab?>').fadeIn(500);
			$('#mensaje<?=$nombreTab?>').fadeOut(2000);
			if(json.exito){//SE HACE LA INSERCIÓN CORRECTAMENTE
				$('#dataGrid<?=$nombreTab?>').fadeIn(500);
				$('#dataForm<?=$nombreTab?>').fadeOut(500);
				$('#comandosGrid<?=$nombreTab?>').show();
				$('#comandosForm<?=$nombreTab?>').hide();
				jQuery("#grid<?=$nombreTab?>").clearGridData(true);
				jQuery("#grid<?=$nombreTab?>").setGridParam({url:"index.php?/<?=$controller?>/grid/<?=$keyTab?>",postData:{"livesearch":true},page:1}).trigger("reloadGrid");
			}
        }
    })        
    return false;
}); 
//////////////////////
//VALIDADOR DE FORMULARIOS
$("#form<?=$nombreTab?>Standard").validate();
//////////////////////
////  HASTA AQUI


<?php if($keyTab){ ?>
//FK DEFAULT FOR TAB - SIEMPE SE ASUME 1 KEY TAB
function fk<?=$nombreTab?>Default(){//NO TOCAR
	$('#form<?=$nombreTab?>Standard')[0].lugar_id.value=<?=$keyTab?>;//@
	$('#form<?=$nombreTab?>Standard')[0].lugar_id_aux.value=<?=$keyTab?>;//@
	$('#ib_lugar_id').hide();
	$('#clean_lugar_id').hide();
}
///////
<?php } ?>




<?php if(!$inputBuscador){?>
//CALL INPUT BUSCADOR 
$('#ib_seccion_id').click(function()
	{
		$.ajax({
			type: "POST",
			url: 'index.php?/seccion_controller/cargaModulo/IBSeccion/seccion_id',
			success: function(datos){
				$("#ib_content").html(datos);
				showIB();
			}
		});
	}
);

function fk_seccion_id(valor){//@
	$('#form<?=$nombreTab?>Standard')[0].seccion_id.value=valor;//@
	$('#form<?=$nombreTab?>Standard')[0].seccion_id_aux.value=valor+fkName('IBSeccion',valor,2);//@ 
	$("#ib").hide();
}
//FIN CALL INPUT BUSCADOR 
<?php } ?>



<?php if(!$inputBuscador){?>
//CALL INPUT BUSCADOR 
$('#ib_profesor_id').click(function()
	{
		$.ajax({
			type: "POST",
			url: 'index.php?/profesor_controller/cargaModulo/IBProfesor/profesor_id',
			success: function(datos){
				$("#ib_content").html(datos);
				showIB();
			}
		});
	}
);

function fk_profesor_id(valor){//@
	$('#form<?=$nombreTab?>Standard')[0].profesor_id.value=valor;//@
	$('#form<?=$nombreTab?>Standard')[0].profesor_id_aux.value=valor+fkName('IBProfesor',valor,2);//@ 
	$("#ib").hide();
}
//FIN CALL INPUT BUSCADOR 
<?php } ?>


<?php if(!$inputBuscador){?>
//CALL INPUT BUSCADOR 
$('#ib_usuario_id').click(function()
	{
		$.ajax({
			type: "POST",
			url: 'index.php?/usuario_controller/cargaModulo/IBUsuario/usuario_id',
			success: function(datos){
				$("#ib_content").html(datos);
				showIB();
			}
		});
	}
);

function fk_usuario_id(valor){//@
	$('#form<?=$nombreTab?>Standard')[0].usuario_id.value=valor;//@
	$('#form<?=$nombreTab?>Standard')[0].usuario_id_aux.value=valor+fkName('IBUsuario',valor,2);//@ 
	$("#ib").hide();
}
//FIN CALL INPUT BUSCADOR 
<?php } ?>

<?php if(!$inputBuscador){?>
//CALL INPUT BUSCADOR 
$('#ib_asignatura_id').click(function()
	{
		$.ajax({
			type: "POST",
			url: 'index.php?/asignatura_controller/cargaModulo/IBAsignatura/asignatura_id',
			success: function(datos){
				$("#ib_content").html(datos);
				showIB();
			}
		});
	}
);

function fk_asignatura_id(valor){//@
	$('#form<?=$nombreTab?>Standard')[0].asignatura_id.value=valor;//@
	$('#form<?=$nombreTab?>Standard')[0].asignatura_id_aux.value=valor+fkName('IBAsignatura',valor,2);//@ 
	$("#ib").hide();
}
//FIN CALL INPUT BUSCADOR 
<?php } ?>






</script>



