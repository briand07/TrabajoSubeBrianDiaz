<?php

namespace TrabajoSube;

use TrabajoSube\Tiempo;

class Boleto {
    private $monto;
    private $fecha;

    public function __construct($monto, $fecha) {
        $this->monto = $monto;
        $this->fecha = $fecha;
    }

    public function getMonto() {
        return $this->monto;
    }

    public function getFecha() {
        return $this->fecha;
    }
}