<?php

namespace TrabajoSube;

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
        if ($tarjeta->getSaldo() >= ($this->saldoNegativo + $this->tarifaBasica)) {
            $tarjeta->descontarSaldo($this->tarifaBasica);
            return new Boleto($this->tarifaBasica);
        } else {
            return false;
        }
    }
}
