<?php  //if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//if(!class_exists('CI_Model')) { class CI_Model extends Model {} }


class Informacion_model extends CI_Model {//@

	function Informacion_model(){
		parent::CI_Model();
		$this->load->model('Backend_model','bModel');
	}

	function grid($p,$o){
	
		//construct where clause 
		$where = "WHERE 1=1";
		
		//BLOQUE FILTRO //@
		if($o->id!='') $where.= " AND a.id LIKE '$o->id%' ";
		if($o->fecha!='') $where.= " AND a.fecha LIKE '$o->fecha%' ";
		if($o->hora!='') $where.= " AND a.hora LIKE '$o->hora%' ";
		if($o->informacion!='') $where.= " AND a.informacion LIKE '$o->informacion%' ";
		if($o->seccion_id!='') $where.= " AND a.seccion_id LIKE '$o->seccion_id%' ";
		if($o->profesor_id!='') $where.= " AND a.profesor_id LIKE '$o->profesor_id%' ";
		if($o->usuario_id!='') $where.= " AND a.usuario_id LIKE '$o->usuario_id%' ";
		if($o->asignatura_id!='') $where.= " AND a.asignatura_id LIKE '$o->asignatura_id%' ";


		//FIN BLOQUE FILTRO
		
		//PAGINADOR
		$queryCount="SELECT COUNT(*) AS count FROM informacion as a ".$where;//@
		$resultCount=$this->db->query($queryCount);
		foreach($resultCount->result() as $rsCount){	
			$count =$rsCount->count;
		}
		if( $count >0 ) { $total_pages = ceil($count/$p->limit); } else { $total_pages = 0; } 
		if ($p->page > $total_pages) $p->page=$total_pages; 
		$start = $p->limit*$p->page - $p->limit; 
		//@
		$queryData = "SELECT a.*,p.nombre as nombreProfesor,asi.nombre as nombreAsignatura
		FROM informacion as a,seccion as s,profesor as p,usuario as u,asignatura as asi where
		 s.id=a.seccion_id and p.id=a.profesor_id and u.id=a.usuario_id and asi.id=a.asignatura_id ORDER BY $p->sidx $p->sord LIMIT $p->limit offset $start "; 
		
		$result = $this->db->query($queryData);
        if ($result->num_rows() > 0)
		{
			$i=0;
			foreach($result->result() as $rs){//@
				$response->rows[$i]['id']=$rs->id; 
				$profesor=" [".$rs->nombreProfesor."]";
				$asignatura=" [".$rs->nombreAsignatura."]";
				$response->rows[$i]['cell']=array($rs->id,$rs->fecha,$rs->hora,$rs->informacion,$rs->seccion_id,$rs->profesor_id.$profesor,$rs->usuario_id,$rs->asignatura_id.$asignatura);  
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
		"fecha" => $o->fecha,
		"hora" => $o->hora,
		"informacion" => $o->informacion,
		"seccion_id" => $o->seccion_id,
		"profesor_id" => $profesor_id,
		"usuario_id" => $o->usuario_id,
		"asignatura_id" => $o->asignatura_id
		);

		$result=$this->db->insert("informacion",$query);//@
		
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
		"fecha" => $o->fecha,
		"hora" => $o->hora,
		"informacion" => $o->informacion,
		"seccion_id" => $o->seccion_id,
		"profesor_id" => $o->profesor_id,
		"usuario_id" => $o->usuario_id,
		"asignatura_id" => $o->asignatura_id
		);
		$this->db->where("id",$key);//@
		$result=$this->db->update("informacion",$query);//@
		
		if($result)
	    return true;
	    else
	    return false;
	}
	
	//RETORNA TUPLA SOLICITADA**********************************
	function verEntidad($key){
		
		
        $query = "SELECT a.id,a.fecha,a.hora,a.informacion,a.seccion_id,a.profesor_id,a.usuario_id,a.asignatura_id,
		p.nombre as nombreProfesor,asi.nombre as nombreAsignatura,u.nombre as nombreUsuario,s.nombre as nombreSeccion
		FROM informacion as a,seccion as s, profesor as p,usuario as u, asignatura as asi
		WHERE a.id='$key' and p.id=a.profesor_id and s.id=a.seccion_id and u.id=a.usuario_id and asi.id=a.asignatura_id";
		
		
		//$query = "SELECT * FROM atencion as a WHERE a.id='$key' ";
		
		
		//si no tiene fk el and no va y en el select se pone *
		$result=$this->db->query($query);
        
        foreach($result->result() as $rs)
		{
			$o=new stdClass();//@****************************************************+
			$o->id=$rs->id;
			$o->fecha=$rs->fecha;
			$o->hora=$rs->hora;
			$o->informacion=$rs->informacion;
			$o->seccion_id=$rs->seccion_id;
			$o->seccion_id_aux=$rs->nombreSeccion;
			$o->profesor_id=$rs->profesor_id;
			$o->profesor_id_aux=$rs->nombreProfesor;
			$o->usuario_id=$rs->usuario_id;
			$o->usuario_id_aux=$rs->nombreUsuario;
			$o->asignatura_id=$rs->asignatura_id;
			$o->asignatura_id_aux=$rs->nombreAsignatura;


		}
		return $o;
		
		
	}
	
	//ELIMINA 1 TUPLA EN BD
	function eliminar($key){
		
		$this->db->where("id",$key);//@
		$result=$this->db->delete("informacion");//@
	
		if($result)
        return true;
        else
        return false;

	}
	
	
	

}

?>