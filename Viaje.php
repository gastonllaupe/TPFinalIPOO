<?php

class Viaje
{
    private $idviaje;
    private $vdestino;
    private $vcantmaxpasajeros;
    private $idempresa; //OBJETO EMPRESA
    private $rdocumento; // OBJETO RESPONSABLE
    private $vimporte;
    private $mensaje;

    //constructor
    public function __construct()
    {
        $this->idviaje = '';
        $this->vdestino = '';
        $this->vcantmaxpasajeros = '';
        $this->vimporte = '';
        $this->mensaje = '';
        $this->rdocumento = '';
    }

    public function cargar($vdestino, $vcantmaxpasajeros, $objempresa, $rdocumento, $vimporte=null)
    {
        //$this->setIdviaje($idviaje);
        $this->setVdestino($vdestino);
        $this->setVcantmaxpasajeros($vcantmaxpasajeros);
        $this->setObjempresa($objempresa);
        $this->setRdocumento($rdocumento);
        $this->setVimporte($vimporte);
    }

    //metodos de acceso
    public function getIdviaje()
    {
        return $this->idviaje;
    }

    public function setIdviaje($idviaje)
    {
        $this->idviaje = $idviaje;
    }

    public function getVdestino()
    {
        return $this->vdestino;
    }

    public function setVdestino($vdestino)
    {
        $this->vdestino = $vdestino;
    }

    public function getVcantmaxpasajeros()
    {
        return $this->vcantmaxpasajeros;
    }

    public function setVcantmaxpasajeros($vcantmaxpasajeros)
    {
        $this->vcantmaxpasajeros = $vcantmaxpasajeros;
    }

    public function getObjempresa()
    {
        return $this->idempresa;
    }

    public function setObjempresa($idempresa)
    {
        $this->idempresa = $idempresa;
    }

    public function getRdocumento()
    {
        return $this->rdocumento;
    }

    public function setRdocumento($rdocumento)
    {
        $this->rdocumento = $rdocumento;
    }

    public function getVimporte()
    {
        return $this->vimporte;
    }

    public function setVimporte($vimporte)
    {
        $this->vimporte = $vimporte;
    }

    public function getMensaje()
    {
        return $this->mensaje;
    }

    public function setMensaje($nuevo)
    {
        $this->mensaje = $nuevo;
    }

    //toString
    public function __toString()
    {
        $empleado = $this->getRdocumento();
        return "----------------------------------
            ID: " . $this->getIdviaje() .
            "\nDestino: " . $this->getVdestino() .
            "\nCantidad maxima de pasajeros: " . $this->getVcantMaxPasajeros() .
            "\nEmpresa: \n" . $this->getObjempresa() .
            "\nDatos del empleado: \n" . $empleado .
            "\nImporte: $" . $this->getVimporte() ."\n";
    }

    //funciones bd
    public function Buscar($id)
    {
        $base = new BaseDatos();
        $rta = false;
        $consulta = "SELECT * FROM Viaje WHERE idviaje=" . $id;
        if ($base->Iniciar()) {
            if ($base->Ejecutar($consulta)) {
                if ($row2 = $base->Registro()) { // utilizar el metodo cargar (opcional)
                    $this->setIdviaje($row2['idviaje']);
                    $this->setVdestino($row2['vdestino']);
                    $this->setVcantMaxPasajeros($row2['vcantmaxpasajeros']);
                    $empresa = new Empresa();
                    $empresa->buscar($row2['idempresa']);
                    $this->setObjempresa($empresa);
                    $responsable = new ResponsableV();
                    $responsable->buscar($row2['rdocumento']);
                    $this->setRdocumento($responsable);
                    $this->setVimporte($row2['vimporte']);
                    $rta = true;
                }
            } else {
                $this->setMensaje($base->getError());
            }
        } else {
            $this->setMensaje($base->getError());
        }
        return $rta;
    }

    public static function listar($condicion = '')
    {
        $array = null;
        $base = new BaseDatos();
        $consulta = "SELECT * FROM viaje";
        if ($condicion != '') {
            $consulta = $consulta . ' WHERE ' . $condicion;
        }
        if ($base->Iniciar()) {
            if ($base->Ejecutar($consulta)) {
                $array = array();
                while ($row2 = $base->Registro()) {
                    $objViaje = new Viaje();
                    $objViaje->buscar($row2['idviaje']);
                    $array[] = $objViaje;
                }
            } else {
                Viaje::setMensaje($base->getError());
            }
        } else {
            Viaje::setMensaje($base->getError());
        }
        return $array;
    }

    public function insertar()
    {
        $base = new BaseDatos();
        $rta = false;
        $empresa = $this->getObjempresa();
        $idEmpresa = $empresa->getIdEmpresa();
        $responsable = $this->getRdocumento();
        $numResponsable = $responsable->getNrodoc();
        $consulta = "INSERT INTO viaje(vdestino, vcantmaxpasajeros, idempresa, rdocumento, vimporte) 
        VALUES ('{$this->getVdestino()}', {$this->getVcantmaxpasajeros()}, 
        {$idEmpresa}, {$numResponsable}, {$this->getVimporte()})";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($consulta)) {
                $rta = true;
            } else {
                $this->setMensaje($base->getError());
            }
        } else {
            $this->setMensaje($base->getError());
        }
        return $rta;
    }

    public function modificar()
    {
        $rta = false;
        $base = new BaseDatos();
        $empresa = $this->getObjempresa();
        $idEmpresa = $empresa->getIdempresa();
        $responsable = $this->getRdocumento();
        $numResponsable = $responsable->getNrodoc();
        $consulta = "UPDATE viaje SET vdestino = '{$this->getVdestino()}', vcantmaxpasajeros = {$this->getVcantmaxpasajeros()}, idempresa = {$idEmpresa}, rdocumento = {$numResponsable}, vimporte = {$this->getVimporte()} WHERE idviaje = {$this->getIdviaje()}";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($consulta)) {
                $rta = true;
            } else {
                $this->setMensaje($base->getError());
            }
        } else {
            $this->setMensaje($base->getError());
        }
        return $rta;
    }

    public function eliminar()
    {
        $base = new BaseDatos();
        $rta = false;
        $consulta = "DELETE FROM viaje WHERE idviaje = " . $this->getIdviaje();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($consulta)) {
                $rta = true;
            } else {
                $this->setMensaje($base->getError());
            }
        } else {
            $this->setMensaje($base->getError());
        }
        return $rta;
    }
}