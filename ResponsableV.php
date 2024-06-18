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

    public function __toString(){
        $cadena = parent::__toString();
        $cadena .= "Numero de empleado: " . $this->getNumero() . "\n";
        $cadena .= "Numero de licencia: " . $this->getLicencia() . "\n";

        return $cadena;
    }


    //funciones bd
    public function Buscar($id){
        
            $base = new BaseDatos();
            $consulta = "SELECT * FROM responsable WHERE rnumeroempleado= " . $id;
            $rta = false;
            if($base->Iniciar()){
                if($base->Ejecutar($consulta)){
                    if($row2 = $base->Registro()){
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
        $consulta = "SELECT * FROM responsable";
        if($condicion != ''){
            $consulta = $consulta . ' WHERE ' . $condicion;
        }
        if($base->Iniciar()){
            if($base->Ejecutar($consulta)){
                $array = array();
                while($row2 = $base->Registro()){
                    $responsable = new ResponsableV();
                    $responsable->buscar($row2['rnumeroempleado']);
                    $array[] = $responsable;
                }
            }else{
                ResponsableV::setmensajeoperacion($base->getError());
            }
        }else{
            ResponsableV::setmensajeoperacion($base->getError());
        }
        return $array;
    }

    public function insertar(){
        $base = new BaseDatos();
        $rta = false;
        if(parent::insertar()) {

            $consulta = "INSERT INTO responsable(rnumerolicencia) VALUES ('{$this->getLicencia()}')";
            if($base->Iniciar()){
                if($base->Ejecutar($consulta)){
                    $rta = true;
                }else{
                    $this->setmensajeoperacion($base->getError());    
                }
            } else {
                $this->setmensajeoperacion($base->getError());
            }
        } else {
            $this->setmensajeoperacion(parent::getmensajeoperacion());
        }
        return $rta;
    }

    public function modificar(){
        $rta = false;
        $base = new BaseDatos();
        $consulta = "UPDATE responsable SET rnumerolicencia = {$this->getLicencia()}, rnombre = '{$this->getNombre()}', rapellido = '{$this->getApellido()}' WHERE rnumeroempleado = {$this->getNumero()}";
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


}
