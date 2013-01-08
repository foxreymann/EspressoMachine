<?php

require 'EspressoMachine.php';

class EspressoMachineTest extends PHPUnit_Framework_TestCase
{
    public function testSettingTwoLiterWaterContainer() {
        $machine = new EspressoMachine();
        $machine->addWater(2);
        $this->assertEquals(2,$machine->getWater()); 
    }

    public function testIfMakeEspressoReturnAmountOfCoffeeMade() {
        $machine = new EspressoMachine();
        $machine->addWater(2);
        $this->assertEquals(0.05,$machine->makeEspresso());
    } 

    public function testIfMakeDoubleEspressoReturnAmountOfCoffeeMade() {
        $machine = new EspressoMachine();
        $machine->addWater(2);
        $this->assertEquals(0.1,$machine->makeDoubleEspresso());
    } 

    public function testUsingWater() {
        $machine = new EspressoMachine();
        $machine->addWater(2);
        $machine->useWater(1.5);
        $this->assertEquals(0.5,$machine->getWater()); 
    }    

    public function testAddingWater() {
        $machine = new EspressoMachine();
        $contrainer = new WaterContainerImplementation(10); 
        $machine->setWaterContainer($contrainer);
        $machine->addWater(10);
        $machine->useWater(1.5);
        $machine->addWater(1);
        $this->assertEquals(9.5,$machine->getWater()); 
    }    

    public function testDescaleNeededException() {
        $machine = new EspressoMachine();
        $contrainer = new WaterContainerImplementation(10); 
        $machine->setWaterContainer($contrainer);
        $machine->addWater(10);
        for($i = 0; $i < 50; $i++) {
            $machine->makeDoubleEspresso();
        }        
        try {
            $machine->makeDoubleEspresso();
        }
        catch (DescaleNeededException $expected) {
            return;
        }
        $this->fail('An expected exception has not been raised.');
    }

    public function testNoWaterException() {
        $machine = new EspressoMachine();
        $machine->addWater(1);
        for($i = 0; $i < 10; $i++) {
            $machine->makeDoubleEspresso();
        }        
        try {
            $machine->makeDoubleEspresso();
        }
        catch (NoWaterException $expected) {
            return;
        }
        $this->fail('An expected exception has not been raised.');
    }

    public function testDescaling() {
        $machine = new EspressoMachine();
        $contrainer = new WaterContainerImplementation(10); 
        $machine->setWaterContainer($contrainer);
        $machine->addWater(10); 
       for($i = 0; $i < 50; $i++) {
            $machine->makeDoubleEspresso();
        }        
        $this->assertEquals(true,$machine->needsDescaling());
        $machine->descale();
        $this->assertEquals(false,$machine->needsDescaling());
    } 

    public function testDescalingUses1LitreOfWater() {
        $machine = new EspressoMachine();
        $contrainer = new WaterContainerImplementation(10); 
        $machine->setWaterContainer($contrainer);
        $machine->addWater(10);
        $machine->descale();
        $this->assertEquals(9,$machine->getWater());
    } 

    public function testAddingFiftyBeans() {
        $machine = new EspressoMachine();
        $machine->addBeans(50);
        $this->assertEquals(50,$machine->getBeans()); 
    }
}
