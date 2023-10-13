<?php

namespace TrabajoSube;

class Colectivo {
    private $tarifaBasica = 120;

    public function pagarCon(Tarjeta $tarjeta) {
        if ($tarjeta->getSaldo() >= (-211.84 + $this->tarifaBasica)) {
            $tarjeta->descontarSaldo($this->tarifaBasica);
            return new Boleto($this->tarifaBasica);
        } else {
            return false;
        }
    }
}
