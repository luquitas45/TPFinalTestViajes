<?php
class Viaje {
    private $idviaje;
    private $vdestino;
    private $vcantmaxpasajeros;
    private $idempresa; // FK
    private $rnumeroempleado; // FK
    private $vimporte;
    private $activo;

    public function __construct() {
        $this->idviaje = null;
        $this->vdestino = "";
        $this->vcantmaxpasajeros = 0;
        $this->idempresa = null;
        $this->rnumeroempleado = null;
        $this->vimporte = 0.0;
        $this->activo = 1;
    }

    // Getters y Setters
    public function getIdviaje() { return $this->idviaje; }
    public function setIdviaje($idviaje) { $this->idviaje = $idviaje; }

    public function getVdestino() { return $this->vdestino; }
    public function setVdestino($vdestino) { $this->vdestino = $vdestino; }

    public function getVcantmaxpasajeros() { return $this->vcantmaxpasajeros; }
    public function setVcantmaxpasajeros($vcantmaxpasajeros) { $this->vcantmaxpasajeros = $vcantmaxpasajeros; }

    public function getIdempresa() { return $this->idempresa; }
    public function setIdempresa($idempresa) { $this->idempresa = $idempresa; }

    public function getRnumeroempleado() { return $this->rnumeroempleado; }
    public function setRnumeroempleado($rnumeroempleado) { $this->rnumeroempleado = $rnumeroempleado; }

    public function getVimporte() { return $this->vimporte; }
    public function setVimporte($vimporte) { $this->vimporte = $vimporte; }

    public function getActivo() { return $this->activo; }
    public function setActivo($activo) { $this->activo = $activo; }

    // __toString
    public function __toString() {
        return "Viaje a {$this->vdestino} - Empresa: {$this->idempresa}, Responsable: {$this->rnumeroempleado}, Cupo Máximo: {$this->vcantmaxpasajeros}, Importe: \${$this->vimporte}";
    }

    // Métodos ORM
    public function insertar() {
        $base = new BaseDatos();
        $resp = false;
        $query = "INSERT INTO viaje (vdestino, vcantmaxpasajeros, idempresa, rnumeroempleado, vimporte, activo)
                  VALUES ('{$this->vdestino}', {$this->vcantmaxpasajeros}, {$this->idempresa}, {$this->rnumeroempleado}, {$this->vimporte}, {$this->activo})";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($query)) {
                $this->idviaje = $base->devuelveIDInsercion();
                $resp = true;
            }
        }
        return $resp;
    }

    public function modificar() {
        $base = new BaseDatos();
        $resp = false;
        $query = "UPDATE viaje 
                  SET vdestino = '{$this->vdestino}', 
                      vcantmaxpasajeros = {$this->vcantmaxpasajeros}, 
                      idempresa = {$this->idempresa}, 
                      rnumeroempleado = {$this->rnumeroempleado}, 
                      vimporte = {$this->vimporte},
                      activo = {$this->activo}
                  WHERE idviaje = {$this->idviaje}";
        if ($base->Iniciar()) {
            $resp = $base->Ejecutar($query);
        }
        return $resp;
    }

    public function eliminar() {
        $base = new BaseDatos();
        $resp = false;
        $query = "DELETE FROM viaje WHERE idviaje = {$this->idviaje}";
        if ($base->Iniciar()) {
            $resp = $base->Ejecutar($query);
        }
        return $resp;
    }

    public static function listar() {
    $base = new BaseDatos();
    $lista = [];
    $consulta = "SELECT * FROM viaje WHERE activo = 1";

    if ($base->Iniciar()) {
        if ($base->Ejecutar($consulta)) {
            while ($row = $base->Registro()) {
                $v = new Viaje();
                $v->setIdviaje($row['idviaje']);
                $v->setVdestino($row['vdestino']);
                $v->setVcantMaxPasajeros($row['vcantmaxpasajeros']);
                $v->setVimporte($row['vimporte']);
                $v->setIdempresa($row['idempresa']);
                $v->setRnumeroempleado($row['rnumeroempleado']);
                $v->setActivo($row['activo']);
                $lista[] = $v;
            }
        }
    }
    return $lista;
}

}
?>
