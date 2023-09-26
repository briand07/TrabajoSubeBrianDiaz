<?php

namespace TrabajoSube;

class Boleto {
    private $monto;

    public function __construct($monto) {
        $this->monto = $monto;
    }

    public function getMonto() {
        return $this->monto;
    }
}