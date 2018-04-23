<div id="ib">
	<div id="ib_handle">			
		<a href="#" id="close"></a>
		Haga doble click para seleccionar
	</div>
	<div id="ib_content">
	</div>
</div>

<script>

$('#ib').Draggable(
	{
		zIndex: 	20,
		ghosting:	false,
		opacity: 	0.7,
		handle:	'#ib_handle'
	}
);	

$('#ib_form').ajaxForm({
	target: '#content',
	success: function() 
	{
		$("#ib").hide();
	}				
});			

$("#ib").hide();

$('#close').click(function()
	{
		$("#ib").hide();
	}
);



function showIB(){
	//POSICIONAR IB CORRECTAMENTE
	$("#ib").show();
}

function fkName(){//NOMBRE IB,KEY,COLUMNAS GRID
	var id_aux='#grid'+arguments[0]+' #'+arguments[1]+' td';
	var texto=' [';
	for (x=2;x<arguments.length;x++){
		if(x!=2) texto+=' ';
		texto+=$(id_aux)[arguments[x]].title;
	}
	texto+=']';
	return (texto);
}
  


</script>