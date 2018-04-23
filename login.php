<?php
if(!$_REQUEST["login"]){
?>
<form action="" method="post">
	<table align="center">
		<tr>
			<td>Login:</td>
			<td><input type="text" name="login"></td>
		</tr>
		<tr>
			<td>Password:</td>
			<td><input type="password" name="password"></td>
		<tr>
		<tr>
			<td></td>	
			<td><input type="submit" value="Enviar"></td>
		</tr>
	</table>
</form>
<?php 
}else{
	if($_REQUEST["login"]=="admin" && $_REQUEST["password"]=="1234")
	header ("Location: index.php?/backend/index/all");
	else if($_REQUEST["login"]=="secretaria" && $_REQUEST["password"]=="1234")
	header ("Location: index.php?/backend/index");
	else{
		echo "<div align='center'>Claves incorrectas</div><div align='center'><a href='login.php'>Volver</a></div>";
	}
	



}
?>






