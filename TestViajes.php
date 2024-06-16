<?php

include_once "BaseDatos.php";
include_once "Empresa.php";
include_once "Persona.php";
include_once "Pasajero.php";
include_once "ResponsableV.php";
include_once "Viaje.php";

// Menu
function mostrarMenu() {
    echo "\n--------- Menú ---------\n";
    echo "1) Crear Empresa\n";
    echo "2) Crear Viaje\n";
    echo "3) Ingresar Pasajero\n";
    echo "4) Modificar Pasajero\n";
    echo "5) Eliminar Pasajero\n";
    echo "6) Ingresar Responsable\n";
    echo "7) Modificar Responsable\n";
    echo "8) Eliminar Responsable\n";
    echo "9) Ver Viajes\n";
    echo "10) Modificar Empresa\n";
    echo "11) Modificar Viaje\n";
    echo "12) Eliminar Empresa\n";
    echo "13) Eliminar Viaje\n";
    echo "14) Mostrar Detalles de un Viaje\n";
    echo "15) Salir\n";
    echo "------------------------\n";
    echo "Seleccione una opción: ";
}


// Funcion que crea la empresa
    function crearEmpresa() {
        $empresa = new Empresa();
        echo "Ingrese el nombre de la empresa: ";
        $enombre = trim(fgets(STDIN));
        echo "Ingrese la dirección de la empresa: ";
        $edireccion = trim(fgets(STDIN));
        $empresa->cargar(null, $enombre, $edireccion);
        if ($empresa->insertar()) {
            echo "Empresa creada con éxito.\n";
        } else {
            echo "Error al crear empresa: " . $empresa->getMensaje() . "\n";
        }
    }


    // Funciones CRUD para Pasajero
    function ingresarPasajero() {
        $pasajero = new Pasajero();
        echo "Ingrese el número de documento: ";
        $nrodoc = trim(fgets(STDIN));
        echo "Ingrese el nombre: ";
        $nombre = trim(fgets(STDIN));
        echo "Ingrese el apellido: ";
        $apellido = trim(fgets(STDIN));
        echo "Ingrese el teléfono: ";
        $telefono = trim(fgets(STDIN));
        echo "Ingrese el ID del viaje: ";
        $idviaje = trim(fgets(STDIN));
        $pasajero->cargar($nrodoc, $nombre, $apellido, $telefono, $idviaje);
        if ($pasajero->insertar()) {
            echo "Pasajero ingresado con éxito.\n";
        } else {
            echo "Error al ingresar pasajero: " . $pasajero->getmensajeoperacion() . "\n";
        }
    }

    function modificarPasajero() {
        $pasajero = new Pasajero();
        echo "Ingrese el número de documento del pasajero a modificar: ";
        $nrodoc = trim(fgets(STDIN));
        if ($pasajero->buscar($nrodoc)) {
            echo "Ingrese el nuevo nombre: ";
            $nombre = trim(fgets(STDIN));
            echo "Ingrese el nuevo apellido: ";
            $apellido = trim(fgets(STDIN));
            echo "Ingrese el nuevo teléfono: ";
            $telefono = trim(fgets(STDIN));
            echo "Ingrese el nuevo ID del viaje: ";
            $idviaje = trim(fgets(STDIN));
            $pasajero->cargar($nrodoc, $nombre, $apellido, $telefono, $idviaje);
            if ($pasajero->modificar()) {
                echo "Pasajero modificado con éxito.\n";
            } else {
                echo "Error al modificar pasajero: " . $pasajero->getmensajeoperacion() . "\n";
            }
        } else {
            echo "Pasajero no encontrado.\n";
        }
    }

    function eliminarPasajero() {
        $pasajero = new Pasajero();
        echo "Ingrese el número de documento del pasajero a eliminar: ";
        $nrodoc = trim(fgets(STDIN));
        if ($pasajero->buscar($nrodoc)) {
            if ($pasajero->eliminar()) {
                echo "Pasajero eliminado con éxito.\n";
            } else {
                echo "Error al eliminar pasajero: " . $pasajero->getmensajeoperacion() . "\n";
            }
        } else {
            echo "Pasajero no encontrado.\n";
        }
    }

    // Funciones CRUD para Responsable
    function ingresarResponsable() {
        $responsable = new ResponsableV();
        echo "Ingrese el número de empleado: ";
        $numEmpleado = trim(fgets(STDIN));
        echo "Ingrese el número de licencia: ";
        $numLicencia = trim(fgets(STDIN));
        echo "Ingrese el nombre: ";
        $nombre = trim(fgets(STDIN));
        echo "Ingrese el apellido: ";
        $apellido = trim(fgets(STDIN));
        $responsable->cargar($numEmpleado, $numLicencia, $nombre, $apellido);
        if ($responsable->insertar()) {
            echo "Responsable ingresado con éxito.\n";
        } else {
            echo "Error al ingresar responsable: " . $responsable->getmensajeoperacion() . "\n";
        }
    }    



    // Funciones CRUD para Viaje
    function crearViaje($destino, $cantMaxPasajeros, $idEmpresa, $numEmpleadoResponsable) {
        $viaje = new Viaje();
        $viaje->cargar(null, $destino, $cantMaxPasajeros, $idEmpresa, $numEmpleadoResponsable);
        if ($viaje->insertar()) {
            echo "Viaje creado con éxito.";
        } else {
            echo "Error al crear viaje: " . $viaje->getMensaje();
        } 
    }

    function modificarViaje($id, $destino, $cantMaxPasajeros, $idEmpresa, $numEmpleadoResponsable) {
        $viaje = new Viaje();
        if ($viaje->buscar($id)) {
            $viaje->cargar($id, $destino, $cantMaxPasajeros, $idEmpresa, $numEmpleadoResponsable);
            if ($viaje->modificar()) {
                echo "Viaje modificado con éxito.";
            } else {
                echo "Error al modificar viaje: " . $viaje->getMensaje();
            }
        } else {
            echo "Viaje no encontrado.";
        } 
    }

    function eliminarViaje($id) {
        $viaje = new Viaje();
        if ($viaje->buscar($id)) {
            if ($viaje->eliminar()) {
                echo "Viaje eliminado con éxito.";
            } else {
                echo "Error al eliminar viaje: " . $viaje->getMensaje();
            }
        } else {
            echo "Viaje no encontrado.";
        }
    }

    // Funcion que imprime los viajes
    function verViajes() {
        $viaje = new Viaje();
        $viajes = $viaje->listar();
        $resultado = "";
        foreach ($viajes as $via) {
            $resultado .= $via . "\n";
        }
        return $resultado;
    }


    // Funcion que imprime la empresa en cadena
    function verEmpresa() {
        $empresa = new Empresa();
        $empresas = $empresa->listar();
        foreach ($empresas as $emp) {
            echo $emp;
        }
    }

    // Funcion que imprime los detalles del viaje en cadena
    function mostrarDetallesViaje() {
        $viaje = new Viaje();
        $viajes = $viaje->listar();
        foreach ($viajes as $via) {
            echo $via;
        }   
    }



    do {
        mostrarMenu();
        $opcion = trim(fgets(STDIN));

        switch ($opcion) {
            case 1:
                crearEmpresa();
                break;

            case 2:
                crearViaje();
                break;

            case 3:
                ingresarPasajero();
                break;
            
            case 4:
                modificarPasajero();
                break;

            case 5:
                eliminarPasajero();
                break;

            case 6:
                ingresarResponsable();
                break;

            case 7:
                modificarResponsable();
                break;

            case 8:
                eliminarResponsable();
                break;

            case 9:
                verViajes();
                break;

            case 10:
                modificarEmpresa();
                break;

            case 11:
                modificarViaje();
                break;

            case 12:
                eliminarEmpresa();
                break;

            case 13:
                eliminarViaje();
                break;
            
            case 14:
                mostrarDetallesViaje();
                break;

            case 15:
                echo "Saliendo..\n";
                break;

            default:
                echo "Opción no válida. Por favor, intente de nuevo.\n";
        }

    }   while ($opcion != 0);