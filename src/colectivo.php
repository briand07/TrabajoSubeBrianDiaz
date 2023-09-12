<?php 

namespace TrabajoSube;

use PHPUnit\Framework\TestCase;

class Colectivo {
    public $tarifaBasica = 120;

    public function pagarCon(Tarjeta $tarjeta) {
        if ($tarjeta->getSaldo() >= $this->tarifaBasica) {
            $tarjeta->descontarSaldo($this->tarifaBasica);
            return new Boleto($this->tarifaBasica);
        } else {
            return null;
        }
    }
}

class Tarjeta {
    public $saldo;
    public $limiteSaldo = 6600;
    public $cargasAceptadas = [50, 150, 200, 250, 300, 350, 400, 450, 500, 600, 700, 800, 900, 1000, 1100, 1200, 1300, 1400, 1500, 2000, 2500, 3000, 3500, 4000];

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
}

class Boleto {
    private $monto;

    public function __construct($monto) {
        $this->monto = $monto;
    }

    public function getMonto() {
        return $this->monto;
    }
}

$tarjeta = new Tarjeta(250);
$colectivo = new Colectivo();

$boleto = $colectivo->pagarCon($tarjeta);
if ($boleto !== null) {
    echo "Se ha realizado el pago de $" . $boleto->getMonto() . " correctamente. \n";
    echo "Saldo restante en la tarjeta: $" . $tarjeta->getSaldo() . ".\n";
} else {
    echo "No hay suficiente saldo en la tarjeta para pagar el pasaje.\n";
}
