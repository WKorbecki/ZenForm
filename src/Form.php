<?php

namespace Zen\Form;

use Illuminate\Support\MessageBag;
use Zen\Form\Manager\ValidatorManager;
use Zen\Form\Manager\ValueManager;

abstract class Form {
    /**
     * @var Field[]
     */
    private array $fields = [];
    private MessageBag|null $messageBag = null;
    private ValueManager|null $valueManager = null;

    public function addField(Field $field) : self {
        $this->fields[$field->getName()] = $field;

        return $this;
    }

    public function getField(string $name) : Field|null {
        return $this->fields[$name] ?? null;
    }

    public function validate() : bool {
        $validator = new ValidatorManager($this->fields);
        $result = $validator->validate();
        $this->messageBag = $validator->messages();

        if (!$result) {
            foreach ($this->fields as $field) {
                if ($messages = $this->messageBag->get($field->getRequestName())) {
                    $field->setErrors(... $messages);
                }
            }
        }

        return $result;
    }

    public function getErrors() : MessageBag {
        return $this->messageBag ?? (new MessageBag());
    }

    public function populate($obj) : void {
        $this->getValueManager()->fill($this->fields, $obj);
    }

    public function render(string $name, $default = null) : string {
        return $this->fields[$name]?->render($default) ?? '';
    }

    public function renderGroup(string $name, $default = null) : string {
        return $this->fields[$name]?->renderGroup($default) ?? '';
    }

    private function getValueManager() : ValueManager {
        return $this->valueManager ?? new ValueManager();
    }
}