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

        $tarjeta->cargarSaldo(150);
        $this->assertEquals($tarjeta->saldoSinAcreditar, 150);
    }

    public function testAcreditarSaldo() {
        $tarjeta = new Tarjeta(150);
        $this->assertEquals($tarjeta->saldo,150);

        $tarjeta->cargarSaldo(150);
        $tarjeta->acreditarSaldo();
        $this->assertEquals($tarjeta->saldo, 300);
    }

    public function testFranquicias() {

        $colectivo = new colectivo(110);
        $tarjeta = new Tarjeta(4000);
        $tarjetaBEG = new TarjetaBEG(4000);
        $tarjetaJubilados = new TarjetaJ(4000);
        $tarjetaMBE = new TarjetaMB(4000);

        $colectivo->pagarCon($tarjeta, 0);
        $this->assertEquals($tarjeta->saldo, 3815);
        $tarjeta->viajesRealizados = 30;
        $colectivo->pagarCon($tarjeta, 0);
        $this->assertEquals($tarjeta->saldo, 3667);
        $tarjeta->viajesRealizados = 80;
        $colectivo->pagarCon($tarjeta, 0);
        $this->assertEquals($tarjeta->saldo, 3528.25);
        $colectivo->pagarCon($tarjeta, 2678400);
        $this->assertEquals($tarjeta->saldo, 3343.25);
    }
}
