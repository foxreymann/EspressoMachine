<?php

require 'EspressoMachine.php';

class EspressoMachineTest extends PHPUnit_Framework_TestCase
{
    public function testSettingTwoLiterWaterContainer() {
        $machine = new EspressoMachine();
        $contrainer = new WaterContainerImplementation(2); 
        $machine->setWaterContainer($contrainer);
        $this->assertEquals(2,$machine->getWater()); 
    }

    public function testIfMakeEspressoReturnAmountOfCoffeeMade() {
        $machine = new EspressoMachine();
        $contrainer = new WaterContainerImplementation(2); 
        $machine->setWaterContainer($contrainer);
        $this->assertEquals(0.05,$machine->makeEspresso());
    } 

    public function testIfMakeDoubleEspressoReturnAmountOfCoffeeMade() {
        $machine = new EspressoMachine();
        $contrainer = new WaterContainerImplementation(2); 
        $machine->setWaterContainer($contrainer);
        $this->assertEquals(0.1,$machine->makeDoubleEspresso());
    } 

    /*
    public function testUsingWater() {
        $contrainer = new WaterContainerImplementation(10); 
        $this->assertEquals(2,$machine->getWater()); 
    }    
    */
}
