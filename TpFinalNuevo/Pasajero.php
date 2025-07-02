<?php
include_once 'Persona.php';

class Pasajero extends Persona {
    private $pdocumento;
    private $ptelefono;

    public function __construct() {
        parent::__construct();
        $this->pdocumento = "";
        $this->ptelefono = 0;
    }

    
    public function getPdocumento() { return $this->pdocumento; }
    public function setPdocumento($pdocumento) { $this->pdocumento = $pdocumento; }

    public function getPtelefono() { return $this->ptelefono; }
    public function setPtelefono($ptelefono) { $this->ptelefono = $ptelefono; }

    
    public function __toString() {
        return "Pasajero: {$this->nombre} {$this->apellido} - Documento: {$this->pdocumento} - Teléfono: {$this->ptelefono}";
    }

    
    public function insertar() {
        $base = new BaseDatos();
        $resp = false;
        $query = "INSERT INTO pasajero (pdocumento, pnombre, papellido, ptelefono, activo)
                  VALUES ('{$this->pdocumento}', '{$this->nombre}', '{$this->apellido}', {$this->ptelefono}, {$this->activo})";
        if ($base->Iniciar()) {
            $resp = $base->Ejecutar($query);
        }
        return $resp;
    }

    public function modificar() {
        $base = new BaseDatos();
        $resp = false;
        $query = "UPDATE pasajero 
                  SET pnombre = '{$this->nombre}', papellido = '{$this->apellido}', ptelefono = {$this->ptelefono}, activo = {$this->activo}
                  WHERE pdocumento = '{$this->pdocumento}'";
        if ($base->Iniciar()) {
            $resp = $base->Ejecutar($query);
        }
        return $resp;
    }

    public function eliminar() {
        $base = new BaseDatos();
        $resp = false;
        $query = "DELETE FROM pasajero WHERE pdocumento = '{$this->pdocumento}'";
        if ($base->Iniciar()) {
            $resp = $base->Ejecutar($query);
        }
        return $resp;
    }

    public static function listar() {
    $base = new BaseDatos();
    $lista = [];
    $consulta = "SELECT * FROM pasajero WHERE activo = 1";

    if ($base->Iniciar()) {
        if ($base->Ejecutar($consulta)) {
            while ($row = $base->Registro()) {
                $p = new Pasajero();
                $p->setPdocumento($row['pdocumento']);
                $p->setNombre($row['pnombre']);
                $p->setApellido($row['papellido']);
                $p->setPtelefono($row['ptelefono']);
                $p->setActivo($row['activo']);
                $lista[] = $p;
            }
        }
    }
    return $lista;
}

}
?>
