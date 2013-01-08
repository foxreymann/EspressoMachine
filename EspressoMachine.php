<?php

require 'EspressoMachine.interface.php';

error_reporting(-1);

class EspressoMachine implements EspressoMachineInterface
{
    private $waterContainer;
    private $amountOfCofeeMadeInMl = 0;
    private $needsDescaling = false;

    /**
    * Runs the process to descale the machine
    * so the machine can be used make coffee
    * uses 1 litre of water
    *
    * @throws NoWaterException
    *
    * @return void
    */
    public function descale() {}

    /**
    * Runs the process for making Espresso
    *
    * @throws DescaleNeededException, NoBeansException, NoWaterException
    *
    * @return float of litres of coffee made
    */
    public function makeEspresso() {
        return $this->makeCoffee(50);
    }

    /**
    * @see makeEspresso
    * @throws DescaleNeededException, NoBeansException, NoWaterException
    *
    * @return float of litres of coffee made
    */
    public function makeDoubleEspresso() {
        return $this->makeCoffee(100);
    }

    private function makeCoffee($waterAmount) {
        if($this->needsDescaling) {
           throw new DescaleNeededException(); 
        }
        if(($this->amountOfCofeeMadeInMl / 5000) < intval(($this->amountOfCofeeMadeInMl + $waterAmount) / 5000)) {
            $this->needsDescaling = true;
        }

        $this->amountOfCofeeMadeInMl+=$waterAmount;
        $this->waterAmount-=$waterAmount;
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

    /**
    * @param BeansContainer $container
    */
    public function setBeansContainer(BeansContainer $container) {}

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
        $this->waterContainer->addWater($liters);
    }

    /**
    * Use $litres from the container
    *
    * @throws EspressoMachineContainerException
    * @param float $litres
    * @return integer
    */
    public function useWater($litres) {
        $this->waterContainer->useWater($litres);
    }

    /**
    * Returns the volume of water left in the container
    *
    * @return float number of litres
    */

    public function getWater() {
        return $this->waterContainer->getWater();
    }

    /**
    * Adds beans to the container
    *
    * @param integer $numSpoons number of spoons of beans
    * @throws ContainerFullException, EspressoMachineContainerException
    *
    * @return void
    */
    public function addBeans($numSpoons) {}

    /**
    * Get $numSpoons from the container
    *
    * @throws EspressoMachineContainerException
    * @param integer $numSpoons number of spoons of beans
    * @return integer
    */
    public function useBeans($numSpoons) {}

    /**
    * Returns the number of spoons of beans left in the container
    *
    * @return integer
    */
    public function getBeans() {}
}

class BeansContainerImplementation implements BeansContainer
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

    }

    /**
    * Get $numSpoons from the container
    *
    * @throws EspressoMachineContainerException
    * @param integer $numSpoons number of spoons of beans
    * @return integer
    */
    public function useBeans($numSpoons) {

    }

    /**
    * Returns the number of spoons of beans left in the container
    *
    * @return integer
    */
    public function getBeans() {

    }

}

class WaterContainerImplementation implements WaterContainer
{
    protected $waterAmount;
    protected $waterCapacity;

    public function __construct($capacity) {
        $this->waterCapacity = $capacity;
        $this->waterAmount = $capacity;
    }

    /**
    * Adds water to the coffee machine's water tank
    *
    * @param float $litres
    * @throws ContainerFullException, EspressoMachineContainerException
    *
    * @return void
    */
    public function addWater($liters) {
        $this->waterAmount+=$liters;
    }

    /**
    * Use $litres from the container
    *
    * @throws EspressoMachineContainerException
    * @param float $litres
    * @return integer
    */
    public function useWater($liters) {
        $this->waterAmount-=$liters;
    }

    /**
    * Returns the volume of water left in the container
    *
    * @return float number of litres
    */
    public function getWater() {
        return $this->waterAmount;
    }

}
