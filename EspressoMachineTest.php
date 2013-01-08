<?php

require 'EspressoMachine.php';

class EspressoMachineTest extends PHPUnit_Framework_TestCase
{
    public function testSetting2LiterWaterContainer() {
        $contrainer = new WaterContainerImplementation(2); 
        $machine = new EspressoMachine();
        $machine->setWaterContainer($contrainer);
        $this->assertEquals(2,$machine->getWater()); 
    }
}
