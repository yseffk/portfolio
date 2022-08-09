<?php


namespace App\Services\ValidationService;

use Illuminate\Support\MessageBag;


abstract class AbstractValidator implements ValidatorInterface
{

    /**
     * Validator
     *
     * @var object
     */
    protected $validator;

    /**
     * Data to be validated
     *
     * @var array
     */
    protected $data = [];

    /**
     * Validation Rules
     *
     * @var array
     */
    protected $rules = [];

    /**
     * Validation Custom Messages
     *
     * @var array
     */
    protected $messages = [];

    /**
     * Validation Custom Attributes
     *
     * @var array
     */
    protected $attributes = [];

    /**
     * Validation errors
     *
     * @var MessageBag
     */
    protected $errors = [];



    /**
     * Set data to validate
     *
     * @param array $data
     * @return $this
     */
    public function with(array $data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Return errors
     *
     * @return array
     */
    public function errors()
    {
        return $this->errorsBag()->all();
    }

    /**
     * Errors
     *
     * @return MessageBag
     */
    public function errorsBag()
    {
        return $this->errors;
    }

    /**
     * Pass the data and the rules to the validator
     *
     * @param string $action
     * @return boolean
     */
    abstract public function passes($action = null);

    /**
     * @param null $action
     * @return bool
     * @throws ValidatorException
     */
    public function passesOrFail($action = null)
    {
        if (!$this->passes($action)) {

            throw new ValidatorException($this->errorsBag());
        }

        return true;
    }

    /**
     * Get rule for validation by action ValidatorInterface::RULE_CREATE or ValidatorInterface::RULE_UPDATE
     *
     *
     * @param null $action
     * @return array
     */
    public function getRules($action = ValidatorInterface::RULE_CREATE): array
    {
        $rules = $this->rules;

        if (isset($this->rules[$action])) {
            $rules = $this->rules[$action];
        }

        return $rules;
    }

    /**
     * Set Rules for Validation
     *
     * @param array $rules
     * @return $this
     */
    public function setRules(array $rules)
    {
        $this->rules = $rules;
        return $this;
    }

    /**
     * Get Custom error messages for validation
     *
     * @return array
     */
    public function getMessages()
    {
        return $this->messages;
    }

    /**
     * Set Custom error messages for Validation
     *
     * @param array $messages
     * @return $this
     */
    public function setMessages(array $messages)
    {
        $this->messages = $messages;
        return $this;
    }

    /**
     * Get Custom error attributes for validation
     *
     * @return array
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * Set Custom error attributes for Validation
     *
     * @param array $attributes
     * @return $this
     */
    public function setAttributes(array $attributes)
    {
        $this->attributes = $attributes;
        return $this;
    }


}
