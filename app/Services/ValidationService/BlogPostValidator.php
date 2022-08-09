<?php


namespace App\Services\ValidationService;


use Illuminate\Validation\Factory;
use Illuminate\Validation\Rule;

class BlogPostValidator extends Validator
{
    const GROUPS = ['CALENDAR','www'];

    public function __construct(Factory $factory)
    {
        parent::__construct($factory);

        $rules = [
            'title' => array('required','min:3','max:250'),
            'group' => array('required', Rule::in(static::GROUPS)),
            'is_published' => array('required')
        ];

       $this->setRules([
           ValidatorInterface::RULE_CREATE=>$rules,
           ValidatorInterface::RULE_UPDATE=>$rules,
       ]);
    }


}