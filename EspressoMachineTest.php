<?php

require 'EspressoMachine.php';

class EspressoMachineTest extends PHPUnit_Framework_TestCase
{
    public function testSettingTwoLiterWaterContainer() {
        $machine = new EspressoMachine();
        $machine->addWater(2);
        $machine->addBeans(50);
        $this->assertEquals(2,$machine->getWater()); 
    }

    public function testIfMakeEspressoReturnAmountOfCoffeeMade() {
        $machine = new EspressoMachine();
        $machine->addWater(2);
        $machine->addBeans(50);
        $this->assertEquals(0.05,$machine->makeEspresso());
    } 

    public function testIfMakeDoubleEspressoReturnAmountOfCoffeeMade() {
        $machine = new EspressoMachine();
        $machine->addWater(2);
        $machine->addBeans(50);
        $this->assertEquals(0.1,$machine->makeDoubleEspresso());
    } 

    public function testUsingWater() {
        $machine = new EspressoMachine();
        $machine->addWater(2);
        $machine->addBeans(50);
        $machine->useWater(1.5);
        $this->assertEquals(0.5,$machine->getWater()); 
    }    

    public function testAddingWater() {
        $machine = new EspressoMachine();
        $contrainer = new WaterContainerImplementation(10); 
        $machine->setWaterContainer($contrainer);
        $machine->addWater(10);
        $machine->addBeans(50);
        $machine->useWater(1.5);
        $machine->addWater(1);
        $this->assertEquals(9.5,$machine->getWater()); 
    }    

    public function testDescaleNeededException() {
        $machine = new EspressoMachine();
        $contrainer = new WaterContainerImplementation(10); 
        $machine->setWaterContainer($contrainer);
        $machine->addWater(10);
        $machine->addBeans(50);
        for($i = 0; $i < 50; $i++) {
            $machine->makeDoubleEspresso();
            $machine->addBeans(2);
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
        $machine->addBeans(50);
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
        $machine->addBeans(50);
       for($i = 0; $i < 50; $i++) {
            $machine->makeDoubleEspresso();
            $machine->addBeans(2);
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
        $machine->addBeans(50);
        $machine->descale();
        $this->assertEquals(9,$machine->getWater());
    } 

    public function testAddingFiftyBeans() {
        $machine = new EspressoMachine();
        $machine->addBeans(50);
        $this->assertEquals(50,$machine->getBeans()); 
    }

    public function testNoBeansException() {
        $machine = new EspressoMachine();
        $machine->addWater(2);
        $machine->addBeans(20);
        for($i = 0; $i < 10; $i++) {
            $machine->makeDoubleEspresso();
        }        
        try {
            $machine->makeDoubleEspresso();
        }
        catch (NoBeansException $expected) {
            return;
        }
        $this->fail('An expected exception has not been raised.');
    }

    public function testDescalingNoWaterException() {
        $machine = new EspressoMachine();
        $machine->addBeans(20);
        try {
            $machine->descale();
        }
        catch (NoWaterException $expected) {
            return;
        }
        $this->fail('An expected exception has not been raised.');
         
    }

    public function testContainerFullExceptionWhenAddingWater() {
        $machine = new EspressoMachine(); 
        try {
            $machine->addWater(3); 
        }
        catch (ContainerFullException $expected) {
            return;
        }
        $this->fail('An expected exception has not been raised.');
    }

}
