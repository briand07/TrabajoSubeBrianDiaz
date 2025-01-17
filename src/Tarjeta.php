<?php

namespace TrabajoSube;

class Tarjeta {
    private $id;
    private $saldo;
    private $saldoSinAcreditar;
    private $ultimoViaje;
    private $viajesHoy;
    private $viajesRealizados = 1;
    protected $tipoTarjeta = "Sin Franquicia";
    private $limiteSaldo = 6600;
    private $cargasAceptadas = [150, 200, 250, 300, 350, 400, 450, 500, 600, 700, 800, 900, 1000, 1100, 1200, 1300, 1400, 1500, 2000, 2500, 3000, 3500, 4000];

    public function __construct($saldoInicial) {
        $this->id = uniqid();
        if (in_array($saldoInicial, $this->cargasAceptadas)) {
            $this->saldo = $saldoInicial;
        } else {
            throw new Exception("Monto de carga no válido");
        }
    }

    public function getId() {
        return $this->id;
    }

    public function getSaldo() {
        return $this->saldo;
    }

    public function getUltimoViaje() {
        return $this->ultimoViaje;
    }

    public function getSaldoSinAcreditar() {
        return $this->saldoSinAcreditar;
    }

    public function getViajesHoy() {
        return $this->viajesHoy;
    }

    public function setUltimoViaje() {
        $this->ultimoViaje = time();
    }

    public function resetViajesHoy() {
        $this->viajesHoy = 0;
    }

    public function sumarViaje() {
        $this->viajesHoy += 1;
    }

    public function descontarSaldo($monto) {
        $this->saldo -= $monto;
        $this->viajesRealizados++;
    }

    public function cargarSaldo($monto) {
        if (in_array($monto, $this->cargasAceptadas)) {
            $this->saldoSinAcreditar += $monto;
        }
    }

    public function acreditarSaldo(){
        if ($this->saldoSinAcreditar > 0) {
            if ($this->saldo + $this->saldoSinAcreditar > $this->limiteSaldo) {
                return $this->limiteSaldo - $this->saldo;
                $this->saldo = $this->limiteSaldo;
                $this->saldoSinAcreditar = $this->saldo + $this->saldoSinAcreditar - $this->limiteSaldo;
            }
            else {
                $this->saldo + $this->saldoSinAcreditar;
                return $this->getSaldoSinAcreditar;
                $this->saldoSinAcreditar = 0;
            }
        }
    }

    public function resetearViajes()
    {
        $diaDelMes = date('j');
        if ($diaDelMes === '1') {
            $this->viajesRealizados = 1;
        }
    }

    public function multiplicadorPrecio() {
        $this->resetearViajes();
        if ($this->viajesRealizados >= 1 && $this->viajesRealizados <= 29) {
            return 1;
        } elseif ($this->viajesRealizados >= 30 && $this->viajesRealizados <= 79) {
            return 0.8; 
        } else {
            return 0.75; 
        }
    }
}

class FranquiciaParcial extends Tarjeta {
    public function __construct($saldoInicial) {
        parent::__construct($saldoInicial);
        $this->tipoTarjeta = "Franquicia Parcial";
    }

    public function multiplicadorPrecio() {
        if (date('N') >= 1 && date('N') <= 5 && $horaActual >= 6 && $horaActual < 22) {
            return 0.5;
        }
        else{
            return 1;
        }
    }
}

class FranquiciaCompleta extends Tarjeta {
    public function __construct($saldoInicial) {
        parent::__construct($saldoInicial);
        $this->tipoTarjeta = "Franquicia Completa";
    }

    public function multiplicadorPrecio() {
    if (date('N') >= 1 && date('N') <= 5 && $horaActual >= 6 && $horaActual < 22) {
        if (floor(time()/86400) == floor($tarjeta->getUltimoViaje()/86400) && $tarjeta->getviajesHoy >= 2) {
            return 1;
        }
        if(floor(time()/86400) > floor($tarjeta->getUltimoViaje()/86400))
        {
            resetViajesHoy();
            return 0;
        }
        else {
            return 0;
}
        }
        else{
            return 1;
        }
    }
}