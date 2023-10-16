<?php 
/*
namespace TrabajoSube;

use PHPUnit\Framework\TestCase;
use TrabajoSube\colectivo;
use TrabajoSube\Tarjeta;
use TrabajoSube\Boleto;

class TarjetaTest extends TestCase {

    public function testPagarConSaldoSuficiente() {
        $tarjeta = new Tarjeta(150);
        $colectivo = new Colectivo(132);

        $boleto = $colectivo->pagarCon($tarjeta);
        
        $this->assertEquals(120, $boleto->getMonto());
        $this->assertEquals(30, $tarjeta->getSaldo());
        
        $boleto = $colectivo->pagarCon($tarjeta);
        $boleto = $colectivo->pagarCon($tarjeta);
        $boleto = $colectivo->pagarCon($tarjeta);
        $boleto = $colectivo->pagarCon($tarjeta);
        $this->assertEquals(-210, $tarjeta->getSaldo());
        $this->assertEquals(False, $colectivo->pagarCon($tarjeta));
        
    }

    public function testSaldoMenor() {
        $tarjeta = new Tarjeta(150); 
        $colectivo = new Colectivo(132);

        $boleto = $colectivo->pagarCon($tarjeta);
        $boleto = $colectivo->pagarCon($tarjeta);
        $boleto = $colectivo->pagarCon($tarjeta);

        $this->assertLessThan($tarjeta->getSaldo(), -211.84);
    }

    public function testDescuentoPlus() {
        $tarjeta = new Tarjeta(150); 
        $colectivo = new Colectivo(132);

        $boleto = $colectivo->pagarCon($tarjeta);
        $boleto = $colectivo->pagarCon($tarjeta);
        $this->assertEquals(-90, $tarjeta->getSaldo());
        $boleto = $colectivo->pagarCon($tarjeta);
        $this->assertEquals(-210, $tarjeta->getSaldo());
    }

    public function testFanquiciaCompleta() {
        $tarjeta = new FranquiciaCompleta(150); 
        $colectivo = new Colectivo(132);

        $boleto = $colectivo->pagarCon($tarjeta);
        $boleto = $colectivo->pagarCon($tarjeta);
        $boleto = $colectivo->pagarCon($tarjeta);
        $boleto = $colectivo->pagarCon($tarjeta);
        $this->assertEquals(150, $tarjeta->getSaldo());
    }
}
*/