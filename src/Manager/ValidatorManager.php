<?php

namespace Zen\Form\Manager;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;
use Zen\Form\Field;

class ValidatorManager {
    private array $rules = [];
    private MessageBag $messageBag;

    /**
     * @param Field[] $fields
     */
    public function __construct(array $fields) {
        $this->messageBag = new MessageBag();

        foreach ($fields as $field) {
            $this->rules[$field->getRequestName()] = $field->getRules();
        }
    }

    public function validate(array $rules = [], array $messages = []) : bool {
        $this->rules = array_merge($this->rules, $rules);

        if ($this->rules) {
            $validator = Validator::make(request()->all(), $this->rules, $messages);

            if ($validator->fails()) {
                $this->messageBag = $validator->getMessageBag();

                return false;
            }
        }

        return true;
    }

    public function messages() : MessageBag {
        return $this->messageBag;
    }
}