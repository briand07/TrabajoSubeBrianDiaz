<?php

namespace TrabajoSube;

class Colectivo {
    private $tarifaBasica = 120;

    public function pagarCon(Tarjeta $tarjeta) {
        if ($tarjeta->getSaldo() >= $this->tarifaBasica) {
            $tarjeta->descontarSaldo($this->tarifaBasica);
            return new Boleto($this->tarifaBasica);
        } else {
            echo "Saldo insuficiente";
            return null;
        }
    }
}
