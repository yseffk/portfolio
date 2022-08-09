<?php

namespace App\Services\EntityServices;

use App\Services\EntityServices\Eloquent\AbstractServiceFactory;
use App\Services\EntityServices\Eloquent\User\UseCase\Auth\LogoutService;
use App\Services\ServicesApp;
use Illuminate\Contracts\Container\BindingResolutionException;
use LogicException;

abstract class AbstractInstance extends AbstractServiceFactory
{

    protected array $instances = [];

    protected array $services = [];

    protected array $actions = [];

    private ServicesApp $servicesApp;

    public function __construct()
    {
        $this->servicesApp = ServicesApp::make();
    }

    /**
     * @throws BindingResolutionException
     */
    public function __call($name, $arguments = [])
    {
        if($instance = $this->getInstance($name)){
            return new $instance();
        }
        if($service = $this->getService($name)){
            if($service['dto']){
                $serviceObj = $this->createServiceWithDto($service['class'],$service['dto']);
            }else{
                $serviceObj = $this->createService($service['class']);
            }
            $serviceObj->setServicesApp($this->abstract());
            return $serviceObj;
        }

        if($service = $this->getAction($name)){
            $serviceObj = $this
                ->createActionService($service['class'], $service['dto']);

            if(isset($arguments[0])){
                $arguments = $arguments[0];
            }
            $serviceObj->setServicesApp($this->abstract());
            return $serviceObj->execute($arguments);
        }

        $this->exception($name);
    }

    /**
     * @return array
     */
    private function getInstances(): array
    {
        return $this->instances;
    }

    /**
     * @return array
     */
    private function getActions(): array
    {
        return $this->actions;
    }

    /**
     * @return \string[][]
     */
    private function getServices(): array
    {
        return $this->services;
    }

    /**
     * @return string|false
     */
    private function getInstance($name)
    {
        if(isset($this->getInstances()[$name])){
            return $this->getInstances()[$name];
        }
        return false;
    }

    /**
     * @return array|false
     */
    private function getService($name)
    {
        if(isset($this->getServices()[$name])){
            return $this->getServices()[$name];
        }
        return false;
    }

    /**
     * @return array|false
     */
    private function getAction($name)
    {
        if(isset($this->getActions()[$name])){
            return $this->getActions()[$name];
        }
        return false;
    }

    private function abstract(): ServicesApp
    {
        return $this->servicesApp;
    }

    private function exception($name)
    {
        throw new LogicException('ENTITY INSTANCE ERROR!. Service ' . $name . ' not implement ');
    }
}
