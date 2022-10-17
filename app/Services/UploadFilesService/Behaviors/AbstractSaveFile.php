<?php


namespace App\Services\UploadFilesService\Behaviors;

use App\Services\UploadFilesService\Behavior;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Nette\Utils\Image;

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
        $max = 1024;
        $resized = Image::fromFile($this->uploadedFileObj);
        $width = $resized->getWidth();
        $height = $resized->getHeight();

        if ( $width > $max || $height > $max) {
            $resized = ($width > $height)
                ? $resized->resize($max, null)
                : $resized->resize(null,$max);
            // Overwrite source photo with the resized one

        }

        $file = $this->path . '/' .$this->fileName . '.' . $this->uploadedFileObj->getClientOriginalExtension();
        Storage::disk($this->disc)->put($file, $resized);
        $url = '/' . $this->disc . '/'.  $file;

        return $url;
    }

}
