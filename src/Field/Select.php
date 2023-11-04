<?php

namespace Zen\Form\Field;

use Zen\Form\Field;
use Zen\Form\Enum\FieldType;

class Select extends Field {
    protected array $options;
    protected bool $multiple;

    #[\Override]
    public function __construct(string $name, array $groups = [], bool $multiple = false) {
        parent::__construct(FieldType::SELECT, $name, $groups);

        $this->multiple = $multiple;

        if ($multiple) {
            $this->attribute->set('multiple', 'multiple');
        }
    }

    public function setOptions(array $options) : self {
        $this->options = $options;

        return $this;
    }

    #[\Override]
    public function render($default = null) : string {
        return view($this->view, [
            'attributes' => $this->attribute->html(),
            'selected' => $this->value ?? $default,
            'options' => $this->options,
            'multiple' => $this->multiple,
        ])->render();
    }

    public static function init(string $name, array $groups = [], bool $multiple = false) : self {
        return new self($name, $groups, $multiple);
    }
}