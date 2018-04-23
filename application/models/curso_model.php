<?php  //if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//if(!class_exists('CI_Model')) { class CI_Model extends Model {} }


class Curso_model extends CI_Model {//@

	function Curso_model(){
		parent::CI_Model();
		$this->load->model('Backend_model','bModel');
	}

	function grid($p,$o){
	
		//construct where clause 
		$where = "WHERE 1=1";
		
		//BLOQUE FILTRO //@
		if($o->id!='') $where.= " AND a.id LIKE '$o->id%' ";
		if($o->profesor_id!='') $where.= " AND a.profesor_id LIKE '$o->profesor_id%' ";
		if($o->nombre!='') $where.= " AND a.nombre LIKE '$o->nombre%' ";

		


		//FIN BLOQUE FILTRO
		
		//PAGINADOR
		$queryCount="SELECT COUNT(*) AS count FROM curso as a ".$where;//@
		$resultCount=$this->db->query($queryCount);
		foreach($resultCount->result() as $rsCount){	
			$count =$rsCount->count;
		}
		if( $count >0 ) { $total_pages = ceil($count/$p->limit); } else { $total_pages = 0; } 
		if ($p->page > $total_pages) $p->page=$total_pages; 
		$start = $p->limit*$p->page - $p->limit; 
		//@
		$queryData = "SELECT a.*,p.id as nombreProfesor
		FROM curso as a,profesor as p ".$where." 
		 and p.id=a.profesor_id ORDER BY $p->sidx $p->sord LIMIT $p->limit offset $start "; 
		
		$result = $this->db->query($queryData);
        if ($result->num_rows() > 0)
		{
			$i=0;
			foreach($result->result() as $rs){//@
				$response->rows[$i]['id']=$rs->id; 
				$profesor=" [".$rs->nombreProfesor."]";
				$response->rows[$i]['cell']=array($rs->id,$rs->profesor_id.$profesor,$rs->nombre);  
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
		"profesor_id" => $o->profesor_id,
		"nombre" => $o->nombre
		);

		$result=$this->db->insert("curso",$query);//@
		
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
		"profesor_id" => $o->profesor_id,
		"nombre" => $o->nombre
		);
		$this->db->where("id",$key);//@
		$result=$this->db->update("curso",$query);//@
		
		if($result)
	    return true;
	    else
	    return false;
	}
	
	//RETORNA TUPLA SOLICITADA**********************************
	function verEntidad($key){
		
		
        $query = "SELECT a.id,a.profesor_id,a.nombre,
		p.nombre as nombreProfesor
		FROM curso as a, profesor as p
		WHERE a.id='$key' and p.id=a.profesor_id ";
		
		
		//$query = "SELECT * FROM atencion as a WHERE a.id='$key' ";
		
		
		//si no tiene fk el and no va y en el select se pone *
		$result=$this->db->query($query);
        
        foreach($result->result() as $rs)
		{
			$o=new stdClass();//@****************************************************+
			$o->id=$rs->id;
			$o->profesor_id=$rs->profesor_id;
			$o->profesor_id_aux=$rs->nombreProfesor;
			$o->nombre=$rs->nombre;




		}
		return $o;
		
		
	}
	
	//ELIMINA 1 TUPLA EN BD
	function eliminar($key){
		
		$this->db->where("id",$key);//@
		$result=$this->db->delete("curso");//@
	
		if($result)
        return true;
        else
        return false;

	}
	
	
	

}

?>