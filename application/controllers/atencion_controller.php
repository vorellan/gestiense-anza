<?php

class Atencion_controller extends Controller {//@
    private $data;
	private $myModel='Atencion_model';//@
    
    function Atencion_controller(){//@
        parent::Controller();
		$this->load->model($this->myModel,'model');
		$this->load->model('Backend_model','bModel');
    }

	function cargaModulo($nombreTab='',$inputBuscador=false,$keyTab='',$keyTab='',$keyTab=''){//******************@ AGREGAR TANTOS KEYTAB COMO FK TENGA LA TABLA
		
		$this->data['inputBuscador']=($inputBuscador=='false')?false:$inputBuscador;
		$this->data['keyTab']=$keyTab;
		$this->data['nombreTab']=$nombreTab;
		$this->data['controller']="atencion_controller";//@lowercase
		$this->data['nombreModulo']="Atencion";//@
        $this->load->view('backend/atencion',$this->data);//@
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
		$o->paciente_rut=(isset($_REQUEST['f_paciente_rut']))?$_REQUEST['f_paciente_rut']:'';
		$o->examen_id=(isset($_REQUEST['f_examen_id']))?$_REQUEST['f_examen_id']:'';
		$o->usuario_user_name=(isset($_REQUEST['f_usuario_user_name']))?$_REQUEST['f_usuario_user_name']:'';
		$o->descripcion=(isset($_REQUEST['f_descripcion']))?$_REQUEST['f_descripcion']:'';
		$o->fecha=(isset($_REQUEST['f_fecha']))?$_REQUEST['f_fecha']:'';
		$o->confirmacion=(isset($_REQUEST['f_confirmacion']))?$_REQUEST['f_confirmacion']:'';
		
	
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
		$o->paciente_rut=$_REQUEST['paciente_rut'];
		$o->examen_id=$_REQUEST['examen_id'];
		$o->usuario_user_name=$_REQUEST['usuario_user_name'];
		$o->descripcion=$_REQUEST['descripcion'];
		$o->fecha=$_REQUEST['fecha'];
		$o->hora_h=$_REQUEST['hora_h'];
		$o->hora_m=$_REQUEST['hora_m'];
		$o->confirmacion=$_REQUEST['confirmacion'];
		
	
			
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
		$o->paciente_rut=$_REQUEST['paciente_rut'];
		$o->examen_id=$_REQUEST['examen_id'];
		$o->usuario_user_name=$_REQUEST['usuario_user_name'];
		$o->descripcion=$_REQUEST['descripcion'];
		$o->fecha=$_REQUEST['fecha'];
		$o->hora_h=$_REQUEST['hora_h'];
		$o->hora_m=$_REQUEST['hora_m'];
		$o->confirmacion=$_REQUEST['confirmacion'];
		
		

       
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
