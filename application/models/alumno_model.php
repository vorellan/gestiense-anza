<?php  //if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//if(!class_exists('CI_Model')) { class CI_Model extends Model {} }


class Alumno_model extends CI_Model {//@

	function grid($p,$o){
	
		//construct where clause 
		$where = "WHERE 1=1";
		
		//BLOQUE FILTRO //@
		if($o->id!='') $where.= " AND id LIKE '$o->id%' ";
		if($o->nombre !='') $where.= " AND nombre LIKE '$o->nombre%' ";
		if($o->carrera !='') $where.= " AND carrera LIKE '$o->carrera%' ";
		if($o->user !='') $where.= " AND user LIKE '$o->user%' ";
		


		//FIN BLOQUE FILTRO
		
		//PAGINADOR
		$queryCount="SELECT COUNT(*) AS count FROM alumno ".$where;//@
		$resultCount=$this->db->query($queryCount);
		foreach($resultCount->result() as $rsCount){	
			$count =$rsCount->count;
		}
		if( $count >0 ) { $total_pages = ceil($count/$p->limit); } else { $total_pages = 0; } 
		if ($p->page > $total_pages) $p->page=$total_pages; 
		$start = $p->limit*$p->page - $p->limit; 
		//@
		$queryData = "SELECT * FROM alumno ".$where." ORDER BY $p->sidx $p->sord LIMIT $p->limit offset $start "; 
		
		$result = $this->db->query($queryData);
        if ($result->num_rows() > 0)
		{
			$i=0;
			foreach($result->result() as $rs){//@
				$response->rows[$i]['id']=$rs->id; 
				$response->rows[$i]['cell']=array($rs->id,$rs->nombre,$rs->carrera,$rs->user);  
				$i++;
			}
			
		}
		$response->page = $p->page; 
		$response->total = $total_pages; 
		$response->records = $count; 

		return $response;
	}
	
	//INSERTA 1 TUPLA EN BD
	function insertar($o){
		
		//@
		$query=array(
		"id" => $o->id,
		"nombre" => $o->nombre,
		"usuario" => $o->usuario,
		"facultad" => $o->facultad,
		"password" => $o->password,
		"tipo_usuario" => $o->tipo_usuario,
		);

		$result=$this->db->insert("usuario",$query);//@
		
		if($result)
		return true;
		else
		return false;
	}
	
	
	//ACTUALIZA 1 TUPLA EN BD
	function editar($key,$o){
		//@
		$query=array(
		"id" => $o->id,
		"nombre" => $o->nombre,
		"usuario" => $o->usuario,
		"facultad" => $o->facultad,
		"password" => $o->password,
		"tipo_usuario" => $o->tipo_usuario
		);
		$this->db->where("id",$key);//@
		$result=$this->db->update("usuario",$query);//@
		
		if($result)
	    return true;
	    else
	    return false;
	}
	
	//RETORNA TUPLA SOLICITADA
	function verEntidad($key){
		
        $query = "SELECT * FROM usuario as p WHERE p.id='$key' ";
		
		//$query = "SELECT * FROM paciente as p WHERE p.rut='$key' ";
		
		
		//si no tiene fk el and no va y en el select se pone *
		$result=$this->db->query($query);
        
        foreach($result->result() as $rs)
		{
			$o=new stdClass();//@
			$o->id=$rs->id;
			$o->nombre=$rs->nombre;
			$o->usuario=$rs->usuario;
			$o->facultad=$rs->facultad;
			$o->password=$rs->password;
			$o->tipo_usuario=$rs->tipo_usuario;

		}
		return $o;
		
		
	}
	
	//ELIMINA 1 TUPLA EN BD
	function eliminar($key){
		
		$this->db->where("id",$key);//@
		$result=$this->db->delete("usuario");//@
	
		if($result)
        return true;
        else
        return false;

	}
	
	
	

}

?>