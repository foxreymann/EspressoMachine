<?php

require 'EspressoMachine.php';

class EspressoMachineTest extends PHPUnit_Framework_TestCase
{
    public function testSettingTwoLiterWaterContainer() {
        $machine = new EspressoMachine();
        $machine->addWater(2000);
        $this->assertEquals(2000,$machine->getWater()); 
    }

    public function testIfMakeEspressoReturnAmountOfCoffeeMade() {
        $machine = new EspressoMachine();
        $machine->addWater(2000);
        $this->assertEquals(0.05,$machine->makeEspresso());
    } 

    public function testIfMakeDoubleEspressoReturnAmountOfCoffeeMade() {
        $machine = new EspressoMachine();
        $machine->addWater(2000);
        $this->assertEquals(0.1,$machine->makeDoubleEspresso());
    } 

    public function testUsingWater() {
        $machine = new EspressoMachine();
        $machine->addWater(2000);
        $machine->useWater(1500);
        $this->assertEquals(500,$machine->getWater()); 
    }    

    public function testAddingWater() {
        $machine = new EspressoMachine();
        $contrainer = new WaterContainerImplementation(10000); 
        $machine->setWaterContainer($contrainer);
        $machine->addWater(10000);
        $machine->useWater(1500);
        $machine->addWater(1000);
        $this->assertEquals(9500,$machine->getWater()); 
    }    

    public function testDescaleNeededException() {
        $machine = new EspressoMachine();
        $contrainer = new WaterContainerImplementation(10000); 
        $machine->setWaterContainer($contrainer);
        $machine->addWater(10000);
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
        $machine->addWater(1000);
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
        $contrainer = new WaterContainerImplementation(10000); 
        $machine->setWaterContainer($contrainer);
        $machine->addWater(10000); 
       for($i = 0; $i < 50; $i++) {
            $machine->makeDoubleEspresso();
        }        
        $this->assertEquals(true,$machine->needsDescaling());
        $machine->descale();
        $this->assertEquals(false,$machine->needsDescaling());
    } 

    public function testDescalingUses1LitreOfWater() {
        $machine = new EspressoMachine();
        $contrainer = new WaterContainerImplementation(10000); 
        $machine->setWaterContainer($contrainer);
        $machine->addWater(10000);
        $machine->descale();
        $this->assertEquals(9000,$machine->getWater());
    } 

}
