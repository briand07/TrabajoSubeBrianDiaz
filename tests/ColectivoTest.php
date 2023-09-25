<?php 

namespace TrabajoSube;

use PHPUnit\Framework\TestCase;

use TrabajoSube;

class ColectivoTest extends TestCase{

    public function testGetlinea(){
        $cole = new Colectivo(103);
        $this->assertEquals($cole->getLinea(), 103);
    }
}