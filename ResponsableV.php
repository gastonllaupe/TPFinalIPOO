<?php
include_once "BaseDatos.php";

class ResponsableV extends Persona{
    private $nrodoc;
	private $nombre;
	private $apellido;
    private $numeroEmpleado;
    private $numeroLicencia;
    private $mensajeoperacion;


    public function __construct(){
	    parent::__construct();
        $this->numeroEmpleado = "";
        $this->numeroLicencia = "";

    }

    public function getNumero (){
        return $this->numeroEmpleado;
    }

    public function getLicencia (){
        return $this->numeroLicencia;
    }

    public function getmensajeoperacion(){
		return $this->mensajeoperacion ;
	}

    public function setNumero ($nuevo){
        $this->numeroEmpleado = $nuevo;
    }

    public function setLicencia ($nuevo){
        $this->numeroLicencia = $nuevo;
    }

    public function setmensajeoperacion($mensajeoperacion){
		$this->mensajeoperacion=$mensajeoperacion;
	}

    public function cargar($nrodoc,$nombre,$apellido,$numeroEmpleado=null,$numeroLicencia=null){
        parent::cargar($NroD, $Nom, $Ape);
        $this->setNumero($numeroEmpleado);
        $this->setLicencia($numeroLicencia);
    }

    public function __toString(){
        $cadena = parent::__toString();
        $cadena .= "Numero de empleado: " . $this->getNumero() . "\n";
        $cadena .= "Numero de licencia: " . $this->getLicencia() . "\n";

        return $cadena;
    }
}