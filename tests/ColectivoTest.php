<?php 

namespace TrabajoSube;

use PHPUnit\Framework\TestCase;
use TrabajoSube\colectivo;
use TrabajoSube\colectivoIU;
use TrabajoSube\tarjeta;
use TrabajoSube\tarjetaJ;
use TrabajoSube\tarjetaBEG;
use TrabajoSube\tarjetaMB;
use TrabajoSube\Boleto;

class ColectivoTest extends TestCase{
    public function testConstruct() {
        $colectivo = new Colectivo(100);
        $this->assertEquals($colectivo->lineaColectivo, 100);

    }

    public function testPagarCon() {

        // En esta función se va a testear el funcionamiento de pagarCon.

        $colectivo = new colectivo(100);
        $tarjeta = new tarjeta(200);

        $colectivo->pagarCon($tarjeta, 0);
        $this->assertEquals($tarjeta->saldo, 15);
        $colectivo->pagarCon($tarjeta, 0);
        $this->assertEquals($tarjeta->saldo, -170);
        $tarjeta->cargarSaldo(500);
        $this->assertEquals($tarjeta->saldo, -170);
        $colectivo->pagarCon($tarjeta, 0);
        $this->assertEquals($tarjeta->saldo, 145);

        $colectivo->pagarCon($tarjeta, 0);
        $colectivo->pagarCon($tarjeta, 0);
        $colectivo->pagarCon($tarjeta, 0);
        $this->assertFalse($colectivo->pagarCon($tarjeta, 0));
    }

    public function testTransbordos() {

        $colectivo1 = new colectivo(100);
        $colectivo2 = new colectivo(110);
        $tarjeta = new tarjeta(4000);

        // Transbordar 
        $colectivo1->pagarCon($tarjeta, 43200);
        $this->assertEquals($tarjeta->saldo, 3815);
        $this->assertEquals($colectivo2->transBordos($tarjeta, 43200),0);
        $colectivo2->pagarCon($tarjeta, 43200);
        $this->assertEquals($tarjeta->saldo, 3815);

        // Intentar transbordar cuando ya pasó una hora desde el ultimo viaje en colectivo.
        $this->assertEquals($colectivo1->transBordos($tarjeta, 46800),1);
        $colectivo1->pagarCon($tarjeta, 46800);
        $this->assertEquals($tarjeta->saldo, 3630);

        // Intentar transbordar entre colectivos de una misma linea.
        $this->assertEquals($colectivo1->transBordos($tarjeta, 46800),1);
        $colectivo1->pagarCon($tarjeta, 46800);
        $this->assertEquals($tarjeta->saldo, 3445);

        //Intentar transbordar fuera de horario.
        $colectivo1->pagarCon($tarjeta, 86400);
        $this->assertEquals($tarjeta->saldo, 3260);
        $this->assertEquals($colectivo2->transBordos($tarjeta, 86400),1);
        $colectivo2->pagarCon($tarjeta, 86400);
        $this->assertEquals($tarjeta->saldo, 3075);
    }

    public function test5Min() {

        $colectivo = new colectivo(100);
        $tarjeta = new TarjetaMB(4000);

        $colectivo->pagarcon($tarjeta, 0);
        $this->assertFalse($colectivo->verificar5Min($tarjeta,299));
        $this->assertFalse($colectivo->verificar5Min($tarjeta,300));
    }


    public function testDiaYHorario() {

        $colectivo = new colectivo(100);

        $this->assertFalse($colectivo->validarTiempo(0));
        $this->assertTrue($colectivo->validarTiempo(43200));
    }

    public function testDescuentoMes() {

        $colectivo = new colectivo(100);
        $tarjeta = new tarjeta(4000);

        $colectivo->pagarCon($tarjeta, 0); // Mes 0
        $this->assertEquals($tarjeta->viajesRealizados, 1);
        $this->assertEquals($colectivo->aplicarDescuento($tarjeta, 0), 1);
        $tarjeta->viajesRealizados = 40;
        $this->assertEquals($colectivo->aplicarDescuento($tarjeta, 0), 0.8);
        $tarjeta->viajesRealizados = 80;
        $this->assertEquals($colectivo->aplicarDescuento($tarjeta, 0), 0.75);
        $colectivo->pagarCon($tarjeta, 2678400); // Mes 1
        $this->assertEquals($tarjeta->viajesRealizados, 1);
        $this->assertEquals($colectivo->aplicarDescuento($tarjeta, 2678400), 1);
    }

    public function testViajesGratis() {

        $colectivo = new colectivo(100);
        $tarjeta = new tarjetaBEG(4000);

        $colectivo->pagarCon($tarjeta, 43200); //Día 0
        $this->assertEquals($colectivo->viajesGratis($tarjeta, 43200), 0);
        $colectivo->pagarCon($tarjeta, 43200);
        $this->assertEquals($colectivo->viajesGratis($tarjeta, 43200), 1);
        $colectivo->pagarCon($tarjeta, 43200);
        $this->assertEquals($colectivo->viajesGratis($tarjeta, 43200), 1);
        $colectivo->pagarCon($tarjeta, 129600); //Día 1
        $this->assertEquals($tarjeta->viajesHoy, 1);
        $this->assertEquals($colectivo->viajesGratis($tarjeta, 129600), 0);
    }

    public function testColectivoIU() {

        $colectivo = new ColectivoIU(100);
        $tarjeta = new tarjeta(300);

        $colectivo->pagarCon($tarjeta, 0);
        $this->assertEquals($tarjeta->saldo, 0);
    }
}
