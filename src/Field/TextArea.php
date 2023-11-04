<?php

namespace Zen\Form\Field;

use Zen\Form\Field;
use Zen\Form\Enum\FieldType;

class TextArea extends Field {
    #[\Override]
    public function __construct(string $name, array $groups = []) {
        parent::__construct(FieldType::TEXTAREA, $name, $groups);
    }

    public static function init(string $name, array $groups = []) : self {
        return new self($name, $groups);
    }
}