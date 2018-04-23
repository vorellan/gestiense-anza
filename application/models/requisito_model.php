<?php  //if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//if(!class_exists('CI_Model')) { class CI_Model extends Model {} }


class Requisito_model extends CI_Model {//@

	function Requisito_model(){
		parent::CI_Model();
		$this->load->model('Backend_model','bModel');
	}

	function grid($p,$o){
	
		//construct where clause 
		$where = "WHERE 1=1";
		
		//BLOQUE FILTRO //@
		if($o->id!='') $where.= " AND a.id LIKE '$o->id%' ";
		if($o->subtema_id!='') $where.= " AND a.subtema_id LIKE '$o->subtema_id%' ";
		

		


		//FIN BLOQUE FILTRO
		
		//PAGINADOR
		$queryCount="SELECT COUNT(*) AS count FROM requisito as a ".$where;//@
		$resultCount=$this->db->query($queryCount);
		foreach($resultCount->result() as $rsCount){	
			$count =$rsCount->count;
		}
		if( $count >0 ) { $total_pages = ceil($count/$p->limit); } else { $total_pages = 0; } 
		if ($p->page > $total_pages) $p->page=$total_pages; 
		$start = $p->limit*$p->page - $p->limit; 
		//@
		$queryData = "SELECT a.*,p.nombre as nombreSubtema
		FROM requisito as a,subtema as p ".$where." 
		 and
		  p.id=a.subtema_id  ORDER BY $p->sidx $p->sord LIMIT $p->limit offset $start "; 
		
		$result = $this->db->query($queryData);
        if ($result->num_rows() > 0)
		{
			$i=0;
			foreach($result->result() as $rs){//@
				$response->rows[$i]['id']=$rs->id; 
				$subtema=" [".$rs->nombreSubtema."]";
				$response->rows[$i]['cell']=array($rs->id,$rs->subtema_id.$subtema);  
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
		"subtema_id" => $o->subtema_id
		);

		$result=$this->db->insert("requisito",$query);//@
		
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
		"nombre_seccion" => $o->nombre_seccion,
		"asignatura_id" => $o->asignatura_id,
		"profesor_id" => $o->profesor_id,
		);
		$this->db->where("id",$key);//@
		$result=$this->db->update("seccion",$query);//@
		
		if($result)
	    return true;
	    else
	    return false;
	}
	
	//RETORNA TUPLA SOLICITADA**********************************
	function verEntidad($key){
		
		
        $query = "SELECT a.id,a.nombre,a.asignatura_id,a.profesor_id,
		p.nombre as nombreProfesor,asi.nombre as nombreAsignatura
		FROM seccion as a, profesor as p, asignatura as asi
		WHERE a.id='$key' and p.id=a.profesor_id and asi.id=a.asignatura_id";
		
		
		//$query = "SELECT * FROM atencion as a WHERE a.id='$key' ";
		
		
		//si no tiene fk el and no va y en el select se pone *
		$result=$this->db->query($query);
        
        foreach($result->result() as $rs)
		{
			$o=new stdClass();//@****************************************************+
			$o->id=$rs->id;
			$o->nombre_seccion=$rs->nombre_seccion;
			$o->asignatura_id=$rs->asignatura_id;
			$o->asignatura_id_aux=$rs->nombreAsignatura;
			$o->profesor_id=$rs->profesor_id;
			$o->profesor_id_aux=$rs->nombreProfesor;




		}
		return $o;
		
		
	}
	
	//ELIMINA 1 TUPLA EN BD
	function eliminar($key){
		
		$this->db->where("id",$key);//@
		$result=$this->db->delete("seccion");//@
	
		if($result)
        return true;
        else
        return false;

	}
	
	
	

}

?>