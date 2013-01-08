<?php

require 'EspressoMachine.interface.php';

class EspressoMachine implements EspressoMachineInterface
{
    private $waterContainer;
    private $amoutOfCoffeeMade = 0;

    protected $waterAmount;
    protected $waterCapacity;

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
        return $this->makeCoffee(0.05);
    }

    /**
    * @see makeEspresso
    * @throws DescaleNeededException, NoBeansException, NoWaterException
    *
    * @return float of litres of coffee made
    */
    public function makeDoubleEspresso() {
        return $this->makeCoffee(0.1);
    }

    private function makeCoffee($waterAmount) {
        $this->amoutOfCoffeeMade+=$waterAmount;
        $this->waterAmount-=$waterAmount;
        return $this->amoutOfCoffeeMade; 
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
    public function addWater($litres) {}

    /**
    * Use $litres from the container
    *
    * @throws EspressoMachineContainerException
    * @param float $litres
    * @return integer
    */
    public function useWater($litres) {}

    /**
    * Returns the volume of water left in the container
    *
    * @return float number of litres
    */

    public function getWater() {
        return $this->waterContainer->getWaterAmount();
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

class BeansContainerImplementation extends EspressoMachine
{

}

class WaterContainerImplementation extends EspressoMachine
{
    public function __construct($capacity) {
        $this->waterCapacity = $capacity;
        $this->waterAmount = $capacity;
    }

    protected function getWaterAmount() {
        return $this->waterAmount;
    }

}
