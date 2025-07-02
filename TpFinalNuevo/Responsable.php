<?php
include_once 'Persona.php';

class Responsable extends Persona {
    private $rnumeroempleado;
    private $rnumerolicencia;

    public function __construct() {
        parent::__construct();
        $this->rnumeroempleado = null;
        $this->rnumerolicencia = 0;
    }

    // Getters y Setters
    public function getRnumeroempleado() { return $this->rnumeroempleado; }
    public function setRnumeroempleado($rnumeroempleado) { $this->rnumeroempleado = $rnumeroempleado; }

    public function getRnumerolicencia() { return $this->rnumerolicencia; }
    public function setRnumerolicencia($rnumerolicencia) { $this->rnumerolicencia = $rnumerolicencia; }

    // __toString
    public function __toString() {
        return "Responsable: {$this->nombre} {$this->apellido} - Licencia: {$this->rnumerolicencia}";
    }

    // Métodos ORM
    public function insertar() {
        $base = new BaseDatos();
        $resp = false;
        $query = "INSERT INTO responsable (rnumerolicencia, rnombre, rapellido, activo)
                  VALUES ({$this->rnumerolicencia}, '{$this->nombre}', '{$this->apellido}', {$this->activo})";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($query)) {
                $this->rnumeroempleado = $base->devuelveIDInsercion();
                $resp = true;
            }
        }
        return $resp;
    }

    public function modificar() {
        $base = new BaseDatos();
        $resp = false;
        $query = "UPDATE responsable 
                  SET rnumerolicencia = {$this->rnumerolicencia}, rnombre = '{$this->nombre}', rapellido = '{$this->apellido}', activo = {$this->activo}
                  WHERE rnumeroempleado = {$this->rnumeroempleado}";
        if ($base->Iniciar()) {
            $resp = $base->Ejecutar($query);
        }
        return $resp;
    }

    public function eliminar() {
        $base = new BaseDatos();
        $resp = false;
        $query = "DELETE FROM responsable WHERE rnumeroempleado = {$this->rnumeroempleado}";
        if ($base->Iniciar()) {
            $resp = $base->Ejecutar($query);
        }
        return $resp;
    }

    public static function listar() {
    $base = new BaseDatos();
    $lista = [];
    $consulta = "SELECT * FROM responsable WHERE activo = 1";

    if ($base->Iniciar()) {
        if ($base->Ejecutar($consulta)) {
            while ($row = $base->Registro()) {
                $r = new Responsable();
                $r->setRnumeroempleado($row['rnumeroempleado']);
                $r->setRnumerolicencia($row['rnumerolicencia']);
                $r->setNombre($row['rnombre']);
                $r->setApellido($row['rapellido']);
                $r->setActivo($row['activo']);
                $lista[] = $r;
            }
        }
    }
    return $lista;
}
}
?>
