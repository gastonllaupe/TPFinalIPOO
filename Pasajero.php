<?php
include_once "BaseDatos.php";

class Pasajero extends Persona{
    private $telefono;
    private $idViaje;
    private $mensajeoperacion;


    public function __construct(){
        parent::__construct();
        $this->telefono = "";
    }

    public function cargar($NroD,$Nom,$Ape,$telefono=null,$idViaje=null){
	    parent::cargar($NroD, $Nom, $Ape);
	    $this->setTelefono($telefono);
		$this->setIdViaje($idViaje);
    }


    public function getTelefono(){
        return $this->telefono;
    }

    public function getIdViaje(){
        return $this->idViaje;
    }


    public function setTelefono ($nuevo){
        $this->telefono = $nuevo;
    }

    public function setIdViaje($nuevo){
        $this->idViaje = $nuevo;
    }


    public function getmensajeoperacion(){
		return $this->mensajeoperacion ;
	}

    public function setmensajeoperacion($mensajeoperacion){
		$this->mensajeoperacion=$mensajeoperacion;
	}
	

    /**
	 * Recupera los datos de una persona por dni
	 * @param int $dni
	 * @return true en caso de encontrar los datos, false en caso contrario 
	 */		
    public function Buscar($dni){
		$base=new BaseDatos();
		$consulta="Select * from pasajero where pdocumento=".$dni;
		$resp= false;
		if($base->Iniciar()){
		    if($base->Ejecutar($consulta)){
				if($row2=$base->Registro()){	
				    parent::Buscar($dni);
				    $this->setTelefono($row2['ptelefono']);
                    $this->setIdViaje($row2['idviaje']);
					$resp= true;
				}				
			
		 	}	else {
		 			$this->setmensajeoperacion($base->getError());
		 		
			}
		 }	else {
		 		$this->setmensajeoperacion($base->getError());
		 	
		 }		
		 return $resp;
	}	

    public function listar($condicion=""){
	    $arreglo = null;
		$base=new BaseDatos();
		$consulta="Select * from pasajero ";
		if ($condicion!=""){
		    $consulta=$consulta.' where '.$condicion;
		}
		$consulta .= "ORDER BY pdocumento";
		//echo $consultaPersonas;
		if($base->Iniciar()){
		    if($base->Ejecutar($consulta)){				
			    $arreglo= array();
				while($row2=$base->Registro()){
					$obj=new Pasajero();
					$obj->Buscar($row2['pdocumento']);
					array_push($arreglo,$obj);
				}
		 	}	else {
		 			$this->setmensajeoperacion($base->getError());
			}
		 }	else {
		 		$this->setmensajeoperacion($base->getError());
		 }	
		 return $arreglo;
	}

	
	public function listarPorIdViaje($idViaje){
		$arreglo = null;
		$base=new BaseDatos();
		$consulta="SELECT * FROM pasajero WHERE idviaje=".$idViaje." ORDER BY pdocumento";
		if($base->Iniciar()){
			if($base->Ejecutar($consulta)){                
				$arreglo= array();
				while($row=$base->Registro()){
					$obj=new Pasajero();
					$obj->Buscar($row['pdocumento']);
					array_push($arreglo,$obj);
				}
			} else {
				$this->setmensajeoperacion($base->getError());
			}
		} else {
			$this->setmensajeoperacion($base->getError());
		}   
		return $arreglo;
	}

	public function modificar(){
		$resp =false; 
		$base=new BaseDatos();
		if(parent::modificar()){
			$consultaModifica="UPDATE pasajero SET idviaje='".$this->getIdViaje()."', ptelefono='".$this->getTelefono()."' WHERE pdocumento=". $this->getNrodoc();
			if($base->Iniciar()){
				if($base->Ejecutar($consultaModifica)){
					$resp=  true;
				}else{
					$this->setmensajeoperacion($base->getError());
					
				}
			}else{
				$this->setmensajeoperacion($base->getError());
				
			}
		}
		return $resp;
	}


    public function insertar() {
		$base = new BaseDatos();
		$resp = false;
	
		if (parent::insertar()) {
			$consultaInsertar = "INSERT INTO pasajero (pdocumento, ptelefono, idviaje)
							 VALUES (".$this->getNrodoc().", '".$this->getTelefono()."', ".$this->getIdViaje().")";
								 
			if ($base->Iniciar()) {
				if ($base->Ejecutar($consultaInsertar)) {
					$resp = true;
				} else {
					$this->setmensajeoperacion($base->getError());
				}
			} else {
				$this->setmensajeoperacion($base->getError());
			}
		}
		return $resp;
	}


	public function eliminar(){
		$base=new BaseDatos();
		$resp=false;
		if($base->Iniciar()){
				$consultaBorra="DELETE FROM pasajero WHERE pdocumento=".$this->getNrodoc();
				if($base->Ejecutar($consultaBorra)){
				    if(parent::eliminar()){
				        $resp=  true;
				    }
				}else{
						$this->setmensajeoperacion($base->getError());
					
				}
		}else{
				$this->setmensajeoperacion($base->getError());
			
		}
		return $resp; 
	}


    public function __toString(){
        $cadena = parent::__toString();
        $cadena .= "Numero de telefono: " . $this->getTelefono() . "\n";
        $cadena .= "ID de viaje: " . $this->getIdViaje() . "\n";
        return $cadena;
    }
}