<?php


namespace App\Services\ValidationService;

use Symfony\Component\HttpFoundation\JsonResponse;
use Illuminate\Support\MessageBag;
use Illuminate\Http\Exceptions\HttpResponseException;


class ValidatorException extends HttpResponseException
{
    /**
     * @var MessageBag
     */
    protected $messageBag;

    /**
     * @param MessageBag $messageBag
     */
    public function __construct(MessageBag $messageBag)
    {

        $this->messageBag = $messageBag;
        parent::__construct($this->toJson());
    }

    /**
     * @return MessageBag
     */
    public function getMessageBag()
    {
        return $this->messageBag;
    }

    /**
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'message' => 'The given data was invalid.',
            'errors' => $this->getMessageBag()
        ];
    }

    /**
     * @param  int $status
     * @return JsonResponse
     */
    public function toJson($status = 422)
    {

        $response  = new JsonResponse($this->toArray(), $status);
        return $response;
    }
}