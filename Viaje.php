<?php

class Viaje{
    private $codigoViaje;
    private $destino;
    private $pasajerosMax;
    private $pasajeros = null;
    private $responsableV;
    private $costoViaje;
    private $costoPasajeros;

    public function __construct($codViaje,$destin,$pasajeMax,$pasaje,$responsable,$cost){
        $this->codigoViaje = $codViaje;
        $this->destino = $destin;
        $this->pasajerosMax = $pasajeMax;
        $this->pasajeros = $pasaje;
        $this->responsableV = $responsable;
        $this->costoViaje=$cost;
        $this->costoPasajeros = $this->definirCostoPasajeros();
    }

    public function getCodigo (){
        return $this->codigoViaje;
    }

    public function getDestino (){
        return $this->destino;
    }

    public function getPasajeMax (){
        return $this->pasajerosMax;
    }

    public function getPasajeros (){
        return $this->pasajeros;
    }

    public function getResponsable (){
        return $this->responsableV;
    }

    public function getCosto(){
        return $this->costoViaje;
    }

    public function getCostoP(){
        return $this->costoPasajeros;
    }

    public function setCodigo ($nuevo){
        $this->codigoViaje = $nuevo;
    }

    public function setDestino ($nuevo){
        $this->destino = $nuevo;
    }

    public function setPasajeMax ($nuevo){
        $this->pasajerosMax = $nuevo;  
    }

    public function setResponsabe ($nuevo){
        $this->responsableV = $nuevo;
    }

    public function setCosto($nuevo){
        $this->costoViaje=$nuevo;
    }

    public function setCostoP($nuevo){
        $this->costoPasajeros=$nuevo;
    }

    public function setPasajerosNombre ($indice,$nuevo){
        $pasajero=$this->pasajeros[$indice];
        $pasajero->setNombre($nuevo);
    }

    public function setPasajerosApellido ($indice,$nuevo){
        $pasajero=$this->pasajeros[$indice];
        $pasajero->setApellido($nuevo);
    }

    public function setPasajerosDoc ($indice,$nuevo){
        $pasajero=$this->pasajeros[$indice];
        $pasajero->setNumeroDoc($nuevo);
    }

    public function setPasajeros ($nuevo){
        $this->pasajeros = $nuevo;
    }

    public function datosPasajeros (){
        $arreglo = $this->getPasajeros();
        $texto = "";
        for($i=0; $i < count($arreglo); $i++){
            $numero = $i + 1;
            $texto .=  "Pasajero Numero " . $numero . ": \n" . $arreglo[$i] . "\n";
        }
        return $texto;
    }


    public function pasajeroExiste ($dni){
    $UnarregloPasajeros = $this->getPasajeros();
    $m = count($UnarregloPasajeros);
    $i = 0;
    $existe = false;
    while ($i < $m && !$existe) {
        if ($UnarregloPasajeros[$i]->getNumeroDoc() == $dni){
            $existe = true;
        }
        $i += 1;
    }
    return $existe;
    }
    
    public function definirCostoUnPasajero($pasajero){
        $porcentaje = $pasajero->darPorcentajeIncremento();
        $costo = $this->getCosto();
        $porcentajeF = ($porcentaje * $costo) / 100;
        $costo = $costo + $porcentajeF;
        return $costo;
    }

    public function definirCostoPasajeros(){
        $costoFinal = 0;
        if (!$this->getPasajeros()==null){
            $copiaPasajeros = $this->getPasajeros();
            foreach($copiaPasajeros as $Pasajero){
                $costo = $this->definirCostoUnPasajero($Pasajero);
                $costoFinal = $costoFinal + $costo;
            }
            return $costoFinal;
        }
    }

    public function venderPasaje($objPasajero){
        $costoFP = 0;
        if ($this->hayPasajesDisponible()){
            $arrayPasajerosCopia = $this->getPasajeros();
            array_push($arrayPasajerosCopia,$objPasajero);
            $this->setPasajeros($arrayPasajerosCopia);
            $nuevoCosto = $this->definirCostoPasajeros();
            $this->setCostoP($nuevoCosto);
            $costoFP = $this->definirCostoUnPasajero($objPasajero);
        }
        return $costoFP;
    }

    public function hayPasajesDisponible(){
        $disponible = false;
        if (count($this->getPasajeros()) < $this->getPasajeMax()){
            $disponible = true;
        }
        return $disponible;
    }

    public function __toString(){
        $cadena ="Codigo: " . $this->getCodigo() . "\n";
        $cadena .= "Destino: " . $this->getDestino() . "\n";
        $cadena .= "Maximo de pasajeros: " . $this->getPasajeMax() . "\n";
        $cadena .= "Datos del responsable: \n__________________________________________ \n" . $this->getResponsable() . "\n";
        $cadena .= "Datos de los pasajeros: \n__________________________________________ \n" . $this->datosPasajeros() . "\n";
        return $cadena;
    }
}