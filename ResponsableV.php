<?php
include_once "BaseDatos.php";

class ResponsableV extends Persona{
    private $rnumeroEmpleado;
    private $rnumeroLicencia;
    private $mensajeoperacion;


    public function __construct(){
	    parent::__construct();
        $this->rnumeroEmpleado = "";
        $this->rnumeroLicencia = "";
    }


    public function getNumero (){
        return $this->rnumeroEmpleado;
    }

    public function getLicencia (){
        return $this->rnumeroLicencia;
    }

    public function getmensajeoperacion(){
		return $this->mensajeoperacion ;
	}

    public function setNumero ($nuevo){
        $this->rnumeroEmpleado = $nuevo;
    }

    public function setLicencia ($nuevo){
        $this->rnumeroLicencia = $nuevo;
    }

    public function setmensajeoperacion($mensajeoperacion){
		$this->mensajeoperacion=$mensajeoperacion;
	}

    public function cargar($nrodoc,$nombre,$apellido,$rnumeroEmpleado=null,$rnumeroLicencia=null){
        parent::cargar($nrodoc, $nombre, $apellido);
        $this->setNumero($rnumeroEmpleado);
        $this->setLicencia($rnumeroLicencia);
    }




    //funciones bd
    public function Buscar($id){
        
            $base = new BaseDatos();
            $consulta = "Select * from responsable where rnumeroempleado= " . $id;
            $rta = false;
            if($base->Iniciar()){
                if($base->Ejecutar($consulta)){
                    if($row2 = $base->Registro()){
                        parent::Buscar($id);
                        $this->setNumero($row2['rnumeroempleado']);
                        $this->setLicencia($row2['rnumerolicencia']);

                        $rta = true;
                    }
                }else{
                    $this->setmensajeoperacion($base->getError());
                }
            }else{
                $this->setmensajeoperacion($base->getError());
            }
            return $rta;
        }
       


    public function listar($condicion = ''){
        $array = null;
        $base = new BaseDatos();
        $consulta = "Select * from responsable";
        if($condicion != ''){
            $consulta = $consulta . ' where ' . $condicion;
        }
        $consulta.=" ORDER BY rnumeroempleado";
        if($base->Iniciar()){
            if($base->Ejecutar($consulta)){
                $array = array();
            while($row2 = $base->Registro()){
                $responsable = new ResponsableV();
                $responsable->buscar($row2['rnumeroempleado']);
                array_push($array,$responsable);
            }
            }else{
                ResponsableV::setmensajeoperacion($base->getError());
            }
        }else{
            ResponsableV::setmensajeoperacion($base->getError());
        }
        return $array;
    }

///modifique insertar y modificar para que usen el padre como la clase pasajero

    public function insertar() {
		$base = new BaseDatos();
		$resp = false;

		if (parent::insertar()) {
			$consultaInsertar = "INSERT INTO responsable (rdocumento, rnombre, rapellido, rnumerolicencia)
							 VALUES ('".$this->getNrodoc()."','".$this->getNombre()."','".$this->getApellido()."','".$this->getLicencia ()."')";

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

    public function modificar(){
		$resp =false; 
		$base=new BaseDatos();
		if(parent::modificar()){
			$consultaModifica="UPDATE responsable SET rnumerolicencia='".$this->getLicencia()."' WHERE rnumeroempleado=". $this->getNumero();
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

    public function eliminar(){
        $base = new BaseDatos();
        $rta = false;
        $consulta = "DELETE FROM responsable WHERE rnumeroempleado = " . $this->getNumero();
        if($base->Iniciar()){
            if($base->Ejecutar($consulta)){
                $rta = true;
            }else{
                $this->setmensajeoperacion($base->getError());
            }
        }else{
            $this->setmensajeoperacion($base->getError());
        }
        return $rta;
    }

    public function __toString(){
        $cadena = parent::__toString();
        $cadena .= "Numero de empleado: " . $this->getNumero() . "\n";
        $cadena .= "Numero de licencia: " . $this->getLicencia() . "\n";

        return $cadena;
    }
}
