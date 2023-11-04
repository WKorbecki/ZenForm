<?php

namespace Zen\Form;

use Zen\Form\Enum\FieldAttribute;
use Zen\Form\Manager\AttributeManager;
use Zen\Form\Manager\CssClassManager;

class Group {
    private AttributeManager $attribute;
    private CssClassManager $classes;
    private string $view;

    public function __construct() {
        $this->attribute = new AttributeManager();
        $this->classes = new CssClassManager();
        $this->view = config('zen.form.view.group');
    }

    public function setAttribute(string|FieldAttribute $name, string|int $value) : self {
        $this->attribute->set($name, $value);

        return $this;
    }

    public function setClasses(... $classes) : self {
        $this->classes->set($this->attribute, ... $classes);

        return $this;
    }

    public function removeClasses(... $classes) : self {
        $this->classes->remove($this->attribute, ... $classes);

        return $this;
    }

    public function getAttribute() : AttributeManager {
        return $this->attribute;
    }

    public function setView(string $view) : self {
        $this->view = $view;

        return $this;
    }

    public function removeView() : self {
        $this->view = config('zen.form.view.group');

        return $this;
    }

    public function render(string $label, string $field) : string {
        return view($this->view, [
            'attributes' => $this->attribute->html(),
            'label' => $label,
            'field' => $field,
        ])->render();
    }

    public static function init() : self {
        return new self();
    }
}