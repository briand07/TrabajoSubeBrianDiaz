<?php 

namespace TrabajoSube;

use PHPUnit\Framework\TestCase;
use TrabajoSube\colectivo;
use TrabajoSube\Tarjeta;
use TrabajoSube\Boleto;
use Exception;

class ColectivoTest extends TestCase {
    public function testPagarConSuficienteSaldo() {
        $tarjeta = new Tarjeta(500); // Cargar una tarjeta con $500 de saldo
        $colectivo = new Colectivo();

        $boleto = $colectivo->pagarCon($tarjeta);

        $this->assertInstanceOf(Boleto::class, $boleto);
        $this->assertEquals(120, $boleto->getMonto());
        $this->assertEquals(380, $tarjeta->getSaldo());
    }

    public function testPagarSinSaldoSuficiente() {
        $tarjeta = new Tarjeta(100); // Cargar una tarjeta con $100 de saldo
        $colectivo = new Colectivo();

        $boleto = $colectivo->pagarCon($tarjeta);

        $this->assertNull($boleto);
        $this->assertEquals(100, $tarjeta->getSaldo());
    }
}