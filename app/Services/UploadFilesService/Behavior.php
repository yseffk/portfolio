<?php


namespace App\Services\UploadFilesService;


/**
 * Interface Behavior
 * @package App\Services\UploadFilesService
 */
interface Behavior
{
    /**
     * @return mixed
     */
    public function handle();
}