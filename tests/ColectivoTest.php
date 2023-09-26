<?php 

namespace TrabajoSube;

use PHPUnit\Framework\TestCase;
use TrabajoSube\colectivo;

class ColectivoTest extends TestCase{

    public function testGetlinea(){
        $cole = new Colectivo(103);
        $this->assertEquals($cole->getLinea(), 103);
    }
}

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

class Boleto {
    private $monto;

    public function __construct($monto) {
        $this->monto = $monto;
    }

    public function getMonto() {
        return $this->monto;
    }
}

$tarjeta = new Tarjeta(500); // Cargar una tarjeta con $500 de saldo
echo "Saldo inicial en la tarjeta: $" . $tarjeta->getSaldo() . PHP_EOL;

$tarjeta->cargarSaldo(300); // Cargar $300 de saldo
$tarjeta->cargarSaldo(1000); // Cargar $1000 de saldo
$tarjeta->cargarSaldo(2000); // Cargar $2000 de saldo
$tarjeta->cargarSaldo(4000); // Intentar cargar $5000 de saldo (supera el límite)

echo "Saldo actual en la tarjeta: $" . $tarjeta->getSaldo() . PHP_EOL;

$colectivo = new Colectivo();

$boleto = $colectivo->pagarCon($tarjeta);
if ($boleto !== null) {
    echo "Se ha realizado el pago de $" . $boleto->getMonto() . " correctamente." . PHP_EOL;
    echo "Saldo restante en la tarjeta: $" . $tarjeta->getSaldo() . PHP_EOL;
} else {
    echo "No hay suficiente saldo en la tarjeta para pagar el pasaje." . PHP_EOL;
}