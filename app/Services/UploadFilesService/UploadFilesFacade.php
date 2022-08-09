<?php


namespace App\Services\UploadFilesService;


use App\Services\UploadFilesService\Behaviors\BlogAttachmentDeleteFile;
use App\Services\UploadFilesService\Behaviors\BlogAttachmentSaveFile;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\UploadedFile;

/**
 * Class UploadFilesFacade
 * @package App\Services\UploadFilesService
 *
 * Build UploadFiles strategy
 *
 * @method saveBlogAttachmentImg(UploadedFile $uploadedFileObj, $fileName = '', $path = '')
 *
 * @method deleteBlogAttachmentImg($fileName)
 *

 */
class UploadFilesFacade
{
    /**
     * @var array
     */
    protected array $behaviors = [

        'saveBlogAttachmentImg' => BlogAttachmentSaveFile::class,
        'deleteBlogAttachmentImg' => BlogAttachmentDeleteFile::class,


    ];

    /**
     * @var array
     */
    protected array $storageByBehaviors = [
        'blog_attach' => [
            BlogAttachmentSaveFile::class,
            BlogAttachmentDeleteFile::class,
        ],

    ];

    /**
     * @var UploadFiles
     */
    protected UploadFiles $uploadFiles;

    /**
     * UploadFilesFacade constructor.
     */
    public function __construct()
    {
        $this->uploadFiles = new UploadFiles();
    }

    /**
     * @param $name
     * @param $arguments
     * @return mixed
     */
    public function __call($name, $arguments)
    {

        if (!isset($this->behaviors[$name])) {
            $this->exception('Behavior ' . $name . ' not found', 400);
        }

        if (!$disc = $this->getDisc($this->behaviors[$name])) {
            $this->exception('Disc fo behavior ' . $name . ' not found', 400);
        }

        $uploadedFileObj = $this->getUploadedFileObj($arguments);

        $fileName = time();
        if (isset($arguments[0])) {
            $fileName = $arguments[0];
        }
        $path = '';
        if (isset($arguments[1])) {
            $path = $arguments[1];
        }


        if ($uploadedFileObj !== false) {

            $this->uploadFiles->setBehavior(
                new $this->behaviors[$name]($uploadedFileObj, $disc, $fileName, $path)
            );
        } else {
            $this->uploadFiles->setBehavior(
                new $this->behaviors[$name]($disc, $fileName, $path)
            );
        }


        return $this->uploadFiles->execute();
    }

    /**
     * @param $behavior
     * @return bool|string
     */
    private function getDisc($behavior)
    {
        foreach ($this->storageByBehaviors as $disc => $behaviors) {
            if (in_array($behavior, $behaviors)) {
                return $disc;
            }
        }
        return false;
    }

    /**
     * @param $arguments
     * @return bool|UploadedFile
     */
    private function getUploadedFileObj(&$arguments)
    {
        foreach ($arguments as $key => $item) {
            if ($item instanceof UploadedFile) {
                unset($arguments[$key]);
                $arguments = array_values($arguments);

                return $item;
            }
        }
        return false;
    }

    /**
     * @param $error
     * @param $status_code
     */
    private function exception($error, $status_code)
    {
        $response = new JsonResponse([
            'message' => 'SERVICE UPLOAD FILES ERROR',
            'errors' => [$error]
        ], $status_code);

        throw new HttpResponseException($response);
    }
}
