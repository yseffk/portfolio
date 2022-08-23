<?php

namespace App\Services\EntityServices\Eloquent\Blog\UseCase;

use App\Repository\Eloquent\BlogItemAttachmentRepository;
use App\Repository\EloquentRepositoryInterface;
use App\Services\EntityServices\Eloquent\EntityAbstractService;
use App\Services\EntityServices\Eloquent\EntityServiceInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\HTTP\UploadedFile;

/**
 * Class EntityBlogItemAttachmentService
 * @package App\Services\EntityServices\Eloquent\Blog\UseCase
 */
class EntityBlogItemAttachmentService extends EntityAbstractService implements EntityServiceInterface
{
    /**
     * @var BlogItemAttachmentRepository
     */
    protected BlogItemAttachmentRepository $BlogItemAttachmentRepository;

    /**
     * EntityBlogItemAttachmentService constructor.
     * @param BlogItemAttachmentRepository $BlogItemAttachmentRepository
     */
    public function __construct(BlogItemAttachmentRepository $BlogItemAttachmentRepository)
    {
        $this->BlogItemAttachmentRepository = $BlogItemAttachmentRepository;
    }


    /**
     * @param array $arguments
     * @return Model
     */
    public function create(array $arguments): Model
    {
        $this->entityModel = parent::create($arguments);

        $this->saveFile();

        return $this->entityModel;

    }

    public function update(int $id, array $arguments): Model
    {
        $dto = new $this->dto($arguments);

        $this->entityModel = $this->repository()->find($id);

        foreach ($dto as $key=>$value){
            if($key == 'file_path' && !($value instanceof UploadedFile))
            {
               continue;
            }
            $this->entityModel->{$key} = $value;
        }

        $this->saveFile();

        if($this->entityModel->isDirty('file_path')){
            $this->deleteFile($this->entityModel->getOriginal('file_path'));
        }

        return $this->repository()->update($id, $this->entityModel->toArray());
    }

    public function delete(int $id): Model
    {
        $this->entityModel = $this->repository()->find($id);

        $this->deleteFile($this->entityModel->file_path);

        return $this->repository()->delete($id);

    }

    public function repository(): EloquentRepositoryInterface
    {
        return $this->BlogItemAttachmentRepository;

    }

    private function saveFile()
    {
        if($this->entityModel->source!=='FILE'
            ||
           ($this->entityModel->file_path instanceof UploadedFile) === false
        ){
            return false;
        }
        $uploadedFileObj = $this->entityModel->file_path;

        $fileName = time().'-'.$this->entityModel->type;

        $path = $this->entityModel->blog_item_id;



        switch ($this->entityModel->type){
            case 'AUDIO':
                $this->entityModel->file_path = $this->uploadFiles()
                    ->saveBlogAttachmentAudio($uploadedFileObj, $fileName,  $path);
                break;
            case 'VIDEO':
                $this->entityModel->file_path = $this->uploadFiles()
                    ->saveBlogAttachmentVideo($uploadedFileObj, $fileName,  $path);
                break;
            case 'IMG':
                $this->entityModel->file_path = $this->uploadFiles()
                    ->saveBlogAttachmentImg($uploadedFileObj, $fileName,  $path);
                break;
            case 'NOTES':
                $this->entityModel->file_path = $this->uploadFiles()
                    ->saveBlogAttachmentNotes($uploadedFileObj, $fileName,  $path);
                break;
            case 'TEXT':
                $this->entityModel->file_path = $this->uploadFiles()
                    ->saveBlogAttachmentText($uploadedFileObj, $fileName,  $path);
                break;

        }
        return true;
    }

    private function deleteFile($file_path)
    {
        $array =  explode('/', $file_path);

        $fileName = $this->entityModel->blog_item_id.'/'.array_pop($array);

        $result = false;

        switch ($this->entityModel->type) {
            case 'AUDIO':
                $result = $this->uploadFiles()
                    ->deleteBlogAttachmentAudio($fileName);
                break;
            case 'VIDEO':
                $result = $this->uploadFiles()
                    ->deleteBlogAttachmentVideo($fileName);
                break;
            case 'IMG':
                $result = $this->uploadFiles()
                    ->deleteBlogAttachmentImg($fileName);
                break;
            case 'NOTES':
                $result = $this->uploadFiles()
                    ->deleteBlogAttachmentNotes($fileName);
                break;
            case 'TEXT':
                $result = $this->uploadFiles()
                    ->deleteBlogAttachmentText($fileName);
                break;
        }

        return $result;
    }

    private function uploadFiles()
    {
        return $this->abstract()->uploadFiles();
    }
}
