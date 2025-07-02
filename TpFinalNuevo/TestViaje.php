<?php
require_once 'BaseDatos.php';
require_once 'Empresa.php';
require_once 'Responsable.php';
require_once 'Viaje.php';
require_once 'Pasajero.php';
require_once 'ViajePasajero.php';

//pasajeros
function menuPasajero() {
    echo "\n===== PASAJEROS =====\n";
    echo "1. Insertar pasajero\n";
    echo "2. Modificar pasajero\n";
    echo "3. Eliminar pasajero\n";
    echo "4. Desactivar pasajero\n";
    echo "5. Ver todos los pasajeros cargados\n";
    echo "6. Salir\n";

    echo "Seleccione una opción: ";
}

function leerEntrada($mensaje) {
    echo $mensaje;
    return trim(fgets(STDIN));
}

function mostrarMenuPasajero() {
    

do {
    menuPasajero();
    $opcion = leerEntrada("");

    switch ($opcion) {
        case 1:
            echo "\n== INSERTAR PASAJERO ==\n";
            $documento = leerEntrada("Documento: ");
            $nombre = leerEntrada("Nombre: ");
            $apellido = leerEntrada("Apellido: ");
            $telefono = leerEntrada("Teléfono: ");

            $pasajero = new Pasajero();
            $pasajero->setPdocumento($documento);
            $pasajero->setNombre($nombre);
            $pasajero->setApellido($apellido);
            $pasajero->setPtelefono($telefono);
            $pasajero->setActivo(1);

            if ($pasajero->insertar()) {
                echo "Pasajero insertado correctamente.\n";
            } else {
                echo "Error al insertar pasajero.\n";
            }
            break;

        case 2:
            echo "\n== MODIFICAR PASAJERO ==\n";
            $pasajeros = Pasajero::listar();
            
            if (empty($pasajeros)) {
                echo "No hay pasajeros activos para modificar.\n";
                break;
            }

            foreach ($pasajeros as $i => $p) {
                echo "$i. {$p->getPdocumento()} - {$p->getNombre()} {$p->getApellido()} ({$p->getPtelefono()})\n";
            }

            $indice = leerEntrada("Seleccione el número del pasajero a modificar: ");
            if (!isset($pasajeros[$indice])) {
                echo "Índice inválido.\n";
                break;
            }

            $pasajero = $pasajeros[$indice];

            $nombre = leerEntrada("Nuevo nombre [{$pasajero->getNombre()}]: ");
            $apellido = leerEntrada("Nuevo apellido [{$pasajero->getApellido()}]: ");
            $telefono = leerEntrada("Nuevo teléfono [{$pasajero->getPtelefono()}]: ");
            

            $pasajero->setNombre($nombre ?: $pasajero->getNombre());
            $pasajero->setApellido($apellido ?: $pasajero->getApellido());
            $pasajero->setPtelefono($telefono ?: $pasajero->getPtelefono());
            

            if ($pasajero->modificar()) {
                echo "Pasajero modificado correctamente.\n";
            } else {
                echo "Error al modificar pasajero.\n";
            }
            break;


        case 3:
            echo "\n== ELIMINAR PASAJERO FÍSICAMENTE ==\n";
            $pasajeros = Pasajero::listar();

            if (empty($pasajeros)) {
                echo "No hay pasajeros activos para eliminar.\n";
                break;
            }

            foreach ($pasajeros as $i => $p) {
                echo "$i. {$p->getPdocumento()} - {$p->getNombre()} {$p->getApellido()} ({$p->getPtelefono()})\n";
            }

            $indice = leerEntrada("Seleccione el número del pasajero a eliminar: ");
            if (!isset($pasajeros[$indice])) {
                echo "Índice inválido.\n";
                break;
            }

            $pasajero = $pasajeros[$indice];

            if ($pasajero->eliminar()) {
                echo "Pasajero eliminado de la base de datos.\n";
            } else {
                echo "Error al eliminar pasajero.\n";
            }
            break;


        case 4:
            echo "\n== ELIMINAR PASAJERO LÓGICAMENTE ==\n";
            $pasajeros = Pasajero::listar();

            if (empty($pasajeros)) {
                echo "No hay pasajeros activos para dar de baja.\n";
                break;
            }

            foreach ($pasajeros as $i => $p) {
                echo "$i. {$p->getPdocumento()} - {$p->getNombre()} {$p->getApellido()} ({$p->getPtelefono()})\n";
            }

            $indice = leerEntrada("Seleccione el número del pasajero a dar de baja lógicamente: ");
            if (!isset($pasajeros[$indice])) {
                echo "Índice inválido.\n";
                break;
            }

            $pasajero = $pasajeros[$indice];
            $pasajero->setActivo(0);

            if ($pasajero->modificar()) {
                echo "Pasajero desactivado correctamente (baja lógica).\n";
            } else {
                echo "Error al dar de baja al pasajero.\n";
            }
            break;

        case 5:
            echo "\n== LISTA DE PASAJEROS CARGADOS ==\n";
            $pasajeros = Pasajero::listar();

            if (empty($pasajeros)) {
                echo "No hay pasajeros activos en el sistema.\n";
            } else {
                foreach ($pasajeros as $i => $p) {
                    echo ($i + 1) . ". " . $p->__toString() . "\n";
                }
            }
            break;

        case 6:
            echo "Saliendo del menú de pasajeros...\n";
            break;

        default:
            echo "Opción inválida. Intentá de nuevo.\n";
    }
} while ($opcion != 6);
}

function menuResponsable() {
    echo "\n===== MENÚ DE RESPONSABLES =====\n";
    echo "1. Insertar responsable\n";
    echo "2. Modificar responsable\n";
    echo "3. Eliminar responsable físicamente\n";
    echo "4. Eliminar responsable lógicamente (activo = 0)\n";
    echo "5. Ver todos los responsables cargados\n";
    echo "6. Salir\n";
    echo "Seleccione una opción: ";
}


function mostrarMenuResponsable() {
    

do {
    menuResponsable();
    $opcion = leerEntrada("");

    switch ($opcion) {
        case 1:
            echo "\n== INSERTAR RESPONSABLE ==\n";
            $licencia = leerEntrada("Número de licencia: ");
            $nombre = leerEntrada("Nombre: ");
            $apellido = leerEntrada("Apellido: ");

            $responsable = new Responsable();
            $responsable->setRnumerolicencia($licencia);
            $responsable->setNombre($nombre);
            $responsable->setApellido($apellido);
            $responsable->setActivo(1);

            if ($responsable->insertar()) {
                echo "Responsable insertado correctamente.\n";
            } else {
                echo "Error al insertar responsable.\n";
            }
            break;

        case 2:
            echo "\n== MODIFICAR RESPONSABLE ==\n";
            $responsables = Responsable::listar();

            if (empty($responsables)) {
                echo "No hay responsables activos para modificar.\n";
                break;
            }

            foreach ($responsables as $i => $r) {
                echo "$i. {$r->getRnumeroempleado()} - {$r->getNombre()} {$r->getApellido()} (Licencia: {$r->getRnumerolicencia()})\n";
            }

            $indice = leerEntrada("Seleccione el número del responsable a modificar: ");
            if (!isset($responsables[$indice])) {
                echo "Índice inválido.\n";
                break;
            }

            $responsable = $responsables[$indice];

            $licencia = leerEntrada("Nuevo número de licencia [{$responsable->getRnumerolicencia()}]: ");
            $nombre = leerEntrada("Nuevo nombre [{$responsable->getNombre()}]: ");
            $apellido = leerEntrada("Nuevo apellido [{$responsable->getApellido()}]: ");
            

            $responsable->setRnumerolicencia($licencia ?: $responsable->getRnumerolicencia());
            $responsable->setNombre($nombre ?: $responsable->getNombre());
            $responsable->setApellido($apellido ?: $responsable->getApellido());
            

            if ($responsable->modificar()) {
                echo "Responsable modificado correctamente.\n";
            } else {
                echo "Error al modificar responsable.\n";
            }
            break;

        case 3:
            echo "\n== ELIMINAR RESPONSABLE FÍSICAMENTE ==\n";
            $responsables = Responsable::listar();

            if (empty($responsables)) {
                echo "No hay responsables activos para eliminar.\n";
                break;
            }

            foreach ($responsables as $i => $r) {
                echo "$i. {$r->getRnumeroempleado()} - {$r->getNombre()} {$r->getApellido()} (Licencia: {$r->getRnumerolicencia()})\n";
            }

            $indice = leerEntrada("Seleccione el número del responsable a eliminar: ");
            if (!isset($responsables[$indice])) {
                echo "Índice inválido.\n";
                break;
            }

            $responsable = $responsables[$indice];

            if ($responsable->eliminar()) {
                echo "Responsable eliminado de la base de datos.\n";
            } else {
                echo "Error al eliminar responsable.\n";
            }
            break;

        case 4:
            echo "\n== ELIMINAR RESPONSABLE LÓGICAMENTE ==\n";
            $responsables = Responsable::listar();

            if (empty($responsables)) {
                echo "No hay responsables activos para dar de baja.\n";
                break;
            }

            foreach ($responsables as $i => $r) {
                echo "$i. {$r->getRnumeroempleado()} - {$r->getNombre()} {$r->getApellido()} (Licencia: {$r->getRnumerolicencia()})\n";
            }

            $indice = leerEntrada("Seleccione el número del responsable a dar de baja lógicamente: ");
            if (!isset($responsables[$indice])) {
                echo "Índice inválido.\n";
                break;
            }

            $responsable = $responsables[$indice];
            $responsable->setActivo(0);

            if ($responsable->modificar()) {
                echo "Responsable desactivado correctamente (baja lógica).\n";
            } else {
                echo "Error al dar de baja al responsable.\n";
            }
            break;

        case 5:
            echo "\n== LISTA DE RESPONSABLES CARGADOS ==\n";
            $responsables = Responsable::listar();

            if (empty($responsables)) {
                echo "No hay responsables activos en el sistema.\n";
            } else {
                foreach ($responsables as $i => $r) {
                    echo ($i + 1) . ". " . $r->__toString() . "\n";
                }
            }
            break;

        case 6:
            echo "Saliendo del menú de responsables...\n";
            break;

        default:
            echo "Opción inválida. Intentá de nuevo.\n";
    }
} while ($opcion != 6);

}

//empresas

function menuEmpresa() {
    echo "\n===== MENÚ DE EMPRESAS =====\n";
    echo "1. Insertar empresa\n";
    echo "2. Modificar empresa\n";
    echo "3. Eliminar empresa físicamente\n";
    echo "4. Eliminar empresa lógicamente (activo = 0)\n";
    echo "5. Ver todas las empresas cargadas\n";
    echo "6. Salir\n";
    echo "Seleccione una opción: ";
}


function mostrarMenuEmpresa() {
    

do {
    menuEmpresa();
    $opcion = leerEntrada("");

    switch ($opcion) {
        case 1:
            echo "\n== INSERTAR EMPRESA ==\n";
            $nombre = leerEntrada("Nombre de la empresa: ");
            $direccion = leerEntrada("Dirección: ");

            $empresa = new Empresa();
            $empresa->setEnombre($nombre);
            $empresa->setEdireccion($direccion);
            $empresa->setActivo(1);

            if ($empresa->insertar()) {
                echo "Empresa insertada correctamente.\n";
            } else {
                echo "Error al insertar empresa.\n";
            }
            break;

        case 2:
            echo "\n== MODIFICAR EMPRESA ==\n";
            $empresas = Empresa::listar();

            if (empty($empresas)) {
                echo "No hay empresas activas para modificar.\n";
                break;
            }

            foreach ($empresas as $i => $e) {
                echo "$i. {$e->getIdempresa()} - {$e->getEnombre()} ({$e->getEdireccion()})\n";
            }

            $indice = leerEntrada("Seleccione el número de la empresa a modificar: ");
            if (!isset($empresas[$indice])) {
                echo "Índice inválido.\n";
                break;
            }

            $empresa = $empresas[$indice];

            $nombre = leerEntrada("Nuevo nombre [{$empresa->getEnombre()}]: ");
            $direccion = leerEntrada("Nueva dirección [{$empresa->getEdireccion()}]: ");
            

            $empresa->setEnombre($nombre ?: $empresa->getEnombre());
            $empresa->setEdireccion($direccion ?: $empresa->getEdireccion());
            

            if ($empresa->modificar()) {
                echo "Empresa modificada correctamente.\n";
            } else {
                echo "Error al modificar empresa.\n";
            }
            break;

        case 3:
            echo "\n== ELIMINAR EMPRESA FÍSICAMENTE ==\n";
            $empresas = Empresa::listar();

            if (empty($empresas)) {
                echo "No hay empresas activas para eliminar.\n";
                break;
            }

            foreach ($empresas as $i => $e) {
                echo "$i. {$e->getIdempresa()} - {$e->getEnombre()} ({$e->getEdireccion()})\n";
            }

            $indice = leerEntrada("Seleccione el número de la empresa a eliminar: ");
            if (!isset($empresas[$indice])) {
                echo "Índice inválido.\n";
                break;
            }

            $empresa = $empresas[$indice];

            if ($empresa->eliminar()) {
                echo "Empresa eliminada de la base de datos.\n";
            } else {
                echo "Error al eliminar empresa.\n";
            }
            break;

        case 4:
            echo "\n== ELIMINAR EMPRESA LÓGICAMENTE ==\n";
            $empresas = Empresa::listar();

            if (empty($empresas)) {
                echo "No hay empresas activas para dar de baja.\n";
                break;
            }

            foreach ($empresas as $i => $e) {
                echo "$i. {$e->getIdempresa()} - {$e->getEnombre()} ({$e->getEdireccion()})\n";
            }

            $indice = leerEntrada("Seleccione el número de la empresa a dar de baja lógicamente: ");
            if (!isset($empresas[$indice])) {
                echo "Índice inválido.\n";
                break;
            }

            $empresa = $empresas[$indice];
            $empresa->setActivo(0);

            if ($empresa->modificar()) {
                echo "Empresa desactivada correctamente (baja lógica).\n";
            } else {
                echo "Error al dar de baja la empresa.\n";
            }
            break;

        case 5:
            echo "\n== LISTA DE EMPRESAS CARGADAS ==\n";
            $empresas = Empresa::listar();

            if (empty($empresas)) {
                echo "No hay empresas activas en el sistema.\n";
            } else {
                foreach ($empresas as $i => $e) {
                    echo ($i + 1) . ". " . $e->__toString() . "\n";
                }
            }
            break;

        case 6:
            echo "Saliendo del menú de empresas...\n";
            break;

        default:
            echo "Opción inválida. Intentá de nuevo.\n";
    }
} while ($opcion != 6);
}

//viajes


function menuViaje() {
    echo "\n===== MENÚ DE VIAJES =====\n";
    echo "1. Insertar viaje\n";
    echo "2. Modificar viaje\n";
    echo "3. Eliminar viaje físicamente\n";
    echo "4. Eliminar viaje lógicamente (activo = 0)\n";
    echo "5. Ver todos los viajes cargados\n";
    echo "6. Salir\n";
    echo "Seleccione una opción: ";
}


function mostrarMenuViaje() {
    

do {
    menuViaje();
    $opcion = leerEntrada("");

    switch ($opcion) {
                case 1:
            echo "\n== INSERTAR VIAJE ==\n";

            
            $empresas = Empresa::listar();
            if (empty($empresas)) {
                echo "No hay empresas activas cargadas. Primero agregá una.\n";
                break;
            }

            echo "Empresas disponibles:\n";
            foreach ($empresas as $i => $e) {
                echo "$i. {$e->getIdempresa()} - {$e->getEnombre()} ({$e->getEdireccion()})\n";
            }
            $iEmpresa = leerEntrada("Seleccione el número de la empresa: ");
            if (!isset($empresas[$iEmpresa])) {
                echo "Opción inválida.\n";
                break;
            }
            $idempresa = $empresas[$iEmpresa]->getIdempresa();

            // Lo que te decia de como se podian mostrar los cosos activos anashex
            $responsables = Responsable::listar();
            if (empty($responsables)) {
                echo "No hay responsables activos cargados. Primero agregá uno.\n";
                break;
            }

            echo "Responsables disponibles:\n";
            foreach ($responsables as $i => $r) {
                echo "$i. {$r->getRnumeroempleado()} - {$r->getNombre()} {$r->getApellido()}\n";
            }
            $iResp = leerEntrada("Seleccione el número del responsable: ");
            if (!isset($responsables[$iResp])) {
                echo "Opción inválida.\n";
                break;
            }
            $rnumeroempleado = $responsables[$iResp]->getRnumeroempleado();

            
            $destino = leerEntrada("Destino: ");
            $cantMax = leerEntrada("Cantidad máxima de pasajeros: ");
            $importe = leerEntrada("Importe: ");

            $viaje = new Viaje();
            $viaje->setVdestino($destino);
            $viaje->setVcantMaxPasajeros($cantMax);
            $viaje->setVimporte($importe);
            $viaje->setIdempresa($idempresa);
            $viaje->setRnumeroempleado($rnumeroempleado);
            $viaje->setActivo(1);

            if ($viaje->insertar()) {
                echo "Viaje insertado correctamente.\n";
            } else {
                echo "Error al insertar viaje.\n";
            }
            break;


        case 2:
            echo "\n== MODIFICAR VIAJE ==\n";
            $viajes = Viaje::listar();

            if (empty($viajes)) {
                echo "No hay viajes activos para modificar.\n";
                break;
            }

            foreach ($viajes as $i => $v) {
                echo "$i. {$v->getIdviaje()} - Destino: {$v->getVdestino()}, Empresa ID: {$v->getIdempresa()}, Responsable: {$v->getRnumeroempleado()}\n";
            }

            $indice = leerEntrada("Seleccione el número del viaje a modificar: ");
            if (!isset($viajes[$indice])) {
                echo "Índice inválido.\n";
                break;
            }

            $viaje = $viajes[$indice];

            $destino = leerEntrada("Nuevo destino [{$viaje->getVdestino()}]: ");
            $cantMax = leerEntrada("Nueva cantidad máxima [{$viaje->getVcantMaxPasajeros()}]: ");
            $importe = leerEntrada("Nuevo importe [{$viaje->getVimporte()}]: ");
            $idempresa = leerEntrada("Nuevo ID empresa [{$viaje->getIdempresa()}]: ");
            $rnumeroempleado = leerEntrada("Nuevo número empleado [{$viaje->getRnumeroempleado()}]: ");
            

            $viaje->setVdestino($destino ?: $viaje->getVdestino());
            $viaje->setVcantMaxPasajeros($cantMax ?: $viaje->getVcantMaxPasajeros());
            $viaje->setVimporte($importe ?: $viaje->getVimporte());
            $viaje->setIdempresa($idempresa ?: $viaje->getIdempresa());
            $viaje->setRnumeroempleado($rnumeroempleado ?: $viaje->getRnumeroempleado());
            

            if ($viaje->modificar()) {
                echo "Viaje modificado correctamente.\n";
            } else {
                echo "Error al modificar viaje.\n";
            }
            break;

        case 3:
            echo "\n== ELIMINAR VIAJE FÍSICAMENTE ==\n";
            $viajes = Viaje::listar();

            if (empty($viajes)) {
                echo "No hay viajes activos para eliminar.\n";
                break;
            }

            foreach ($viajes as $i => $v) {
                echo "$i. {$v->getIdviaje()} - Destino: {$v->getVdestino()}\n";
            }

            $indice = leerEntrada("Seleccione el número del viaje a eliminar: ");
            if (!isset($viajes[$indice])) {
                echo "Índice inválido.\n";
                break;
            }

            $viaje = $viajes[$indice];

            if ($viaje->eliminar()) {
                echo "Viaje eliminado de la base de datos.\n";
            } else {
                echo "Error al eliminar viaje.\n";
            }
            break;

        case 4:
            echo "\n== ELIMINAR VIAJE LÓGICAMENTE ==\n";
            $viajes = Viaje::listar();

            if (empty($viajes)) {
                echo "No hay viajes activos para dar de baja.\n";
                break;
            }

            foreach ($viajes as $i => $v) {
                echo "$i. {$v->getIdviaje()} - Destino: {$v->getVdestino()}\n";
            }

            $indice = leerEntrada("Seleccione el número del viaje a dar de baja lógicamente: ");
            if (!isset($viajes[$indice])) {
                echo "Índice inválido.\n";
                break;
            }

            $viaje = $viajes[$indice];
            $viaje->setActivo(0);

            if ($viaje->modificar()) {
                echo "Viaje dado de baja correctamente (baja lógica).\n";
            } else {
                echo "Error al dar de baja el viaje.\n";
            }
            break;

        case 5:
            echo "\n== LISTA DE VIAJES CARGADOS ==\n";
            $viajes = Viaje::listar();

            if (empty($viajes)) {
                echo "No hay viajes activos en el sistema.\n";
            } else {
                foreach ($viajes as $i => $v) {
                    echo ($i + 1) . ". " . $v->__toString() . "\n";
                }
            }
            break;

        case 6:
            echo "Saliendo del menú de viajes...\n";
            break;

        default:
            echo "Opción inválida. Intentá de nuevo.\n";
    }
} while ($opcion != 6);
}

//tabla intermedia viajePasajero


function menuViajePasajero() {
    echo "\n===== MENÚ DE VIAJES - PASAJEROS =====\n";
    echo "1. Agregar pasajero a un viaje\n";
    echo "2. Quitar pasajero de un viaje\n";
    echo "3. Ver pasajeros de un viaje\n";
    echo "4. Salir\n";
    echo "Seleccione una opción: ";
}


function mostrarMenuViajePasajero() {
    

do {
    menuViajePasajero();
    $opcion = leerEntrada("");

    switch ($opcion) {
                case 1:
            echo "\n== AGREGAR PASAJERO A UN VIAJE ==\n";
            $viajes = Viaje::listar();
            $pasajeros = Pasajero::listar();

            if (empty($viajes) || empty($pasajeros)) {
                echo "Debe haber al menos un viaje y un pasajero activo para asociar.\n";
                break;
            }

            echo "Viajes disponibles:\n";
            foreach ($viajes as $i => $v) {
                echo "$i. {$v->getIdviaje()} - {$v->getVdestino()} (Máx: {$v->getVcantMaxPasajeros()})\n";
            }
            $iViaje = leerEntrada("Seleccione el número del viaje: ");
            if (!isset($viajes[$iViaje])) {
                echo "Opción inválida.\n";
                break;
            }

            $viajeSeleccionado = $viajes[$iViaje];
            $idviaje = $viajeSeleccionado->getIdviaje();
            $capacidadMax = $viajeSeleccionado->getVcantMaxPasajeros();

            $pasajerosActuales = ViajePasajero::listarPorViaje($idviaje);

            if (count($pasajerosActuales) >= $capacidadMax) {
                echo "Este viaje ya alcanzó su capacidad máxima de pasajeros ({$capacidadMax}).\n";
                break;
            }

            echo "Pasajeros disponibles:\n";
            foreach ($pasajeros as $i => $p) {
                echo "$i. {$p->getPdocumento()} - {$p->getNombre()} {$p->getApellido()}\n";
            }
            $iPasajero = leerEntrada("Seleccione el número del pasajero: ");
            if (!isset($pasajeros[$iPasajero])) {
                echo "Opción inválida.\n";
                break;
            }

            $pdocumento = $pasajeros[$iPasajero]->getPdocumento();

            
            $yaCargado = false;
            foreach ($pasajerosActuales as $asig) {
                if ($asig['pdocumento'] === $pdocumento) {
                    $yaCargado = true;
                    break;
                }
            }

            if ($yaCargado) {
                echo "Este pasajero ya está registrado en ese viaje.\n";
            } else {
                $vp = new ViajePasajero($idviaje, $pdocumento);
                if ($vp->insertar()) {
                    echo "Pasajero agregado al viaje correctamente.\n";
                } else {
                    echo "Error al agregar pasajero al viaje.\n";
                }
            }
            break;


        case 2:
            echo "\n== QUITAR PASAJERO DE UN VIAJE ==\n";
            $viajes = Viaje::listar();
            foreach ($viajes as $i => $v) {
                echo "$i. {$v->getIdviaje()} - {$v->getVdestino()}\n";
            }
            $iViaje = leerEntrada("Seleccione el número del viaje: ");
            if (!isset($viajes[$iViaje])) break;

            $idViaje = $viajes[$iViaje]->getIdviaje();
            $pasajeros = ViajePasajero::listarPorViaje($idViaje);

            if (empty($pasajeros)) {
                echo "No hay pasajeros cargados en ese viaje.\n";
                break;
            }

            foreach ($pasajeros as $i => $p) {
                echo "$i. {$p['pdocumento']} - {$p['pnombre']} {$p['papellido']}\n";
            }

            $iPas = leerEntrada("Seleccione el número del pasajero a quitar: ");
            if (!isset($pasajeros[$iPas])) break;

            $vp = new ViajePasajero($idViaje, $pasajeros[$iPas]['pdocumento']);
            if ($vp->eliminar()) {
                echo "Pasajero eliminado del viaje correctamente.\n";
            } else {
                echo "Error al eliminar al pasajero del viaje.\n";
            }
            break;

        case 3:
            echo "\n== VER PASAJEROS DE UN VIAJE ==\n";
            $viajes = Viaje::listar();
            foreach ($viajes as $i => $v) {
                echo "$i. {$v->getIdviaje()} - {$v->getVdestino()}\n";
            }
            $iViaje = leerEntrada("Seleccione el número del viaje: ");
            if (!isset($viajes[$iViaje])) break;

            $lista = ViajePasajero::listarPorViaje($viajes[$iViaje]->getIdviaje());
            if (empty($lista)) {
                echo "Este viaje no tiene pasajeros.\n";
            } else {
                foreach ($lista as $i => $p) {
                    echo ($i + 1) . ". {$p['pdocumento']} - {$p['pnombre']} {$p['papellido']}\n";
                }
            }
            break;

        case 4:
            echo "Saliendo del menú de viaje-pasajero...\n";
            break;

        default:
            echo "Opción inválida.\n";
    }
} while ($opcion != 4);
}

function menuPrincipal() {
    echo "\n===== MENÚ PRINCIPAL =====\n";
    echo "1. Gestionar Pasajeros\n";
    echo "2. Gestionar Responsables\n";
    echo "3. Gestionar Empresas\n";
    echo "4. Gestionar Viajes\n";
    echo "5. Gestionar Pasajeros por Viaje\n";
    echo "6. Salir\n";
    echo "Seleccione una opción: ";
}

// Ejecutar menu principal
do {
    menuPrincipal();
    $opcion = leerEntrada("");

    switch ($opcion) {
        case 1:
            mostrarMenuPasajero();
            break;
        case 2:
            mostrarMenuResponsable();
            break;
        case 3:
            mostrarMenuEmpresa();
            break;
        case 4:
            mostrarMenuViaje();
            break;
        case 5:
            mostrarMenuViajePasajero();
            break;
        case 6:
            echo "Cerrando sistema.\n";
            break;
        default:
            echo "Opción inválida. Intente de nuevo.\n";
    }
} while ($opcion != 6);
?>
