<?php


namespace App\Services\UploadFilesService;


/**
 * Class UploadFiles
 * @package App\Services\UploadFilesService
 *
 * File Upload strategy
 */
class UploadFiles
{
    /**
     * @var Behavior
     */
    protected Behavior $behavior;

    /**
     * @param Behavior $behavior
     */
    public function setBehavior(Behavior $behavior): void
    {
        $this->behavior = $behavior;
    }

    /**
     * @return mixed
     */
    public function execute()
    {
        return $this->behavior->handle();
    }

}