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

    public function pagarCon(Tarjeta $tarjeta, $tiempo) {
        $saldoPrevio = $tarjeta->saldo;
        $totalAbonado = $tarjeta->acreditarSaldo();
        $nuevoSaldo = $tarjeta->saldo;
    
        // Verificar el tipo de tarjeta
        switch ($tarjeta->tipoTarjeta) {
            case 'N':
                // Lógica para tarjeta Normal
                if ($tarjeta->saldo >= $this->saldoNegativo + $this->tarifaBasica) {
                    $tarifaNormal = $this->tarifaBasica * $this->aplicarDescuento($tarjeta->viajesRealizados);
                    if(date('Y-m', $tarjeta->ultimoViaje) === date('Y-m', $tiempo)){
                        $tarjeta->viajesRealizados++;
                    } else {
                        $tarjeta->viajesRealizados = 1;
                    }
                    $tarjeta->saldo -= $tarifaNormal;
                    $tarjeta->ultimoViaje = $tiempo;
                    
                } else {
                    // Lógica para caso no válido (fuera de tiempo o saldo insuficiente)
                    throw new Exception("No se puede realizar el viaje con la tarjeta normal en este momento.");
                }
                break;
            case 'MB':
                // Lógica para tarjeta Medio Boleto
                if ($this->validarTiempo($tiempo) && $this->verificar5Min($tiempo, $tarjeta->ultimoViaje) && $tarjeta->saldo >= $this->saldoNegativo + $this->tarifaBasica) {
                    $tarjeta->saldo -= $this->tarifaBasica * 0.5;
                    $tarjeta->ultimoViaje = $tiempo;
                } else {
                    // Lógica para caso no válido (fuera de tiempo, menos de 5 minutos desde el último viaje o saldo insuficiente)
                    throw new Exception("No se puede realizar el viaje con medio boleto en este momento.");
                }
                break;
            case 'J':
                // Lógica para tarjeta Jubilados
                $descuentoMultiplicador = $this->viajesGratis($tarjeta, $tiempo);
                $tarifaFC = $this->tarifaBasica * $descuentoMultiplicador;
            
                if ($this->validarTiempo($tiempo) && $tarjeta->saldo >= $this->saldoNegativo + $tarifaFC) {
                    $tarjeta->saldo -= $tarifaFC;
                    $tarjeta->viajesHoy++;
                    $tarjeta->ultimoViaje = $tiempo;
                    //return new boleto($tarifaFC, $tiempo, $tarjeta->tipoTarjeta, $this->lineaColectivo, $totalAbonado, $tarjeta->saldo, $tarjeta->id, $saldoNegativoCancelado);

                } else {
                    // Lógica para caso no válido (fuera de tiempo o saldo insuficiente)
                    throw new Exception("No se puede realizar el viaje con la tarjeta de jubilado en este momento.");
                }
                break;
            case 'EG':
                // Lógica para tarjeta Estudiantil Gratuito
                $descuentoMultiplicador = $this->viajesGratis($tarjeta, $tiempo);
                $tarifaFC = $this->tarifaBasica * $descuentoMultiplicador;
            
                if ($this->validarTiempo($tiempo) && $tarjeta->saldo >= $this->saldoNegativo + $tarifaFC) {
                    $tarjeta->saldo -= $tarifaFC;
                    $tarjeta->viajesHoy++;
                    $tarjeta->ultimoViaje = $tiempo;
                    //return new boleto($tarifaFC, $tiempo, $tarjeta->tipoTarjeta, $this->lineaColectivo, $totalAbonado, $tarjeta->saldo, $tarjeta->id, $saldoNegativoCancelado);

                } else {
                    // Lógica para caso no válido (fuera de tiempo o saldo insuficiente)
                    throw new Exception("No se puede realizar el viaje con la tarjeta estudiantil gratuito en este momento.");
                }
                break;
            default:
                // Tipo de tarjeta no reconocido
                throw new Exception("Tipo de tarjeta no válido");
        }
    }
    

    function verificar5Min($tiempo, $ultimoViaje) {
    
        // Calcular la diferencia en minutos entre el tiempo actual y el último viaje
        $diferenciaMinutos = ($tiempo - $ultimoViaje) / 60;
    
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
            if ($tarjeta->viajesHoy >= 1) {
                $tarjeta->viajesHoy -= 1;
                return 0;//Para multiplicar la tarifa por 0
            } else {
                return 1;
            }
        }
        else{
            return 0;
        }
    }

    function aplicarDescuento($viajesEnElMes) {
        if ($viajesEnElMes >= 30 && $viajesEnElMes < 80) {
            return 0.8; // Descuento del 20%
        } elseif ($viajesEnElMes >= 80) {
            return 0.75; // Descuento del 25%
        } else {
            return 1; // Sin descuento
        }
    }
}

