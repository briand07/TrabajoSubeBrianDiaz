<?php 

namespace TrabajoSube;

use PHPUnit\Framework\TestCase;
use TrabajoSube\colectivo;
use TrabajoSube\Tarjeta;
use TrabajoSube\Boleto;

class TarjetaTest extends TestCase {

    public function testPagarConSaldoSuficiente() {
        $tarjeta = new Tarjeta(200); // Saldo suficiente
        $colectivo = new Colectivo();

        $boleto = $colectivo->pagarCon($tarjeta);

        $this->assertInstanceOf(Boleto::class, $boleto);
        $this->assertEquals(120, $boleto->getMonto());
        $this->assertEquals(80, $tarjeta->getSaldo());
    }

    public function testPagarSinSaldoSuficiente() {
        $tarjeta = new Tarjeta(50); // Saldo insuficiente
        $colectivo = new Colectivo();

        $boleto = $colectivo->pagarCon($tarjeta);

        $this->assertFalse($boleto);
        $this->assertEquals(50, $tarjeta->getSaldo());
    }
}