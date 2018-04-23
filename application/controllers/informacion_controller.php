<?php

class Informacion_controller extends Controller {//@
    private $data;
	private $myModel='Informacion_model';//@
    
    function Informacion_controller(){//@
        parent::Controller();
		$this->load->model($this->myModel,'model');
		$this->load->model('Backend_model','bModel');
    }

	function cargaModulo($nombreTab='',$inputBuscador=false,$keyTab='',$keyTab='',$keyTab=''){//******************@ AGREGAR TANTOS KEYTAB COMO FK TENGA LA TABLA
		
		$this->data['inputBuscador']=($inputBuscador=='false')?false:$inputBuscador;
		$this->data['keyTab']=$keyTab;
		$this->data['nombreTab']=$nombreTab;
		$this->data['controller']="informacion_controller";//@lowercase
		$this->data['nombreModulo']="Informacion";//@
        $this->load->view('backend/informacion',$this->data);//@
    }
	
	function grid($keyTab=''){
		//PARAMETROS
		$p=new stdClass();
		
		$p->page = $_REQUEST['page']; // get the requested page 
		$p->limit = $_REQUEST['rows']; // get how many rows we want to have into the grid 
		$p->sidx = $_REQUEST['sidx']; // get index row - i.e. user click to sort 
		$p->sord = $_REQUEST['sord']; // get the direction 
		
		//OBJETO ENTIDAD PARA FILTRO
		$o=new stdClass();//@
		$o->id=(isset($_REQUEST['f_id']))?$_REQUEST['f_id']:'';
		$o->fecha=(isset($_REQUEST['f_fecha']))?$_REQUEST['f_fecha']:'';
		$o->hora=(isset($_REQUEST['f_hora']))?$_REQUEST['f_hora']:'';
		$o->informacion=(isset($_REQUEST['f_informacion']))?$_REQUEST['f_informacion']:'';
		$o->seccion_id=(isset($_REQUEST['f_seccion_id']))?$_REQUEST['f_seccion_id']:'';
		$o->profesor_id=(isset($_REQUEST['f_profesor_id']))?$_REQUEST['f_profesor_id']:'';
		$o->usuario_id=(isset($_REQUEST['f_usuario_id']))?$_REQUEST['f_usuario_id']:'';
		$o->asignatura_id=(isset($_REQUEST['f_asignatura_id']))?$_REQUEST['f_asignatura_id']:'';
		
	
		
	
		if($keyTab)//APLICA A FK
		$o->lugar_id=$keyTab;
		
		//INSTANCIA AL MODELO
		$response=$this->model->grid($p,$o);
		echo json_encode($response);
		
	}
	
	function insertar(){
	
		//CREAR OBJETO QUE SE VA A INSERTAR CON LOS $_REQUEST RECIBIDOS DEL FORMULARIO
		$o=new stdClass();//@
		$o->id=$_REQUEST['id'];
		$o->fecha=$_REQUEST['fecha'];
		$o->hora=$_REQUEST['hora'];
		$o->informacion=$_REQUEST['informacion'];
		$o->seccion_id=$_REQUEST['seccion_id'];
		$o->profesor_id=$_REQUEST['profesor_id'];
		$o->usuario_id=$_REQUEST['usuario_id'];
		$o->asignatura_id=$_REQUEST['asignatura_id'];

	
			
		//INSTANCIA AL MODELO
		$result=$this->model->insertar($o);//RESPUESTA TRUE/FALSE
	
		$response=new StdClass();
		if($result){
			$response->exito=true;
			$response->msg=$this->bModel->MSG_EXITO_INSERTAR;
		}else{
			$response->exito=false;
			$response->msg=$this->bModel->MSG_ERROR_INSERTAR;
		}
		echo json_encode($response); 
	}
	
	function editar($key){
		//CREAR OBJETO QUE SE VA A EDITAR CON LOS $_REQUEST RECIBIDOS DEL FORMULARIO
		$o=new stdClass();//@
		$o->id=$_REQUEST['id'];
		$o->fecha=$_REQUEST['fecha'];
		$o->hora=$_REQUEST['hora'];
		$o->informacion=$_REQUEST['informacion'];
		$o->seccion_id=$_REQUEST['seccion_id'];
		$o->profesor_id=$_REQUEST['profesor_id'];
		$o->usuario_id=$_REQUEST['usuario_id'];
		$o->asignatura_id=$_REQUEST['asignatura_id'];
		
		

       
		//$key DEBE SER LA PK DE LA TABLA, PARAMETRO RECIBIDO DEL ACTION DEL FORMULARIO
		//INSTANCIA AL MODELO
		$result=$this->model->editar($key,$o);//RESPUESTA TRUE/FALSE
			
		$response=new StdClass();
		if($result){
			$response->exito=true;
			$response->msg=$this->bModel->MSG_EXITO_EDITAR;
		}else{
			$response->exito=false;
			$response->msg=$this->bModel->MSG_ERROR_EDITAR;
		}
		echo json_encode($response);
	
	}
	
	function verEntidad($key){
		//INSTANCIA AL MODELO
		$response=$this->model->verEntidad($key);
		echo json_encode($response);
	}
	
	function eliminar($key){
	
		//$key DEBE SER LA PK DE LA TABLA, 
		//INSTANCIA AL MODELO
		$result=$this->model->eliminar($key);
		
		$response=new StdClass();
		if($result){
			$response->exito=true;
			$response->msg=$this->bModel->MSG_EXITO_ELIMINAR;
		}else{
			$response->exito=false;
			$response->msg=$this->bModel->MSG_ERROR_ELIMINAR;
		}
		echo json_encode($response);
	
	}
    
	
}
