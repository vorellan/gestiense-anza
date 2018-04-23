<?php  //if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//if(!class_exists('CI_Model')) { class CI_Model extends Model {} }


class Asignatura_model extends CI_Model {//@

	function Asignatura_model(){
		parent::CI_Model();
		$this->load->model('Backend_model','bModel');
	}

	function grid($p,$o){
	
		//construct where clause 
		$where = "WHERE 1=1";
		
		//BLOQUE FILTRO //@
		if($o->id!='') $where.= " AND a.id LIKE '$o->id%' ";
		if($o->nombre!='') $where.= " AND a.nombre LIKE '$o->nombre%' ";
		if($o->tipo_curso!='') $where.= " AND a.tipo_curso LIKE '$o->tipo_curso%' ";
		


		//FIN BLOQUE FILTRO
		
		//PAGINADOR
		$queryCount="SELECT COUNT(*) AS count FROM asignatura as a ".$where;//@
		$resultCount=$this->db->query($queryCount);
		foreach($resultCount->result() as $rsCount){	
			$count =$rsCount->count;
		}
		if( $count >0 ) { $total_pages = ceil($count/$p->limit); } else { $total_pages = 0; } 
		if ($p->page > $total_pages) $p->page=$total_pages; 
		$start = $p->limit*$p->page - $p->limit; 
		//@
		$queryData = "SELECT * FROM asignatura ".$where." ORDER BY $p->sidx $p->sord LIMIT $p->limit offset $start ";  
		
		$result = $this->db->query($queryData);
        if ($result->num_rows() > 0)
		{
			$i=0;
			foreach($result->result() as $rs){//@
				$response->rows[$i]['id']=$rs->id; 
				$response->rows[$i]['cell']=array($rs->id,$rs->nombre,$rs->tipo_curso);  
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
		"tipo_curso" => $o->tipo_curso,
	
		);

		$result=$this->db->insert("asignatura",$query);//@
		
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
		"tipo_curso" => $o->tipo_curso
		);
		$this->db->where("id",$key);//@
		$result=$this->db->update("asignatura",$query);//@
		
		if($result)
	    return true;
	    else
	    return false;
	}
	
	//RETORNA TUPLA SOLICITADA**********************************
	function verEntidad($key){
		
		
        $query = "SELECT * FROM asignatura as p WHERE p.id='$key' ";
		
		
		//$query = "SELECT * FROM atencion as a WHERE a.id='$key' ";
		
		
		//si no tiene fk el and no va y en el select se pone *
		$result=$this->db->query($query);
        
        foreach($result->result() as $rs)
		{
			$o=new stdClass();//@****************************************************+
			$o->id=$rs->id;
			$o->nombre=$rs->nombre;
			$o->tipo_curso=$rs->tipo_curso;
	


		}
		return $o;
		
		
	}
	
	//ELIMINA 1 TUPLA EN BD
	function eliminar($key){
		
		$this->db->where("id",$key);//@
		$result=$this->db->delete("asignatura");//@
	
		if($result)
        return true;
        else
        return false;

	}
	
	
	

}

?>