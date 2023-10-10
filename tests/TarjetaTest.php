<?php 

namespace TrabajoSube;

use PHPUnit\Framework\TestCase;
use TrabajoSube\colectivo;
use TrabajoSube\Tarjeta;
use TrabajoSube\Boleto;

class TarjetaTest extends TestCase {

    public function testPagarConSaldoSuficiente() {
        $tarjeta = new Tarjeta(150); // Saldo suficiente
        $colectivo = new Colectivo();

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

}
