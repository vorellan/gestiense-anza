<?php  //if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//if(!class_exists('CI_Model')) { class CI_Model extends Model {} }


class Carrera_model extends CI_Model {//@

	function grid($p,$o){
	
		//construct where clause 
		$where = "WHERE 1=1";
		
		//BLOQUE FILTRO //@
		if($o->id!='') $where.= " AND id LIKE '$o->id%' ";
		if($o->codigo !='') $where.= " AND codigo LIKE '$o->codigo%' ";
		if($o->carrera !='') $where.= " AND carrera LIKE '$o->carrera%' ";


		//FIN BLOQUE FILTRO
		
		//PAGINADOR
		$queryCount="SELECT COUNT(*) AS count FROM carrera ".$where;//@
		$resultCount=$this->db->query($queryCount);
		foreach($resultCount->result() as $rsCount){	
			$count =$rsCount->count;
		}
		if( $count >0 ) { $total_pages = ceil($count/$p->limit); } else { $total_pages = 0; } 
		if ($p->page > $total_pages) $p->page=$total_pages; 
		$start = $p->limit*$p->page - $p->limit; 
		//@
		$queryData = "SELECT * FROM carrera ".$where." ORDER BY $p->sidx $p->sord LIMIT $p->limit offset $start "; 
		
		$result = $this->db->query($queryData);
        if ($result->num_rows() > 0)
		{
			$i=0;
			foreach($result->result() as $rs){//@
				$response->rows[$i]['id']=$rs->id; 
				$response->rows[$i]['cell']=array($rs->id,$rs->codigo,$rs->carrera);  
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
		"codigo" => $o->codigo,
		"carrera" => $o->carrera,
		);

		$result=$this->db->insert("carrera",$query);//@
		
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
		"codigo" => $o->codigo,
		"carrera" => $o->carrera
		);
		$this->db->where("id",$key);//@
		$result=$this->db->update("carrera",$query);//@
		
		if($result)
	    return true;
	    else
	    return false;
	}
	
	//RETORNA TUPLA SOLICITADA
	function verEntidad($key){
		
        $query = "SELECT * FROM carrera as p WHERE p.id='$key' ";
		
		//$query = "SELECT * FROM paciente as p WHERE p.rut='$key' ";
		
		
		//si no tiene fk el and no va y en el select se pone *
		$result=$this->db->query($query);
        
        foreach($result->result() as $rs)
		{
			$o=new stdClass();//@
			$o->id=$rs->id;
			$o->codigo=$rs->codigo;
			$o->carrera=$rs->carrera;

		}
		return $o;
		
		
	}
	
	//ELIMINA 1 TUPLA EN BD
	function eliminar($key){
		
		$this->db->where("id",$key);//@
		$result=$this->db->delete("carrera");//@
	
		if($result)
        return true;
        else
        return false;

	}
	
	
	

}

?>