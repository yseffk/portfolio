<?php


namespace App\Services\ValidationService;

use Illuminate\Contracts\Validation\Factory;

class Validator extends AbstractValidator
{
    /**
     * Validator
     *
     * @var \Illuminate\Validation\Factory
     */
    protected $validator;

    /**
     * Construct
     *
     * @param Factory $validator
     */
    public function __construct(Factory $validator)
    {
        $this->validator = $validator;
    }

    /**
     * Pass the data and the rules to the validator
     *
     * @param string $action
     * @return bool
     */
    public function passes($action = null)
    {

        $rules      = $this->getRules($action);
        $messages   = $this->getMessages();
        $attributes = $this->getAttributes();
        $validator  = $this->validator->make($this->data, $rules, $messages, $attributes);

        if ($validator->fails()) {

            $this->errors = $validator->messages();
            return false;
        }

        return true;
    }

}