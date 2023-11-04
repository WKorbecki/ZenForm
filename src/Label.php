<?php

namespace Zen\Form;

use Zen\Form\Enum\FieldAttribute;
use Zen\Form\Manager\AttributeManager;
use Zen\Form\Manager\CssClassManager;

class Label {
    private string $label;
    private AttributeManager $attribute;
    private CssClassManager $classes;
    private string $view;

    public function __construct(string $for, string $label) {
        $this->label = $label;
        $this->attribute = new AttributeManager();
        $this->attribute->set(FieldAttribute::FOR, $for);
        $this->classes = new CssClassManager();
        $this->view = config('zen.form.view.label');
    }

    public function setLabel(string $label) : self {
        $this->label = $label;

        return $this;
    }

    public function getLabel() : string {
        return $this->label;
    }

    public function setAttribute(string|FieldAttribute $name, string|int $value) : self {
        $this->attribute->set($name, $value);

        return $this;
    }

    public function getAttribute(string $name) {

    }

    public function attribute() : AttributeManager {
        return $this->attribute;
    }

    public function setClasses(... $classes) : self {
        $this->classes->set($this->attribute, ... $classes);

        return $this;
    }

    public function removeClasses(... $classes) : self {
        $this->classes->remove($this->attribute, ... $classes);

        return $this;
    }

    public function setView(string $view) : self {
        $this->view = $view;

        return $this;
    }

    public function removeView() : self {
        $this->view = config('zen.form.view.label');

        return $this;
    }

    public function render() : string {
        return view($this->view, [
            'attributes' => $this->attribute->html(),
            'label' => $this->getLabel(),
        ])->render();
    }

    public static function init(string $for, string $label) : self {
        return new self($for, $label);
    }
}