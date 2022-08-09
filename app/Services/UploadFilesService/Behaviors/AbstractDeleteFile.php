<?php


namespace App\Services\UploadFilesService\Behaviors;


use App\Services\UploadFilesService\Behavior;
use Illuminate\Support\Facades\Storage;

/**
 * Class AbstractDeleteFile
 * @package App\Services\UploadFilesService\Behaviors
 */
class AbstractDeleteFile implements Behavior
{
    /**
     * @var string
     */
    protected $disc = 'public';

    /**
     * @var
     */
    protected $fileName;

    /**
     * AbstractDeleteFile constructor.
     * @param string $disc
     * @param $fileName
     */
    public function __construct(string $disc, $fileName, $path = '')
    {
        $this->disc = $disc;
        $this->fileName = $fileName;
    }


    /**
     * @return bool
     */
    public function handle(): bool
    {
        return Storage::disk($this->disc)->delete($this->fileName);
    }

}