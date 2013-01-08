<?php

require 'EspressoMachine.interface.php';

error_reporting(-1);

class EspressoMachine implements EspressoMachineInterface
{
    private $waterContainer;
    private $beansContainer;
    private $amountOfCofeeMadeInMl = 0;
    private $needsDescaling = false;


    public function __construct() {
        $waterContrainer = new WaterContainerImplementation(2000); 
        $this->setWaterContainer($waterContrainer);
        $beansContrainer = new BeansContainerImplementation(50); 
        $this->setBeansContainer($beansContrainer);
    }

    /**
    * Runs the process to descale the machine
    * so the machine can be used make coffee
    * uses 1 litre of water
    *
    * @throws NoWaterException
    *
    * @return void
    */
    public function descale() {
        $this->needsDescaling = false;
        $this->waterContainer->useWater(1000);
    }

    /**
    * Runs the process for making Espresso
    *
    * @throws DescaleNeededException, NoBeansException, NoWaterException
    *
    * @return float of litres of coffee made
    */
    public function makeEspresso() {
        return $this->makeCoffee(50,1);
    }

    /**
    * @see makeEspresso
    * @throws DescaleNeededException, NoBeansException, NoWaterException
    *
    * @return float of litres of coffee made
    */
    public function makeDoubleEspresso() {
        return $this->makeCoffee(100,2);
    }

    private function makeCoffee($waterAmount,$beansAmount) {
        if($this->needsDescaling()) {
           throw new DescaleNeededException(); 
        }

        if(($this->amountOfCofeeMadeInMl / 5000) < intval(($this->amountOfCofeeMadeInMl + $waterAmount) / 5000)) {
            $this->needsDescaling = true;
        }
        $this->amountOfCofeeMadeInMl+=$waterAmount;

        if($this->waterContainer->getWater() - $waterAmount < 0) {
            throw new NoWaterException();
        }

        if($this->beansContainer->getBeans() - $beansAmount < 0) {
            throw new NoBeansException();
        }

        $this->waterContainer->useWater($waterAmount);
        return $this->amountOfCofeeMadeInMl / 1000; 
    }

    /**
    * This method controls what is displayed on the screen of the machine
    * Returns ONE of the following human readable statuses in the following preference order:
    *
    * Descale needed
    * Add beans and water
    * Add beans
    * Add water
    * {Integer} Espressos left
    *
    * Please note you should return "Add water" if the machine needs descaling and doesn't have enough water
    *
    * @return string
    */
    public function getStatus() {}

    public function needsDescaling() {
        return $this->needsDescaling;
    }

    /**
    * @param BeansContainer $container
    */
    public function setBeansContainer(BeansContainer $container) {
        $this->beansContainer = $container;
    }

    /**
    * @return BeansContainer
    */
    public function getBeansContainer() {}

    /**
    * @param WaterContainer $container
    */
    public function setWaterContainer(WaterContainer $container) {
        $this->waterContainer = $container;
    }

    /**
    * @return WaterContainer
    */
    public function getWaterContainer() {}

    /**
    * Adds water to the coffee machine's water tank
    *
    * @param float $litres
    * @throws ContainerFullException, EspressoMachineContainerException
    *
    * @return void
    */
    public function addWater($liters) {
        $this->waterContainer->addWater($liters * 1000);
    }

    /**
    * Use $litres from the container
    *
    * @throws EspressoMachineContainerException
    * @param float $litres
    * @return integer
    */
    public function useWater($litres) {
        $this->waterContainer->useWater($litres * 1000);
    }

    /**
    * Returns the volume of water left in the container
    *
    * @return float number of litres
    */

    public function getWater() {
        return $this->waterContainer->getWater() / 1000;
    }

    /**
    * Adds beans to the container
    *
    * @param integer $numSpoons number of spoons of beans
    * @throws ContainerFullException, EspressoMachineContainerException
    *
    * @return void
    */
    public function addBeans($numSpoons) {
        $this->beansContainer->addBeans($numSpoons);
    }

    /**
    * Get $numSpoons from the container
    *
    * @throws EspressoMachineContainerException
    * @param integer $numSpoons number of spoons of beans
    * @return integer
    */
    public function useBeans($numSpoons) {
        $this->beansContainer->useBeans($numSpoons);
    }

    /**
    * Returns the number of spoons of beans left in the container
    *
    * @return integer
    */
    public function getBeans() {
        return $this->beansContainer->getBeans();
    }
}

class BeansContainerImplementation extends Container implements BeansContainer
{
    /**
    * Adds beans to the container
    *
    * @param integer $numSpoons number of spoons of beans
    * @throws ContainerFullException, EspressoMachineContainerException
    *
    * @return void
    */
    public function addBeans($numSpoons) {
        $this->add($numSpoons);
    }

    /**
    * Get $numSpoons from the container
    *
    * @throws EspressoMachineContainerException
    * @param integer $numSpoons number of spoons of beans
    * @return integer
    */
    public function useBeans($numSpoons) {
        $this->used($numSpoons);
    }

    /**
    * Returns the number of spoons of beans left in the container
    *
    * @return integer
    */
    public function getBeans() {
        return $this->get();
    }

}

class WaterContainerImplementation extends Container implements WaterContainer
{
    /**
    * Adds water to the coffee machine's water tank
    *
    * @param float $litres
    * @throws ContainerFullException, EspressoMachineContainerException
    *
    * @return void
    */
    public function addWater($liters) {
        $this->add($liters);
    }

    /**
    * Use $litres from the container
    *
    * @throws EspressoMachineContainerException
    * @param float $litres
    * @return integer
    */
    public function useWater($liters) {
        $this->used($liters);
    }

    /**
    * Returns the volume of water left in the container
    *
    * @return float number of litres
    */
    public function getWater() {
        return $this->get();
    }
}

class Container
{
    protected $amount;
    protected $capacity;

    public function __construct($capacity) {
        $this->capacity = $capacity;
        $this->amount = 0;
    }

    public function add($amount) {
        $this->amount+=$amount;
    }

    public function used($amount) {
        $this->amount-=$amount;
    }

    public function get() {
        return $this->amount;
    }
}
