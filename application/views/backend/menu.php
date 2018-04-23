<div  style="width:120px;">
	<table border="0" cellpadding="0" cellspacing="0" style="width:120px;height:400px">
		<tr>
			<td valign="top">
				<div class="accordion" >
						<h3>Modulos Principales</h3>
						<div id="menu">
							
							<?php if($permiso=="all"){?>
							<p><a href="#" c="index.php?/pregunta_controller/cargaModulo">Pregunta</a></p>
							<p><a href="#" c="index.php?/subtema_controller/cargaModulo">Subtema</a></p>
							<p><a href="#" c="index.php?/profesor_controller/cargaModulo">Profesor</a></p>
							<p><a href="#" c="index.php?/tema_tiene_requisito_controller/cargaModulo">Tema_tiene_requisito</a></p>
							<p><a href="#" c="index.php?/curso_controller/cargaModulo">Curso</a></p>
							<p><a href="#" c="index.php?/tema_controller/cargaModulo">Tema</a></p>
							<p><a href="#" c="index.php?/requisito_controller/cargaModulo">Requisito</a></p>
							<?php } ?>
							<p><a href="#" c="index.php?/alumno_controller/cargaModulo">Alumno</a></p>
							<p><a href="#" c="index.php?/pregunta_tiene_alumno_controller/cargaModulo">Pregunta_tiene_alumno</a></p>
							<!--<p><a href="#" c="http://localhost/tesis1/analizador/analizador.php">Analizador</a></p>
							<p><a href="#" c="http://localhost/tesis1/analizador/select.html">Estado</a></p>
							<p><a href="#" c="http://localhost/tesis1/analizador/mando.php">Cuadro de Mando</a></p>
							-->
						</div>
						
						
				</div>
				<!-- FIN MENU CASCADA -->
			</td>
		</tr>
	</table>
</div>

