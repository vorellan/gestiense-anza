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
			<td><input type="text" size="30" id="id" name="id" value="" class="required"  ></input></td>
		</tr>
		<tr>
			<th>NOMBRE</th>
			<td><input type="text" id="nombre" name="nombre" value="" class="required"  ></input></td>
		</tr>
		<tr>
			<th>USUARIO</th>
			<td><input type="text" id="usuario" name="usuario" value="" class="required"  ></input></td>
		</tr>
		<tr>
			<th>FACULTAD</th>
			<td><input type="text" id="facultad" name="facultad" value="" class="required"  ></input></td>
		</tr>
		<tr>
			<th>PASSWORD</th>
			<td><input type="text" id="password" name="password" value="" class="required"  ></input></td>
		</tr>
		<tr>
			<th>TIPO_USUARIO</th>
			<td><input type="text" id="tipo_usuario" name="tipo_usuario" value="" class="required"  ></input></td>
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

//SCRIPT grid
var mygrid<?=$nombreTab?>=jQuery("#grid<?=$nombreTab?>").jqGrid({
    url:'index.php?/<?=$controller?>/grid/<?=$keyTab?>',  
    datatype: "json",
    width:900,
    height:'auto',
    colNames:['ID','NOMBRE','USUARIO','FACULTAD','PASSWORD','TIPO_USUARIO'],//@
    colModel:[//@
        {name:'id',index:'id', width:60},
		{name:'nombre',index:'nombre', width:60},
		{name:'usuario',index:'usuario', width:60},
		{name:'facultad',index:'facultad', width:60},
		{name:'password',index:'password', width:60},
		{name:'tipo_usuario',index:'tipo_usuario', width:60}
		
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
		fk_usuario_id(id);//@ 
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
$("#gs_nombre").attr("id","f_nombre<?=$nombreTab?>");
$("#gs_usuario").attr("id","f_usuario<?=$nombreTab?>");
$("#gs_facultad").attr("id","f_facultad<?=$nombreTab?>");
$("#gs_password").attr("id","f_password<?=$nombreTab?>");
$("#gs_tipo_usuario").attr("id","f_tipo_usuario<?=$nombreTab?>");



var timeoutHnd<?=$nombreTab?>;
jQuery("table .ui-search-toolbar :input").keyup(function(e){
	if(timeoutHnd<?=$nombreTab?>) {
		clearTimeout(timeoutHnd<?=$nombreTab?>); 
	}
	timeoutHnd<?=$nombreTab?> = setTimeout(grid<?=$nombreTab?>Reload,500);
});

function grid<?=$nombreTab?>Reload(){//@
	var f_id = jQuery("#f_id<?=$nombreTab?>").val();
	var f_nombre = jQuery("#f_nombre<?=$nombreTab?>").val();
	var f_usuario = jQuery("#f_usuario<?=$nombreTab?>").val();
	var f_facultad = jQuery("#f_facultad<?=$nombreTab?>").val();
	var f_password = jQuery("#f_password<?=$nombreTab?>").val();
	var f_tipo_usuario = jQuery("#f_tipo_usuario<?=$nombreTab?>").val();
	//@
	jQuery("#grid<?=$nombreTab?>").setGridParam({url:"index.php?/<?=$controller?>/grid/<?=$keyTab?>",postData:{"livesearch":true,"f_id":f_id,"f_nombre":f_nombre,"f_usuario":f_usuario,"f_facultad":f_facultad,"f_password":f_password,"f_tipo_usuario":f_tipo_usuario},page:1}).trigger("reloadGrid");
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
			$('#form<?=$nombreTab?>Standard')[0].nombre.value=json.nombre;
			$('#form<?=$nombreTab?>Standard')[0].usuario.value=json.usuario;
			$('#form<?=$nombreTab?>Standard')[0].facultad.value=json.facultad;
			$('#form<?=$nombreTab?>Standard')[0].password.value=json.password;
			$('#form<?=$nombreTab?>Standard')[0].tipo_usuario.value=json.tipo_usuario;
			
		}
	});
	
	//SE MUESTRAN LOS IB BUTTON DE ESTE MODULO
	$('#ib_usuario_id').show();
	$('#clean_usuario_id').show();
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
	$('#form<?=$nombreTab?>Standard')[0].usuario_id.value=<?=$keyTab?>;//@
	$('#form<?=$nombreTab?>Standard')[0].usuario_id_aux.value=<?=$keyTab?>;//@
	$('#ib_usuario_id').hide();
	$('#clean_usuario_id').hide();
}
///////
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






</script>



