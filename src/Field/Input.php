<?php

namespace Zen\Form\Field;

use Zen\Form\Field;
use Zen\Form\Enum\FieldAttribute;
use Zen\Form\Enum\FieldType;

class Input extends Field {
    #[\Override]
    public function __construct(FieldType $type, string $name, array $groups = []) {
        parent::__construct($type, $name, $groups);
        $this->attribute->set(FieldAttribute::TYPE, $this->type);
        $this->view = config('zen.form.view.input');
    }

    public static function init(FieldType $type, string $name, array $groups = []) : self {
        return new self($type, $name, $groups);
    }

    #[\Override]
    public function setValue(mixed $value) : self {
        parent::setValue($value); // TODO: Change the autogenerated stub

        if ($this->type !== FieldType::PASSWORD->value) {
            $this->attribute->set(FieldAttribute::VALUE, $value);
        }

        return $this;
    }
}