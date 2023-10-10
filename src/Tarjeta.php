<?php

namespace TrabajoSube;

class Tarjeta {
    private $saldo;
    private $limiteSaldo = 6600;
    private $cargasAceptadas = [150, 200, 250, 300, 350, 400, 450, 500, 600, 700, 800, 900, 1000, 1100, 1200, 1300, 1400, 1500, 2000, 2500, 3000, 3500, 4000];

    public function __construct($saldoInicial) {
        if (in_array($saldoInicial, $this->cargasAceptadas)) {
            $this->saldo = $saldoInicial;
        } else {
            throw new Exception("Monto de carga no válido");
        }
    }

    public function getSaldo() {
        return $this->saldo;
    }

    public function descontarSaldo($monto) {
        $this->saldo -= $monto;
    }

    public function cargarSaldo($monto) {
        if (in_array($monto, $this->cargasAceptadas)) {
            if (($this->saldo + $monto) <= $this->limiteSaldo) {
                $this->saldo += $monto;
                echo "Se ha cargado $" . $monto . " en la tarjeta. Saldo actual: $" . $this->saldo . PHP_EOL;
            } else {
                echo "No se puede cargar más saldo. Se ha alcanzado el límite de saldo en la tarjeta." . PHP_EOL;
            }
        } else {
            echo "Monto de carga no válido." . PHP_EOL;
        }
    }
}

class MedioBoleto extends Tarjeta {
    public function descontarSaldo($monto) {
        parent::descontarSaldo($monto / 2);
    }
}

class FranquiciaCompleta extends Tarjeta {
    public function descontarSaldo($monto) {
        parent::descontarSaldo(0);
    }
}