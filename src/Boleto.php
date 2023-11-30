<?php


namespace TrabajoSube;

use TrabajoSube\Tiempo;

class Boleto {
    public $monto;
    public $fecha;
    public $tipoTarjeta;
    public $lineaColectivo;
    public $totalAbonado;
    public $saldo;
    public $tarjetaID;
    public $saldoNegativoCancelado;

    public function __construct($monto, $fecha, $tipoTarjeta, $lineaColectivo, $totalAbonado, $saldo, $tarjetaID, $saldoNegativoCancelado) {
        $this->monto = $monto;
        $this->fecha = $fecha;
        $this->tipoTarjeta = $tipoTarjeta;
        $this->lineaColectivo = $lineaColectivo;
        $this->totalAbonado = $totalAbonado;
        $this->saldo = $saldo;
        $this->tarjetaID = $tarjetaID;
        $this->$saldoNegativoCancelado = $saldoNegativoCancelado;
    }

}