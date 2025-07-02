<?php
class Persona {
    protected $nombre;
    protected $apellido;
    protected $activo;

    public function __construct() {
        $this->nombre = "";
        $this->apellido = "";
        $this->activo = 1;
    }

    // Getters y Setters
    public function getNombre() { return $this->nombre; }
    public function setNombre($nombre) { $this->nombre = $nombre; }

    public function getApellido() { return $this->apellido; }
    public function setApellido($apellido) { $this->apellido = $apellido; }

    public function getActivo() { return $this->activo; }
    public function setActivo($activo) { $this->activo = $activo; }
}
?>
