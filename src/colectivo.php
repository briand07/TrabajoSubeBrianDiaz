<?php

namespace TrabajoSube;

use Exception;
use TrabajoSube\Tiempo;

class Colectivo {
    public $tarifaBasica = 185;
    public $saldoNegativo = -333;
    public $lineaColectivo;

    public function __construct($lineaColectivo) {
        $this->lineaColectivo = $lineaColectivo;
    }

    public function pagarCon($tarjeta, $tiempo) {
        $saldoPrevio = $tarjeta->saldo;
        $totalAbonado = $tarjeta->acreditarSaldo();
        $nuevoSaldo = $tarjeta->saldo;
        
        // Verificar el tipo de tarjeta
        switch ($tarjeta->tipoTarjeta) {
            case 'Normal':
                // Lógica para tarjeta Normal
                $tarifaNormal = $this->tarifaBasica * $this->aplicarDescuento($tarjeta,$tiempo) * $this->transBordos($tarjeta, $tiempo);
                if ($tarjeta->saldo >= $this->saldoNegativo + $tarifaNormal) {
                    $tarjeta->ultimaLinea = $this->lineaColectivo;
                    $tarjeta->viajesRealizados++;
                    $tarjeta->saldo -= $tarifaNormal;
                    $tarjeta->ultimoViaje = $tiempo;
                    
                    if ($saldoPrevio < 0 && $tarjeta->saldo > 0) {
                        $saldoNegativoCancelado = true;
                    }
                    else {
                        $saldoNegativoCancelado = false;
                    }

                    return new boleto($tarifaNormal, $tiempo, $tarjeta->tipoTarjeta, $this->lineaColectivo, $totalAbonado, $tarjeta->saldo, $tarjeta->id, $saldoNegativoCancelado);
                } else {
                    // Lógica para caso no válido (fuera de tiempo o saldo insuficiente)
                    return false;
                }
            case 'Medio Boleto':
                // Lógica para tarjeta Medio Boleto
                if ($this->validarTiempo($tiempo) && $this->verificar5Min($tarjeta, $tiempo) && $tarjeta->saldo >= $this->saldoNegativo + $this->tarifaBasica * 0.5 * $this->transBordos($tarjeta, $tiempo)) {
                    $tarjeta->ultimaLinea = $this->lineaColectivo;
                    $tarjeta->saldo -= $this->tarifaBasica * 0.5 * $this->transBordos($tarjeta, $tiempo);
                    $tarjeta->ultimoViaje = $tiempo;
                    if ($saldoPrevio < 0 && $tarjeta->saldo > 0) {
                        $saldoNegativoCancelado = true;
                    }
                    else {
                        $saldoNegativoCancelado = false;
                    }
                    return new boleto($this->tarifaBasica * 0.5 * $this->transBordos($tarjeta, $tiempo), $tiempo, $tarjeta->tipoTarjeta, $this->lineaColectivo, $totalAbonado, $tarjeta->saldo, $tarjeta->id, $saldoNegativoCancelado);

                } else {
                    // Lógica para caso no válido (fuera de tiempo, menos de 5 minutos desde el último viaje o saldo insuficiente)
                    return false;
                }
            case 'Jubilados':
                // Lógica para tarjeta Jubilados
            
                if ($this->validarTiempo($tiempo)) {
                    $saldoNegativoCancelado = false;
                    //return new boleto($tarifaFC, $tiempo, $tarjeta->tipoTarjeta, $this->lineaColectivo, $totalAbonado, $tarjeta->saldo, $tarjeta->id, $saldoNegativoCancelado);

                } else {
                    // Lógica para caso no válido (fuera de tiempo o saldo insuficiente)
                    return false;
                }
            case 'Boleto Educativo Gratuito':
                // Lógica para tarjeta Estudiantil Gratuito
                $tarjeta->ultimaLinea = $this->lineaColectivo;
                $descuentoMultiplicador = $this->viajesGratis($tarjeta, $tiempo);
                $tarifaFC = $this->tarifaBasica * $descuentoMultiplicador * $this->transBordos($tarjeta, $tiempo);
            
                if ($this->validarTiempo($tiempo) && $tarjeta->saldo >= $this->saldoNegativo + $tarifaFC) {
                    $tarjeta->saldo -= $tarifaFC;
                    $tarjeta->viajesHoy += 1;
                    $tarjeta->ultimoViaje = $tiempo;
                    if ($saldoPrevio < 0 && $tarjeta->saldo > 0) {
                        $saldoNegativoCancelado = true;
                    }
                    else {
                        $saldoNegativoCancelado = false;
                    }
                    return new boleto($tarifaFC, $tiempo, $tarjeta->tipoTarjeta, $this->lineaColectivo, $totalAbonado, $tarjeta->saldo, $tarjeta->id, $saldoNegativoCancelado);
                } else {
                    // Lógica para caso no válido (fuera de tiempo o saldo insuficiente)
                    return false;
                }
            default:
                // Tipo de tarjeta no reconocido
                throw new Exception("Tipo de tarjeta no válido");
        }
    }
    

    function verificar5Min($tarjeta, $tiempo) {

        // Calcular la diferencia en minutos entre el tiempo actual y el último viaje
        $diferenciaMinutos = ($tiempo - $tarjeta->ultimoViaje) / 60;

        // Verificar si han pasado más de 5 minutos
        if ($diferenciaMinutos > 5) {
            return true;
        } else {
            return false;
        }
    }

    function validarTiempo($tiempo) {
        $diaSemana = date('N', $tiempo); // Obtener el día de la semana (1=lunes, 2=martes, ..., 7=domingo)
        $hora = date('G', $tiempo); // Obtener la hora del día (formato de 24 horas)
    
        // Verificar si es de lunes a viernes y la hora está entre 6 y 22
        if ($diaSemana >= 1 && $diaSemana <= 5 && $hora >= 6 && $hora <= 22) {
            return true;
        } else {
            return false;
        }
    }

    function viajesGratis($tarjeta, $tiempo) {
        // Verificar si hay al menos un viaje gratis disponible
        if(date('Y-m-d', $tarjeta->ultimoViaje) === date('Y-m-d', $tiempo)){
            if ($tarjeta->viajesHoy <= 1) {
                return 0;//Para multiplicar la tarifa por 0
            } else {
                return 1;
            }
        }
        else{
            $tarjeta->viajesHoy = 0;
            return 0;
        }
    }

    function aplicarDescuento($tarjeta, $tiempo) {
        if(date('Y-m', $tarjeta->ultimoViaje) === date('Y-m', $tiempo)){
            if ($tarjeta->viajesRealizados >= 30 && $tarjeta->viajesRealizados < 80) {
                return 0.8; // Descuento del 20%
            } elseif ($tarjeta->viajesRealizados >= 80) {
                return 0.75; // Descuento del 25%
            } else {
                return 1; // Sin descuento
            }
        }
        else{
            $tarjeta->viajesRealizados = 0;
            return 1;
        }
    }

    function transBordos($tarjeta, $tiempo){
        $diaSemana = date('N', $tiempo); 
        $hora = date('G', $tiempo); 
    
        // Verificar si es de lunes a sabado y la hora está entre 7 y 22
        if ($diaSemana >= 1 && $diaSemana <= 6 && $hora >= 7 && $hora <= 22) {
            $horario = true;
        } else {
            return 1;
        }

        $diferenciaMinutos = ($tiempo - $tarjeta->ultimoViaje) / 60;
        // Verificar si han pasado menos de 1 hora
        if ($diferenciaMinutos < 60) {
            $hora = true;
        } else {
            return 1;
        }
        //verificar si la linea es otra
        if($tarjeta->ultimaLinea != $this->lineaColectivo && $tarjeta->ultimaLinea != null){
            $linea = true;
        }
        else{
            return 1;
        }

        if($horario && $hora && $linea){
            return 0;
        }
        else{
            return 1;
        }
    }
}

