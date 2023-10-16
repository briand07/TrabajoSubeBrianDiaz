<?php

namespace TrabajoSube;

use TrabajoSube\Tiempo;

class Colectivo {
    private $tarifaBasica = 120;
    private $saldoNegativo = -211.84;
    private $lineaColectivo;

    public function __construct($lineaColectivo) {
        $this->lineaColectivo = $lineaColectivo;
    }

    public function getLinea() {
        return $this->LineaColectivo;
    }

    public function pagarCon(Tarjeta $tarjeta) {
        $multiplicadorPrecio = $tarjeta->multiplicadorPrecio();
        $saldoPrevio = $tarjeta->getSaldo;
        $totalAbonado = $tarjeta->acreditarsaldo();
        $nuevoSaldo = $tarjeta->getSaldo;
        if($saldoPrevio < 0 && $nuevoSaldo >= 0) {
            $saldoNegativoCancelado = true;
        }
        else {
            $saldoNegativoCancelado = false;
        }
        if ($tarjeta->getSaldo() >= ($this->saldoNegativo + $this->tarifaBasica * $multiplicadorPrecio)) {
            $tarjeta->descontarSaldo($this->tarifaBasica * $multiplicadorPrecio);
            return new Boleto($this->tarifaBasica, time(), $tarjeta->getTipotarjeta, $this->lineaColectivo, $totalAbonado, $tarjeta->getSaldo, $tarjeta->getId, $saldoNegativoCancelado);
        } else {
            return false;
        }
    }
}
