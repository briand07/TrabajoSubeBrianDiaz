<?php 

namespace TrabajoSube;

use Exception;
use PHPUnit\Framework\TestCase;
use TrabajoSube\colectivo;
use TrabajoSube\Tarjeta;
use TrabajoSube\Boleto;

class TarjetaTest extends TestCase {

    public function testCargarSaldo() {
        $tarjeta = new Tarjeta(150);
        $this->assertEquals($tarjeta->saldo,150);

        $this->expectException(Exception::class);
        $tarjeta = new Tarjeta(123);

        $this->expectException(Exception::class);
        $this->assertFalse($tarjeta->cargarSaldo(123));
    }
}
