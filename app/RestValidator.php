<?php

namespace App\Validators;

use Illuminate\Support\MessageBag;
use Illuminate\Validation\Validator;

class RestValidator extends Validator
{
    protected function addFailure($attribute, $rule, $parameters)
    {
        $message = $this->getMessage($attribute, $rule);

        $message = $this->makeReplacements($message, $attribute, $rule, $parameters);

        $customMessage = new MessageBag();

        $customMessage->merge(['code' => strtolower($rule.'_rule_error')]);
        $customMessage->merge(['message' => $message]);

        $this->messages->add($attribute, $customMessage);//dd($this->messages);
    }

}