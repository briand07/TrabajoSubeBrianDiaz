<?php


namespace TrabajoSube;

use TrabajoSube\Tiempo;

class Boleto {
    private $monto;
    private $fecha;
    private $tipoTarjeta;
    private $lineaColectivo;
    private $totalAbonado;
    private $saldo;
    private $tarjetaID;
    private $saldoNegativoCancelado;

    public function __construct($monto, $fecha, $tipoTarjeta, $lineaColectivo, $totalAbonado, $saldo, $tarjetaID, $saldoNegativoCancelado) {
        $this->monto = $monto;
        $this->fecha = $fecha;
        $this->tipoTarjeta = $tipoTarjeta;
        $this->lineaColectivo = $lineaColectivo;
        $this->totalAbonado = $totalAbonado;
        $this->saldo = $saldo;
        $this->tarjetaID = $tarjetaID;
    }

    public function getMonto() {
        return $this->monto;
    }

    public function getFecha() {
        return $this->fecha;
    }

    public function getTipoTarjeta() {
        return $this->tipoTarjeta;
    }

    public function getLineaColectivo() {
        return $this->lineaColectivo;
    }

    public function getTotalAbonado() {
        return $this->totalAbonado;
    }

    public function getSaldo() {
        return $this->saldo;
    }

    public function getTarjetaID() {
        return $this->tarjetaID;
    }
}