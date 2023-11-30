<?php

namespace TrabajoSube;
use Exception;

class Tarjeta {
    public $id;
    public $saldo;
    public $saldoSinAcreditar;
    public $ultimoViaje;
    public $viajesHoy;
    public $viajesRealizados = 1;
    public $tipoTarjeta = "Normal";
    public $limiteSaldo = 6600;
    public $cargasAceptadas = [0 ,150, 200, 250, 300, 350, 400, 450, 500, 600, 700, 800, 900, 1000, 1100, 1200, 1300, 1400, 1500, 2000, 2500, 3000, 3500, 4000];

    public function __construct($saldoInicial) {
        $this->id = uniqid();
        if (in_array($saldoInicial, $this->cargasAceptadas)) {
            $this->saldo = $saldoInicial;
        } else {
            throw new Exception("Monto de carga no válido");
        }
    }

    public function cargarSaldo($monto) {
        if (in_array($monto, $this->cargasAceptadas)) {
            $this->saldoSinAcreditar += $monto;
        }
        else{
            throw new Exception("Monto de carga no válido");
        }
    }

    public function acreditarSaldo(){
        $saldoAcreditado = 0;
        if ($this->saldoSinAcreditar > 0) {
            if ($this->saldo + $this->saldoSinAcreditar >= $this->limiteSaldo) {
                $saldoAcreditado = $this->limiteSaldo - $this->saldo;
                $this->saldo = $this->limiteSaldo;
                $this->saldoSinAcreditar = $this->saldo + $this->saldoSinAcreditar - $this->limiteSaldo;
            }
            else {
                $saldoAcreditado = $this->saldoSinAcreditar;
                $this->saldo += $this->saldoSinAcreditar;
                $this->saldoSinAcreditar = 0;
            }
        }
        return $saldoAcreditado;
    }
}

