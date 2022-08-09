<?php

namespace App\Services;

use App\Services\EntityServices\ActionInstance;
use App\Services\EntityServices\EntityInstance;
use App\Services\UploadFilesService\UploadFilesFacade;
use LogicException;

/**
 *
 * @method EntityInstance entity()
 * @method validator()
 * @method ActionInstance action()
 * @method UploadFilesFacade uploadFiles()
 */
class ServicesApp
{
    private array $instance = [
        'entity' => EntityInstance::class,
        'action' => ActionInstance::class,
        'uploadFiles'=>UploadFilesFacade::class,
    ];


    private function __constructor()
    {}

    public static function make(): ServicesApp
    {
        return new static();
    }

    public function __call($name, $arguments = [])
    {
        if(!isset($this->instance[$name])){
            throw new LogicException('SERVICES APP ERROR!. Service ' . $name . ' not implement ');
        }

        return new $this->instance[$name]();

    }
}
