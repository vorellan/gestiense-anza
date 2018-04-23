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
			<th>SUBTEMA ID</th>
			<td><input type="hidden" id="subtema_id" name="subtema_id" value="" ><input type="text" size="30" id="subtema_id_aux" name="subtema_id_aux" value="" class="required readonly"  readonly ></input>

			<span id="ib_subtema_id" class="ibButton"></span>
			<span id="clean_subtema_id" class="cleanButton" onclick="javascript:limpiar('subtema_id');limpiar('subtema_id_aux')"></span></td>
		</tr>
		<tr>
			<th>TITULO</th>
			<td><input type="text" size="30" id="titulo" name="titulo" value="" class="required"  ></input></td>
		</tr>
		<tr>
			<th>ALTERNATIVA 1</th>
			<td><input type="text" size="30" id="alternativa1" name="alternativa1" value="" class="required"  ></input></td>
		</tr>
		<tr>
			<th>ALTERNATIVA 2</th>
			<td><input type="text" size="30" id="alternativa2" name="alternativa2" value="" class="required"  ></input></td>
		</tr>
		<tr>
			<th>ALTERNATIVA 3</th>
			<td><input type="text" size="30" id="alternativa3" name="alternativa3" value="" class="required"  ></input></td>
		</tr>
		<tr>
			<th>ALTERNATIVA 4</th>
			<td><input type="text" size="30" id="alternativa4" name="alternativa4" value="" class="required"  ></input></td>
		</tr>
		<tr>
			<th>CORRECTA</th>
			<td><input type="text" size="30" id="correcta" name="correcta" value="" class="required"  ></input></td>
		</tr>
		<tr>
			<th>TIEMPO</th>
			<td><input type="text" size="30" id="tiempo" name="tiempo" value="" class="required"  ></input></td>
		</tr>
		<tr>
			<th>FLAG</th>
			<td><input type="text" size="30" id="flag" name="flag" value="" class="required"  ></input></td>
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
    colNames:['ID','SUBTEMA_ID','TITULO','ALTERNATIVA1','ALTERNATIVA2','ALTERNATIVA3','ALTERNATIVA4','CORRECTA','TIEMPO','FLAG'],//@
    colModel:[//@
        {name:'id',index:'id', width:60},
		{name:'subtema_id',index:'subtema_id', width:60},
		{name:'titulo',index:'titulo', width:60},
		{name:'alternativa1',index:'alternativa1', width:60},
		{name:'alternativa2',index:'alternativa2', width:60},
		{name:'alternativa3',index:'alternativa3', width:60},
		{name:'alternativa4',index:'alternativa4', width:60},
		{name:'correcta',index:'correcta', width:60},
		{name:'tiempo',index:'tiempo', width:60},
		{name:'flag',index:'flag', width:60}
		
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
		fk_pregunta_id(id);//@ 
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
$("#gs_subtema_id").attr("id","f_subtema_id<?=$nombreTab?>");
$("#gs_titulo").attr("id","f_titulo<?=$nombreTab?>");
$("#gs_alternativa1").attr("id","f_alternativa1<?=$nombreTab?>");
$("#gs_alternativa2").attr("id","f_alternativa2<?=$nombreTab?>");
$("#gs_alternativa3").attr("id","f_alternativa3<?=$nombreTab?>");
$("#gs_alternativa4").attr("id","f_alternativa4<?=$nombreTab?>");
$("#gs_correcta").attr("id","f_correcta<?=$nombreTab?>");
$("#gs_tiempo").attr("id","f_tiempo<?=$nombreTab?>");
$("#gs_flag").attr("id","f_flag<?=$nombreTab?>");





var timeoutHnd<?=$nombreTab?>;
jQuery("table .ui-search-toolbar :input").keyup(function(e){
	if(timeoutHnd<?=$nombreTab?>) {
		clearTimeout(timeoutHnd<?=$nombreTab?>); 
	}
	timeoutHnd<?=$nombreTab?> = setTimeout(grid<?=$nombreTab?>Reload,500);
});

function grid<?=$nombreTab?>Reload(){//@
	var f_id = jQuery("#f_id<?=$nombreTab?>").val();
	var f_subtema_id = jQuery("#f_subtema_id<?=$nombreTab?>").val();
	var f_titulo = jQuery("#f_titulo<?=$nombreTab?>").val();
	var f_alternativa1 = jQuery("#f_alternativa1<?=$nombreTab?>").val();
	var f_alternativa2 = jQuery("#f_alternativa2<?=$nombreTab?>").val();
	var f_alternativa3 = jQuery("#f_alternativa3<?=$nombreTab?>").val();
	var f_alternativa4 = jQuery("#f_alternativa4<?=$nombreTab?>").val();
	var f_correcta = jQuery("#f_correcta<?=$nombreTab?>").val();
	var f_tiempo = jQuery("#f_tiempo<?=$nombreTab?>").val();
	var f_flag = jQuery("#f_flag<?=$nombreTab?>").val();

	


	//@
	jQuery("#grid<?=$nombreTab?>").setGridParam({url:"index.php?/<?=$controller?>/grid/<?=$keyTab?>",postData:{"livesearch":true,"f_id":f_id,"f_subtema_id":f_subtema_id,"f_titulo":f_titulo,"f_alternativa1":f_alternativa1,"f_alternativa2":f_alternativa2,"f_alternativa3":f_alternativa3,"f_alternativa4":f_alternativa4,"f_correcta":f_correcta,"f_tiempo":f_tiempo,"f_flag":f_flag},page:1}).trigger("reloadGrid");
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
			$('#form<?=$nombreTab?>Standard')[0].subtema_id.value=json.subtema_id;
			$('#form<?=$nombreTab?>Standard')[0].subtema_id_aux.value=json.subtema_id+' ['+json.subtema_id_aux+']';
			$('#form<?=$nombreTab?>Standard')[0].titulo.value=json.titulo;
			$('#form<?=$nombreTab?>Standard')[0].alternativa1.value=json.alternativa1;
			$('#form<?=$nombreTab?>Standard')[0].alternativa2.value=json.alternativa2;
			$('#form<?=$nombreTab?>Standard')[0].alternativa3.value=json.alternativa3;
			$('#form<?=$nombreTab?>Standard')[0].alternativa4.value=json.alternativa4;
			$('#form<?=$nombreTab?>Standard')[0].correcta.value=json.correcta;
			$('#form<?=$nombreTab?>Standard')[0].tiempo.value=json.tiempo;
			$('#form<?=$nombreTab?>Standard')[0].flag.value=json.flag;



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
$('#ib_subtema_id').click(function()
	{
		$.ajax({
			type: "POST",
			url: 'index.php?/subtema_controller/cargaModulo/IBSubema/subtema_id',
			success: function(datos){
				$("#ib_content").html(datos);
				showIB();
			}
		});
	}
);

function fk_subtema_id(valor){//@
	$('#form<?=$nombreTab?>Standard')[0].subtema_id.value=valor;//@
	$('#form<?=$nombreTab?>Standard')[0].subtema_id_aux.value=valor+fkName('IBSubema',valor,2);//@ 
	$("#ib").hide();
}
//FIN CALL INPUT BUSCADOR 
<?php } ?>









</script>



