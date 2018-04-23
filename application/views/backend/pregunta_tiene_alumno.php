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
			<th>PREGUNTA_ID</th>
			<td><input type="hidden" id="pregunta_id" name="pregunta_id" value="" ><input type="text" size="30" id="pregunta_id_aux" name="pregunta_id_aux" value="" class="required readonly"  readonly ></input>

			<span id="ib_tema_id" class="ibButton"></span>
			<span id="clean_tema_id" class="cleanButton" onclick="javascript:limpiar('pregunta_id');limpiar('pregunta_id_aux')"></span></td>
		</tr>
		<tr>
			<th>ALUMNO_ID</th>
			<td><input type="hidden" id="alumno_id" name="alumno_id" value="" ><input type="text" size="30" id="alumno_id_aux" name="alumno_id_aux" value="" class="required readonly"  readonly ></input>

			<span id="ib_alumno_id" class="ibButton"></span>
			<span id="clean_alumno_id" class="cleanButton" onclick="javascript:limpiar('alumno_id');limpiar('alumno_id_aux')"></span></td>
		</tr>
		<tr>
			<th>RESPUESTA</th>
			<td><input type="text" id="respuesta" name="respuesta" value="" class="required"  ></input></td>
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
    colNames:['ID','PREGUNTA_ID','ALUMNO_ID','RESPUESTA'],//@
    colModel:[//@
        {name:'id',index:'id', width:60},
		{name:'pregunta_id',index:'pregunta_id', width:60},
		{name:'alumno_id',index:'alumno_id', width:60},
		{name:'respuesta',index:'respuesta', width:60}
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
		fk_pregunta_tiene_alumno_id(id);//@ 
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
$("#gs_pregunta_id").attr("id","f_pregunta_id<?=$nombreTab?>");
$("#gs_alumno_id").attr("id","f_alumno_id<?=$nombreTab?>");
$("#gs_respuesta").attr("id","f_respuesta<?=$nombreTab?>");



var timeoutHnd<?=$nombreTab?>;
jQuery("table .ui-search-toolbar :input").keyup(function(e){
	if(timeoutHnd<?=$nombreTab?>) {
		clearTimeout(timeoutHnd<?=$nombreTab?>); 
	}
	timeoutHnd<?=$nombreTab?> = setTimeout(grid<?=$nombreTab?>Reload,500);
});

function grid<?=$nombreTab?>Reload(){//@
	var f_id = jQuery("#f_id<?=$nombreTab?>").val();
	var f_pregunta_id = jQuery("#f_pregunta_id<?=$nombreTab?>").val();
	var f_alumno_id = jQuery("#f_alumno_id<?=$nombreTab?>").val();
	var f_respuesta = jQuery("#f_respuesta<?=$nombreTab?>").val();
	

	//@
	jQuery("#grid<?=$nombreTab?>").setGridParam({url:"index.php?/<?=$controller?>/grid/<?=$keyTab?>",postData:{"livesearch":true,"f_id":f_id,"f_pregunta_id":f_pregunta_id,"f_alumno_id":f_alumno_id,"f_respuesta":f_respuesta},page:1}).trigger("reloadGrid");
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
			$('#form<?=$nombreTab?>Standard')[0].pregunta_id.value=json.pregunta_id;
			$('#form<?=$nombreTab?>Standard')[0].pregunta_id_aux.value=json.pregunta_id+' ['+json.pregunta_id_aux+']';
			$('#form<?=$nombreTab?>Standard')[0].alumno_id.value=json.alumno_id;
			$('#form<?=$nombreTab?>Standard')[0].alumno_id_aux.value=json.alumno_id+' ['+json.alumno_id_aux+']';
			$('#form<?=$nombreTab?>Standard')[0].respuesta.value=json.respuesta;
		
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
$('#ib_pregunta_id').click(function()
	{
		$.ajax({
			type: "POST",
			url: 'index.php?/pregunta_controller/cargaModulo/IBPregunta/pregunta_id',
			success: function(datos){
				$("#ib_content").html(datos);
				showIB();
			}
		});
	}
);

function fk_pregunta_id(valor){//@
	$('#form<?=$nombreTab?>Standard')[0].pregunta_id.value=valor;//@
	$('#form<?=$nombreTab?>Standard')[0].pregunta_id_aux.value=valor+fkName('IBPregunta',valor,2);//@ 
	$("#ib").hide();
}
//FIN CALL INPUT BUSCADOR 
<?php } ?>


<?php if(!$inputBuscador){?>
//CALL INPUT BUSCADOR 
$('#ib_alumno_id').click(function()
	{
		$.ajax({
			type: "POST",
			url: 'index.php?/alumno_controller/cargaModulo/IBAlumno/alumno_id',
			success: function(datos){
				$("#ib_content").html(datos);
				showIB();
			}
		});
	}
);

function fk_alumno_id(valor){//@
	$('#form<?=$nombreTab?>Standard')[0].alumno_id.value=valor;//@
	$('#form<?=$nombreTab?>Standard')[0].alumno_id_aux.value=valor+fkName('IBAlumno',valor,2);//@ 
	$("#ib").hide();
}
//FIN CALL INPUT BUSCADOR 
<?php } ?>












</script>



