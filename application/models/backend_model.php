<?php  //if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//if(!class_exists('CI_Model')) { class CI_Model extends Model {} }



class Backend_model extends CI_Model {

	public $MSG_EXITO_INSERTAR="Se ha insertado correctamente la entidad";
	public $MSG_ERROR_INSERTAR="No se pudo insertar la entidad";
	public $MSG_EXITO_EDITAR="Se ha modificado correctamente la entidad";
	public $MSG_ERROR_EDITAR="No se pudo modificar la entidad";
	public $MSG_EXITO_ELIMINAR="Se ha eliminado correctamente la entidad";
	public $MSG_ERROR_ELIMINAR="No se pudo eliminar la entidad";
	
	function formatDateToBD($date){
		$fecha=explode("/",$date);
		$fecha=$fecha[2]."-".$fecha[1]."-".$fecha[0];
		return $fecha;
	}
	

}

?>