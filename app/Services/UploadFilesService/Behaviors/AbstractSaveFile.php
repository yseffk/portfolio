<?php


namespace App\Services\UploadFilesService\Behaviors;

use App\Services\UploadFilesService\Behavior;
use Illuminate\Http\UploadedFile;

/**
 * Class AbstractSaveFile
 * @package App\Services\UploadFilesService\Behaviors
 */
class AbstractSaveFile implements Behavior
{
    /**
     * @var UploadedFile
     */
    protected UploadedFile $uploadedFileObj;

    /**
     * @var string
     */
    protected $disc = 'public';

    /**
     * @var string
     */
    protected $fileName;

    /**
     * @var string
     */
    protected $path = '';

    /**
     * AbstractSaveFile constructor.
     * @param $uploadedFileObj
     * @param string $disc
     * @param $fileName
     * @param string $path
     */
    public function __construct(UploadedFile $uploadedFileObj, string $disc, string $fileName, string $path = '')
    {
        $this->uploadedFileObj = $uploadedFileObj;
        $this->disc = $disc;
        $this->fileName = $fileName;
        $this->path = $path;
    }


    /**
     * @return string
     */
    public function handle(): string
    {
        $file = $this->fileName . '.' . $this->uploadedFileObj->getClientOriginalExtension();

        $url = '/' . $this->disc . '/' . $this->uploadedFileObj->storeAs($this->path, $file, $this->disc);

        return $url;
    }

}