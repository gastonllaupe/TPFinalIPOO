<?php

include_once "BaseDatos.php";
include_once "Empresa.php";
include_once "Persona.php";
include_once "Pasajero.php";
include_once "ResponsableV.php";
include_once "Viaje.php";

// Menu Principal
function menuPrincipal() {
    echo "\n--------- Menú Principal ---------\n";
    echo "1) Gestión de Empresa\n";
    echo "2) Gestión de Viajes\n";
    echo "3) Gestión de Pasajeros\n";
    echo "4) Gestión de Responsable\n";
    echo "5) Salir\n";
    echo "------------------------\n";
    echo "Seleccione una opción: ";
}

// Menú Empresa
function menuEmpresa() {
    echo "\n--------- Menú de Empresa ---------\n";
    echo "1) Crear Empresa\n";
    echo "2) Modificar Empresa\n";
    echo "3) Eliminar Empresa\n";
    echo "4) Listar Empresa\n";
    echo "5) Volver al Menú Principal\n";
    echo "------------------------\n";
    echo "Seleccione una opción: ";
}

// Menú Viaje
function menuViaje() {
    echo "\n--------- Menú de Viaje ---------\n";
    echo "1) Crear Viaje\n";
    echo "2) Modificar Viaje\n";
    echo "3) Eliminar Viaje\n";
    echo "4) Listar Viaje\n";
    echo "5) Ver Detalles de un Viaje\n";
    echo "6) Volver al Menú Principal\n";
    echo "------------------------\n";
    echo "Seleccione una opción: ";
}

// Menú Pasajero
function menuPasajero() {
    echo "\n--------- Menú de Pasajero ---------\n";
    echo "1) Ingresar Pasajero\n";
    echo "2) Modificar Pasajero\n";
    echo "3) Eliminar Pasajero\n";
    echo "4) Listar Pasajeros\n";
    echo "5) Volver al Menú Principal\n";
    echo "------------------------\n";
    echo "Seleccione una opción: ";
}

// Menú Responsable
function menuResponsable() {
    echo "\n--------- Menú de Responsable ---------\n";
    echo "1) Ingresar Responsable\n";
    echo "2) Modificar Responsable\n";
    echo "3) Eliminar Responsable\n";
    echo "5) Volver al Menú Principal\n";
    echo "------------------------\n";
    echo "Seleccione una opción: ";
}

// Funcion para listar un arreglo
function listarArray($array) {
    $texto = "\n-------------------\n";
    foreach ($array as $item) {
        $texto = $texto . $item->__toString() . "\n";
    }
    echo $texto;
}

// Funciones CRUD para la empresa
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
    
    function modificarEmpresa() {
        $empresa = new Empresa();
        echo "Ingrese id de la Empresa: ";
        $idEm = trim(fgets(STDIN));
    
        if ($empresa->buscar($idEm)) {
            echo "Ingrese el nuevo nombre: ";
            $enombre = trim(fgets(STDIN));
            echo "Ingrese la nueva direccion: ";
            $edireccion = trim(fgets(STDIN));
            $empresa->cargar($idEm, $enombre, $edireccion);
    
            if ($empresa->modificar()) {
                echo "Empresa modificada con éxito\n";
            } else {
                echo "Error al crear empresa: " .$empresa->getMensaje() ."\n";
            }
        } else {
            echo "Empresa no encontrada\n";
        }
    }
    
    function eliminarEmpresa() {
        $empresa = new Empresa();
        echo "Ingrese el id de la empresa a eliminar: ";
        $idEm = trim(fgets(STDIN));
        
        if($empresa->buscar($idEm)) {
            if ($empresa->eliminar()) {
                echo "Empresa eliminada con éxito.\n";
            } else {
                echo "Error al eliminar empresa: " .$empresa->getMensaje(). "\n"; 
            }
        } else {
            echo "Empresa no encontrada.\n";
        }
    }

    function listarEmpresa() {
        $empresa = new Empresa();
        $empresas = $empresa->listar();
        foreach ($empresas as $emp) {
            echo $emp;
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

    // Verifica que existan pasajeros en el viaje
    function ExistenPasajeros() {
        $pasajero = new Pasajero();
        $pasajeros = $pasajero->listar();
        $hayPasajerosCargados = sizeof($pasajeros) > 0;
        return $hayPasajerosCargados;
    }

    function listarPasajero() {
        if (existenPasajeros()) {
            $pasajeros = $pasajero->listar();
            listarArray($pasajeros);
        } else {
            echo "No hay pasajeros cargados.\n";
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
    
    function modificarResponsable() {
        echo "Ingrese el número de empleado del responsable a modificar: ";
        $numEmpleado = trim(fgets(STDIN));
        $responsable = new ResponsableV();

        if ($responsable->buscar($numEmpleado)) {
            echo "Ingrese el nuevo número de licencia: ";
            $numLicencia = trim(fgets(STDIN));
            echo "Ingrese el nuevo nombre: ";
            $nombre = trim(fgets(STDIN));
            echo "Ingrese el nuevo apellido: ";
            $apellido = trim(fgets(STDIN));
            $responsable->cargar($numEmpleado, $numLicencia, $nombre, $apellido);
            
            if ($responsable->modificar()) {
                echo "Responsable modificado con éxito.\n";
            } else {
                echo "Error al modificar responsable: " . $responsable->getmensajeoperacion() . "\n";
            }
        } else {
            echo "Responsable no encontrado.\n";
        }
    }

    function eliminarResponsable() {
        $responsable = new ResponsableV();
        echo "Ingrese el número de documento del responsable a eliminar: ";
        $nrodoc = trim(fgets(STDIN));
        if ($responsable->buscar($nrodoc)) {
            if ($responsable->eliminar()) {
                echo "Viaje eliminado con éxito.";
            } else {
                echo "Error al eliminar viaje: " . $responsable->getmensajeoperacion();
            }
        } else {
            echo "Viaje no encontrado.";
        }
    }



    // Funciones CRUD para Viaje
    function crearViaje() {
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



    // Funcion que imprime los detalles del viaje en cadena
    function mostrarDetallesViaje() {
        $viaje = new Viaje();
        $viajes = $viaje->listar();
        foreach ($viajes as $via) {
            echo $via;
        }   
    }


// Funciones correspondientes a las opciones del Menú Principal

function gestionEmpresas() {

    do {
        menuEmpresa();
        $opcionEmpresa = trim(fgets(STDIN));

        switch($opcionEmpresa) {

            case 1:
                crearEmpresa();
                break;

            case 2:
                modificarEmpresa();
                break;

            case 3:
                eliminarEmpresa();
                break;
            
            case 4:
                listarEmpresa();
                break;
            case 5:
                echo "Volviendo al Menú Principal\n";
                break;

            default:
                echo "Opción inválida. Por favor, itnente de nuevo\n";
        }
    } while ($opcionEmpresa != 5);
} 

function gestionViajes() {
    do {
        menuViaje();
        $opcionViaje = trim(fgets(STDIN));

        switch($opcionViaje) {

            case 1:
                crearViaje();
                break;

            case 2:
                modificarViaje();
                break;

            case 3:
                eliminarViaje();
                break;

            case 4:
                mostrarDetallesViaje();
                break;

            case 5:
                echo "Volviendo al Menú Principal\n";
                break;

            default:
            echo "Opción inválida. Por favor, itnente de nuevo\n";
        }
    } while ($opcionViaje != 5);
}


function gestionPasajeros() {
    
    do {
        menuPasajero();
        $opcionPasajero = trim(fgets(STDIN));

        switch($opcionPasajero) {

            case 1:
                ingresarPasajero();
                break;
            
            case 2:
                modificarPasajero();
                break;

            case 3:
                eliminarPasajero();
                break;

            case 4: 
                listarPasajero();
                break;

            case 5:
                echo "Volviendo al Menú Principal\n";
                break;

            default:
            echo "Opción no válida. Por favor, intente de nuevo.\n";
        }
    } while ($opcionPasajero != 5);
}


function gestionResponsable() {

    do {
        menuResponsable();
        $opcionResponsable = trim(fgets(STDIN));

        switch ($opcionResponsable) {

            case 1:
                ingresarResponsable();
                break;
            
            case 2:
                modificarResponsable();
                break;
        
            case 3:
                eliminarResponsable();
                break;

            case 4:
                echo "Volviendo al Menú Principal\n";
                break;

            default:
            echo "Opción no válida. Por favor, intente de nuevo.\n"; 
        }
    } while ($opcionResponsable != 4);
}



// Función principal para mostrar y gestionar el menú principal

function mostrarMenuPrincipal() {

    do {
        menuPrincipal();
        $opcionPrincipal = trim(fgets(STDIN));

        switch ($opcionPrincipal) {

            case 1:
                gestionEmpresas();
                break;

            case 2: 
                gestionViajes();
                break;

            case 3: 
                gestionPasajeros();
                break;
                
            case 4:
                gestionResponsable();
                break;

            case 5:
                echo "Saliendo del Programa.\n";
                break;

            default:
            echo "Opción no válida. Por favor, intente de nuevo.\n";
        }
    } while ($opcionPrincipal != 5);
}

// Ejecutar la función principal para iniciar el programa
mostrarMenuPrincipal();