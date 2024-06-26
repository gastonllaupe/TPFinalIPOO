<?php

include_once "BaseDatos.php";
include_once "Empresa.php";
include_once "Persona.php";
include_once "Pasajero.php";
include_once "ResponsableV.php";
include_once "Viaje.php";

// Menu Principal
function menuPrincipal()
{
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
function menuEmpresa()
{
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
function menuViaje()
{
    echo "\n--------- Menú de Viaje ---------\n";
    echo "1) Crear Viaje\n";
    echo "2) Modificar Viaje\n";
    echo "3) Eliminar Viaje\n";
    echo "4) Listar Viaje\n";
    echo "5) Listar pasajeros en viaje\n";
    echo "6) Volver al Menú Principal\n";
    echo "------------------------\n";
    echo "Seleccione una opción: ";
}

// Menú Pasajero
function menuPasajero()
{
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
function menuResponsable()
{
    echo "\n--------- Menú de Responsable ---------\n";
    echo "1) Ingresar Responsable\n";
    echo "2) Modificar Responsable\n";
    echo "3) Eliminar Responsable\n";
    echo "4) Listar Responsable\n";
    echo "5) Volver al Menú Principal\n";
    echo "------------------------\n";
    echo "Seleccione una opción: ";
}

// Funcion para listar un arreglo
function listarArray($array)
{
    $texto = "\n-------------------\n";
    foreach ($array as $item) {
        $texto = $texto . $item->__toString() . "\n";
    }
    echo $texto;
}

// Funciones CRUD para la empresa
function crearEmpresa()
{
    $empresa = new Empresa();
    echo "Ingrese el nombre de la empresa: ";
    $enombre = trim(fgets(STDIN));
    echo "Ingrese la dirección de la empresa: ";
    $edireccion = trim(fgets(STDIN));
    $empresa->cargar($enombre, $edireccion);
    if ($empresa->insertar()) {
        echo "Empresa creada con éxito.\n";
    } else {
        echo "Error al crear empresa: " . $empresa->getMensaje() . "\n";
    }
}

function modificarEmpresa($empresa)
{
    if ($empresa->modificar()) {
        echo "Se realizo la modificacion con exito.\n";
    } else {
        echo "No se pudo realizar la modificacion.\n";
        $empresa->getMensaje();
    }
}

function eliminarEmpresa()
{
    $empresa = new Empresa();
    echo "Ingrese el id de la empresa a eliminar: ";
    $idEm = trim(fgets(STDIN));

    if ($empresa->buscar($idEm)) {
        if (existenViajesEmpresa($idEm)){
            if ($empresa->eliminar()) {
                echo "Empresa eliminada con éxito.\n";
            } else {
                echo "Error al eliminar empresa: " . $empresa->getMensaje() . "\n";
            }
        }
    } else {
        echo "Empresa no encontrada.\n";
    }
}

function listarEmpresa()
{
    $empresa = new Empresa();
    $empresas = $empresa->listar();
    foreach ($empresas as $emp) {
        echo $emp;
    }
}

// Funciones para modificar empresa

function existenEmpresas()
{
    $empresa = new Empresa();
    $empresas = $empresa->listar();
    $hayEmpresasCargadas = sizeof($empresas) > 0;
    return $hayEmpresasCargadas;
}

// Funcion que muestra las opciones de modificar la empresa
function opcionesModificarEmpresa($empresa)
{
    do {
        echo "\n>>>>>>>>>>>>>>>>>>>>MODIFICACIONES EMPRESA<<<<<<<<<<<<<<<<<<<<
            1) Nombre.
            2) Direccion. 
            0) Volver atras. \n";
        $opcion = trim(fgets(STDIN));
        switch ($opcion) {
            case 1:
                echo "Ingrese el nuevo nombre: ";
                $nuevo = trim(fgets(STDIN));
                $empresa->setEnombre($nuevo);
                modificarEmpresa($empresa);
                break;
            case 2:
                echo "Ingrese la nueva direccion: ";
                $nuevo = trim(fgets(STDIN));
                $empresa->setEdireccion($nuevo);
                modificarEmpresa($empresa);
                break;
            default:
                "Opcion incorrecta.\n";
        }
    } while ($opcion != 0);
}


// Funciones CRUD para Pasajero
function ingresarPasajero()
{
    $pasajero = new Pasajero();
    do {
        echo "Ingrese el número de documento: ";
        $nrodoc = trim(fgets(STDIN));

        if (!is_numeric($nrodoc) || $nrodoc <= 0) {
            echo "El número de documento debe ser un número positivo.\n";
            $existe = true;
        } else {
            $existe = $pasajero->buscar($nrodoc);
            if ($existe) {
                echo "El Documento ingresado ya existe.\n";
            }
        }
    } while ($existe || !is_numeric($nrodoc) || $nrodoc <= 0);

    echo "Ingrese el nombre: ";
    $nombre = trim(fgets(STDIN));

    while (empty($nombre)) {
        echo "El nombre no puede estar vacío. Ingrese el nombre : ";
        $nombre = trim(fgets(STDIN));
    }
    echo "Ingrese el apellido: ";
    $apellido = trim(fgets(STDIN));

    while (empty($apellido)) {
        echo "El apellido no puede estar vacío. Ingrese el apellido : ";
        $apellido = trim(fgets(STDIN));
    }
    echo "Ingrese el teléfono: ";
    $telefono = trim(fgets(STDIN));

    while (!is_numeric($telefono) || $telefono <= 0) {
        echo "El número debe ser un número positivo. Ingrese el teléfono. ";
        $telefono = trim(fgets(STDIN));
    }

    do {
        echo "ID del viaje: ";
        $idViaje = trim(fgets(STDIN));
        if (!is_numeric($idViaje) || $idViaje <= 0) {
            echo "El ID del viaje debe ser un número positivo.\n";
            $existe = false;
        } else {
            $viaje = new Viaje();
            $existe = $viaje->buscar($idViaje);
            if (!$existe) {
                echo "El ID ingresado no existe.\n";
            }
        }
    } while (!$existe || !is_numeric($idViaje) || $idViaje <= 0);

    $idViaje = $viaje->getIdviaje();
    $pasajero->cargar($nrodoc, $nombre, $apellido, $telefono, $idViaje);

    $pasajeros = listadoPasajerosEnViaje($idViaje);
    if (count($pasajeros) < $viaje->getVcantmaxpasajeros()) {
        if ($pasajero->insertar()) {
            echo "Pasajero ingresado con éxito.\n";
        } else {
            echo "Error al ingresar pasajero: " . $pasajero->getmensajeoperacion() . "\n";
        }
    } else {
        echo "No se pueden ingresar mas pasajeros al viaje. Supero el limite.\n";
    }
}

function modificarPasajero()
{
    $pasajero = new Pasajero();
    echo "Ingrese el número de documento del pasajero a modificar: ";
    $nrodoc = trim(fgets(STDIN));

    if ($pasajero->buscar($nrodoc)) {
        echo "Ingrese el nuevo nombre: ";
        $nombre = trim(fgets(STDIN));
        while (empty($nombre)) {
            echo "El nombre no puede estar vacío. Ingrese el nuevo nombre: ";
            $nombre = trim(fgets(STDIN));
        }

        echo "Ingrese el nuevo apellido: ";
        $apellido = trim(fgets(STDIN));
        while (empty($apellido)) {
            echo "El apellido no puede estar vacío. Ingrese el nuevo apellido: ";
            $apellido = trim(fgets(STDIN));
        }

        echo "Ingrese el nuevo teléfono: ";
        $telefono = trim(fgets(STDIN));
        while (!is_numeric($telefono) || $telefono <= 0) {
            echo "El teléfono debe ser un número positivo. Ingrese el nuevo teléfono: ";
            $telefono = trim(fgets(STDIN));
        }

        do {

            echo "Ingrese el nuevo ID del viaje: ";
            $idViaje = trim(fgets(STDIN));
            if (!is_numeric($idViaje) || $idViaje <= 0) {
                echo "El ID del viaje debe ser un número positivo.\n";
                $existe = false;
            } else {
                $viaje = new Viaje();
                $existe = $viaje->buscar($idViaje);
                if (!$existe) {
                    echo "El ID ingresado no existe.\n";
                }
            }
        } while (!$existe || !is_numeric($idViaje) || $idViaje <= 0);

        $pasajero->cargar($nrodoc, $nombre, $apellido, $telefono, $idViaje);
        if ($pasajero->modificar()) {
            echo "Pasajero modificado con éxito.\n";
        } else {
            echo "Error al modificar pasajero: " . $pasajero->getmensajeoperacion() . "\n";
        }
    } else {
        echo "Pasajero no encontrado.\n";
    }
}


function eliminarPasajero()
{
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
function ExistenPasajeros()
{
    $pasajero = new Pasajero();
    $pasajeros = $pasajero->listar();
    $hayPasajerosCargados = sizeof($pasajeros) > 0;
    return $hayPasajerosCargados;
}

function listarPasajero()
{
    if (ExistenPasajeros()) {
        $pasajero = new Pasajero();
        $pasajeros = $pasajero->listar();
        listarArray($pasajeros);
    } else {
        echo "No hay pasajeros cargados.\n";
    }
    
}

// Funcion que recibe un idViaje y retorna la lista de los pasajeros del mismo
function listadoPasajerosEnViaje($idViaje)
{
    $pasajero = new Pasajero();
    $pasajeros = $pasajero->listarPorIdViaje($idViaje);
    return $pasajeros;

}

// Funciones CRUD para Responsable
function ingresarResponsable()
{
    $responsable = new ResponsableV();
    do {
        echo "Ingrese el nuevo número de documento: ";
        $nroDoc = trim(fgets(STDIN));

        if (!is_numeric($nroDoc) || $nroDoc <= 0) {
            echo "El número de documento debe ser un número positivo.\n";
            $existe = true;
        } else {
            $existe = $responsable->buscar($nroDoc);
            if ($existe) {
                echo "El Documento ingresado ya existe.\n";
            }
        }
    } while ($existe || !is_numeric($nroDoc) || $nroDoc <= 0);

    echo "Ingrese el nombre: ";
    $nombre = trim(fgets(STDIN));
    echo "Ingrese el apellido: ";
    $apellido = trim(fgets(STDIN));

    do {
        echo "Ingrese el número de licencia: ";
        $numLicencia = trim(fgets(STDIN));
    } while (!is_numeric($numLicencia) || $numLicencia < 0);

    $responsable->cargar($nroDoc, $nombre, $apellido, null, $numLicencia);
    if ($responsable->insertar()) {
        echo "Responsable ingresado con éxito.\n";
    } else {
        echo "Error al ingresar responsable: " . $responsable->getmensajeoperacion() . "\n";
    }
    return $responsable;
}

function listarResponsable()
{
    if (existeResponsable()) {
        $responsable = new ResponsableV();
        $responsables = $responsable->listar();
        listarArray($responsables);
    } else {
        echo "No hay responsables cargados\n";
    }
}

function existeResponsable()
{
    $responsable = new ResponsableV();
    $responsables = $responsable->listar();
    $hayResponsable = sizeof($responsables) > 0;
    return $hayResponsable;
}

function modificarResponsable()
{
    echo "Ingrese el número de documento del responsable a modificar: ";
    $dnie = trim(fgets(STDIN));
    $responsable = new ResponsableV();

    if ($responsable->buscar($dnie)) {
        echo "Ingrese el nuevo número de licencia: ";
        $numLicencia = trim(fgets(STDIN));
        echo "Ingrese el nuevo nombre: ";
        $nombre = trim(fgets(STDIN));
        echo "Ingrese el nuevo apellido: ";
        $apellido = trim(fgets(STDIN));
        $responsable->cargar($dnie,$nombre, $apellido, $numLicencia);

        if ($responsable->modificar()) {
            echo "Responsable modificado con éxito.\n";
        } else {
            echo "Error al modificar responsable: " . $responsable->getmensajeoperacion() . "\n";
        }
    } else {
        echo "Responsable no encontrado.\n";
    }
}

function eliminarResponsable()
{
    $responsable = new ResponsableV();
    echo "Ingrese el número de empleado del responsable a eliminar: ";
    $idEmpleado = trim(fgets(STDIN));
    if ($responsable->buscar($idEmpleado)) {
        if ($responsable->eliminar()) {
            echo "Responsable eliminado con éxito.";
        } else {
            echo "Error al eliminar Responsable: " . $responsable->getmensajeoperacion();
        }
    } else {
        echo "Responsable no encontrado.";
    }
}



// Funciones CRUD para Viaje
function crearViaje()
{
    $viaje = new Viaje();
    echo "Ingrese los datos del viaje:\n";

    // Solicitar destino
    echo "Destino: ";
    $destino = trim(fgets(STDIN));

    // Solicitar cantidad máxima de pasajeros
    do {
    echo "Cantidad máxima de pasajeros: ";
    $cantMax = trim(fgets(STDIN));
    }while ($cantMax <0);
    

    // Validar existencia de la empresa por ID
    do {
        listarEmpresa();
        echo "ID de la empresa: ";
        $idViaje = trim(fgets(STDIN));
        $empresa = new Empresa();
        $existe = $empresa->buscar($idViaje);
        if (!$existe) {
            echo "El ID ingresado no existe.\n";
        }
    } while (!$existe);

    // Validar existencia del empleado responsable por número de empleado
    do {
        listarResponsable();
        echo "Número de documento del responsable: ";
        $dnie = trim(fgets(STDIN));
        $responsable = new ResponsableV();
        $existe = $responsable->buscar($dnie);
        if (!$existe) {
            echo "El número de documento no existe.\n";
            echo "Ingresar nuevo responsable\n";
            $responsablef=ingresarResponsable();
            $existe = $empresa->buscar($idViaje);
        } else {
            echo "Este responsable ya esta asignado a un viaje.\n";
            $responsablef=ingresarResponsable();
            $existe = $empresa->buscar($idViaje);
        }
    } while (!$existe);

    // Solicitar importe
    echo "Importe: ";
    $importe = trim(fgets(STDIN));

    // Cargar datos en el objeto Viaje
    $viaje->cargar($destino, $cantMax, $empresa, $responsablef, $importe);

    // Insertar viaje y verificar éxito
    if ($viaje->insertar()) {
        echo "Se insertó el viaje.\n";
    } else {
        echo $viaje->getMensaje();
    }

    return $viaje;
}

function modificarViaje($viaje)
{
    if ($viaje->modificar()) {
        echo "Se modificó el viaje.\n";
    } else {
        echo "No se modificó el viaje.\n";
        echo $viaje->getMensaje();
    };
}

function eliminarViaje()
{
    $viaje = new Viaje();
    echo "Ingrese el número de id del viaje a eliminar: ";
    $idviaje = trim(fgets(STDIN));
    if ($viaje->buscar($idviaje)) {
        if ($viaje->eliminar()) {
            echo "Viaje eliminado con éxito.";
        } else {
            echo "Error al eliminar viaje: " . $viaje->getMensaje();
        }
    } else {
        echo "Viaje no encontrado.";
    }
}


function listarViajes()
{
    $viaje = new Viaje();
    $viajes = $viaje->listar();
    listarArray($viajes);
}

// Funciones para las modificaciones del viaje

// Funcion que retorna un boolean segun si hay viajes cargados
function existenViajes()
{
    $viaje = new Viaje();
    $viajes = $viaje->listar();
    $hayViajesCargados = sizeof($viajes) > 0;
    return $hayViajesCargados;
}

function existenViajesEmpresa($idEmpresa){
    $eliminar = true;
    $viaje = new Viaje();
    $viajeEncontrado = $viaje->BuscarPorIdEmpresa($idEmpresa);
if ($viajeEncontrado) {
    echo "No se puede eliminar esta empresa porque existen viajes asociados a ella \n";
    $eliminar = false;
}
return $eliminar;
}



// funcion que muestra las opciones para modificar el viaje
function opcionesModificarViaje($viaje)
{
    do {

        echo "\n----------MODIFICACIONES VIAJES----------
        1) Destino.
        2) Cantidad maxima de pasajeros. 
        3) Empresa.
        4) Responsable.
        5) Importe. 
        0) Volver atras.
        Opcion: ";
        $opcion = trim(fgets(STDIN));
        switch ($opcion) {
            case 1:
                echo "Ingrese el nuevo destino: ";
                $nuevo = trim(fgets(STDIN));
                $viaje->setVdestino($nuevo);
                modificarViaje($viaje);
                break;
            case 2:
                echo "Ingrese la nueva cantidad de pasajeros: ";
                $nuevo = trim(fgets(STDIN));
                if (is_numeric($nuevo) && $nuevo > 0) {
                    $viaje->setVcantmaxpasajeros($nuevo);
                    modificarViaje($viaje);
                    echo "Cantidad maxima modificada.";
                } else {
                    echo "Cantidad invalida, no se realizo la modificacion.";
                }
                break;
            case 3:
                echo "Ingrese el ID de la nueva empresa: ";
                $nuevo = trim(fgets(STDIN));
                $nuevaEmpresa = new Empresa();
                if ($nuevaEmpresa->buscar($nuevo)) {
                    $viaje->setObjempresa($nuevaEmpresa);
                    modificarViaje($viaje);
                } else {
                    echo "No se encontro una empresa con el ID buscado.\n";
                }
                break;
            case 4:
                echo "Ingrese el Num. Empleado del nuevo responsable: ";
                $nuevo = trim(fgets(STDIN));
                $nuevoResponsable = new ResponsableV();
                if ($nuevoResponsable->buscar($nuevo)) {
                    $viaje->setRnumeroempleado($nuevoResponsable);
                    modificarViaje($viaje);
                } else {
                    echo "No se encontro un responsbale con el Num. Empleado buscado.\n";
                }
                break;
            case 5:
                echo "Ingrese el nuevo importe: ";
                $nuevo = trim(fgets(STDIN));
                $viaje->setVimporte($nuevo);
                modificarViaje($viaje);
                break;
            case 0:
                break;
            default:
                echo "Opcion incorrecta.\n";
        }
    } while ($opcion != 0);
}


// Funciones correspondientes a las opciones del Menú Principal

function gestionEmpresas()
{

    do {
        menuEmpresa();
        $opcionEmpresa = trim(fgets(STDIN));

        switch ($opcionEmpresa) {

            case 1:
                crearEmpresa();
                break;

            case 2:
                $empresa = new Empresa();
                if (existenEmpresas()) {
                    listarEmpresa();
                    echo "Ingrese el ID de la empresa a modificar: ";
                    $id = trim(fgets(STDIN));
                    if ($empresa->buscar($id)) {
                        opcionesModificarEmpresa($empresa);
                    } else {
                        echo "No existe empresa con el ID ingresado.\n";
                    }
                } else {
                    echo "Opcion no disponible. Ingrese una empresa para continuar.\n";
                }
                break;

            case 3:
                listarEmpresa();
                eliminarEmpresa(); // agregar checkeos
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

function gestionViajes()
{
    do {
        menuViaje();
        $opcionViaje = trim(fgets(STDIN));
        $viaje = new Viaje();

        switch ($opcionViaje) {

            case 1:
                crearViaje();
                break;

            case 2:
                if (existenViajes()) {
                    listarViajes();
                    echo "Ingrese el ID del viaje a modificar: ";
                    $id = trim(fgets(STDIN));
                    if ($viaje->buscar($id)) {
                        opcionesModificarViaje($viaje);
                    } else {
                        echo "No se encontro el viaje con el ID solicitado.\n";
                    }
                } else {
                    echo "Opcion no disponible. Inserte un viaje para continuar.\n";
                }
                break;

            case 3:
                listarViajes();
                eliminarViaje();
                break;

            case 4:
                listarViajes();
                break;
            case 5:
                if (existenViajes()) {
                    echo "Ingrese el ID del viaje a listar: ";
                    $idViaje = trim(fgets(STDIN));
                    if ($viaje->buscar($idViaje)) {
                        $pasajeros=listadoPasajerosEnViaje($idViaje);
                        if ($pasajeros !==null){
                        listarArray($pasajeros);
                    }
                    } else {
                        echo "No se encontro el viaje con el ID solicitado.\n";
                    }
                } else {
                    echo "Opcion no disponible. Inserte un viaje para continuar.\n";
                }
                break;

            case 6:
                echo "Volviendo al Menú Principal\n";
                break;

            default:
                echo "Opción inválida. Por favor, intente de nuevo\n";
        }
    } while ($opcionViaje != 6);
}


function gestionPasajeros()
{

    do {
        menuPasajero();
        $opcionPasajero = trim(fgets(STDIN));

        switch ($opcionPasajero) {

            case 1:
                ingresarPasajero();
                break;

            case 2:
                listarPasajero();
                modificarPasajero();
                break;

            case 3:
                listarPasajero();
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


function gestionResponsable()
{

    do {
        menuResponsable();
        $opcionResponsable = trim(fgets(STDIN));

        switch ($opcionResponsable) {

            case 1:
                ingresarResponsable();
                break;

            case 2:
                listarResponsable();
                modificarResponsable();
                break;

            case 3:
                listarResponsable();
                eliminarResponsable();
                break;

            case 4:
                listarResponsable();
                break;
            case 5:
                echo "Volviendo al Menú Principal\n";
                break;
            default:
                echo "Opción no válida. Por favor, intente de nuevo.\n";
        }
    } while ($opcionResponsable != 5);
}



// Función principal para mostrar y gestionar el menú principal

function mostrarMenuPrincipal()
{

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