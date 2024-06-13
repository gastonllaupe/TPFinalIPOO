<?php
include_once "BaseDatos.php";


class Pasajero extends Persona{
    private $telefono;
    private $numAsiento;
    private $numTicket;
    private $mensajeoperacion;


    public function __construct(){
        parent::__construct();
        $this->telefono = "";
        $this->numAsiento = "";
        $this->numTicket = "";
    }

    public function cargar($NroD,$Nom,$Ape,$telefono=null,$asiento=null,$ticket=null){	
	    parent::cargar($NroD, $Nom, $Ape);
	    $this->setTelefono($telefono);
        $this->setAsiento($asiento);
        $this->setTicket($ticket);
    }


    public function getTelefono(){
        return $this->telefono;
    }

    public function getAsiento(){
        return $this->numAsiento;
    }

    public function getTicket(){
        return $this->numTicket;
    }

    public function setTelefono ($nuevo){
        $this->telefono = $nuevo;
    }

    public function setAsiento($nuevo){
        $this->numAsiento = $nuevo;
    }

    public function setTicket($nuevo){
        $this->numTicket = $nuevo;
    }

    public function getmensajeoperacion(){
		return $this->mensajeoperacion ;
	}

    public function setmensajeoperacion($mensajeoperacion){
		$this->mensajeoperacion=$mensajeoperacion;
	}

    public function darPorcentajeIncremento(){
        $porcentaje = 10;
        return $porcentaje;
    }

    		/**
	 * Recupera los datos de una persona por dni
	 * @param int $dni
	 * @return true en caso de encontrar los datos, false en caso contrario 
	 */		
    public function Buscar($dni){
		$base=new BaseDatos();
		$consulta="Select * from estudiante where nrodoc=".$dni;
		$resp= false;
		if($base->Iniciar()){
		    if($base->Ejecutar($consulta)){
				if($row2=$base->Registro()){	
				    parent::Buscar($dni);
				    $this->setTelefono($row2['carrera']);
                    $this->setAsiento($row2['asiento']);
                    $this->setTicket($row2['ticket']);
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
		//echo $consultaPersonas;
		if($base->Iniciar()){
		    if($base->Ejecutar($consulta)){				
			    $arreglo= array();
				while($row2=$base->Registro()){
					$obj=new Pasajero();
					$obj->Buscar($row2['nrodoc']);
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

    public function insertar(){
		$base=new BaseDatos();
		$resp= false;
		
		if(parent::insertar()){
		    $consultaInsertar="INSERT INTO estudiante(nrodoc, telefono, numAsiento, numTicket)
				VALUES (".$this->getNrodoc().",'".$this->getTelefono()."','".$this->getAsiento()."','".$this->getTicket()."')";
		    if($base->Iniciar()){
		        if($base->Ejecutar($consultaInsertar)){
		            $resp=  true;
		        }	else {
		            $this->setmensajeoperacion($base->getError());
		        }
		    } else {
		        $this->setmensajeoperacion($base->getError());
		    }
		 }
		return $resp;
	}


    public function __toString(){
        $cadena = parent::__toString();
        $cadena .= "Numero de telefono: " . $this->getTelefono() . "\n";
        $cadena .= "Numero de asiento: " . $this->getAsiento() . "\n";
        $cadena .= "Numero de ticket: " . $this->getTicket() . "\n";
        return $cadena;
    }
}