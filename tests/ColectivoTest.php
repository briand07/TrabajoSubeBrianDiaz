<?php 

namespace TrabajoSube;

use PHPUnit\Framework\TestCase;
use TrabajoSube\colectivo;
use TrabajoSube\Tarjeta;
use TrabajoSube\Boleto;

class ColectivoTest extends TestCase{}


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