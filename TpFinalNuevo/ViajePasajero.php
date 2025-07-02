<?php

class ViajePasajero {
    private $idviaje;
    private $pdocumento;

    public function __construct($idviaje = null, $pdocumento = null) {
        $this->idviaje = $idviaje;
        $this->pdocumento = $pdocumento;
    }

    public function getIdviaje() {
        return $this->idviaje;
    }

    public function setIdviaje($idviaje) {
        $this->idviaje = $idviaje;
    }

    public function getPdocumento() {
        return $this->pdocumento;
    }

    public function setPdocumento($pdocumento) {
        $this->pdocumento = $pdocumento;
    }

    public function insertar() {
        $base = new BaseDatos();
        $sql = "INSERT INTO viaje_pasajero (idviaje, pdocumento) VALUES ('$this->idviaje', '$this->pdocumento')";
        if ($base->Iniciar()) {
            return $base->Ejecutar($sql);
        }
        return false;
    }

    public function eliminar() {
        $base = new BaseDatos();
        $sql = "DELETE FROM viaje_pasajero WHERE idviaje = '$this->idviaje' AND pdocumento = '$this->pdocumento'";
        if ($base->Iniciar()) {
            return $base->Ejecutar($sql);
        }
        return false;
    }

    public static function listarPorViaje($idviaje) {
        $base = new BaseDatos();
        $lista = [];
        $consulta = "SELECT vp.pdocumento, p.pnombre, p.papellido FROM viaje_pasajero vp
                     JOIN pasajero p ON vp.pdocumento = p.pdocumento
                     WHERE vp.idviaje = $idviaje";

        if ($base->Iniciar()) {
            if ($base->Ejecutar($consulta)) {
                while ($row = $base->Registro()) {
                    $lista[] = $row;
                }
            }
        }
        return $lista;
    }
}
