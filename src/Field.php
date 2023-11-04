<?php

namespace Zen\Form;

use Zen\Form\Exception\FieldTypeNotFoundException;
use Zen\Form\Field\Input;
use Zen\Form\Field\Select;
use Zen\Form\Field\TextArea;
use Zen\Form\Enum\FieldType;
use Zen\Form\Manager\AttributeManager;
use Zen\Form\Manager\CssClassManager;
use Zen\Form\Enum\FieldAttribute;

abstract class Field {
    protected string $name;
    protected array $groups = [];
    protected string $type;
    protected CssClassManager $classes;
    protected AttributeManager $attribute;
    protected Label|null $label = null;
    protected Group|null $group = null;
    protected string $view;
    protected mixed $value;
    protected array|string $rules;
    protected array $errors = [];

    public function __construct(FieldType $type, string $name, array $groups = []) {
        $this->name = $name;
        $this->type = $type->value;
        $this->attribute = new AttributeManager($name, $groups);
        $this->classes = new CssClassManager();
        $this->view = config('zen.form.view.' . $this->type);
    }

    public function getName() : string {
        return $this->name;
    }

    public function getRequestName() : string {
        return implode('.', [
            ... $this->groups,
            $this->name
        ]);
    }

    public function setAttribute(string|FieldAttribute $name, string|int $value) : self {
        $this->attribute->set($name, $value);

        return $this;
    }

    public function setLabel(Label $label, bool $setFor = true) : self {
        $this->label = $label;

        if ($setFor) {
            $this->label->setAttribute(
                FieldAttribute::FOR,
                $this->attribute->get(FieldAttribute::ID)
            );
        }

        return $this;
    }

    public function getLabel() : Label|null {
        return $this->label;
    }

    public function renderLabel() : string {
        return $this->label ? $this->label->render() : '';
    }

    public function removeLabel() : self {
        $this->label = null;

        return $this;
    }

    public function setGroup(Group $group) : self {
        $this->group = $group;

        return $this;
    }

    public function getGroup() : Group|null {
        return $this->group;
    }

    public function renderGroup($default = null) : string {
        return $this->group ?
            $this->group->render(
                $this->renderLabel(),
                $this->render($default)
            ) :
            '';
    }

    public function setClasses(... $classes) : self {
        $this->classes->set($this->attribute, ... $classes);

        return $this;
    }

    public function removeClasses(... $classes) : self {
        $this->classes->remove($this->attribute, ... $classes);

        return $this;
    }

    public function setValue(mixed $value) : self {
        $this->value = $value;

        return $this;
    }

    public function getValue() : mixed {
        return $this->value;
    }

    public function setRules(array|string $rules) : self {
        $this->rules = $rules;

        return $this;
    }

    public function getRules() : array|string {
        return $this->rules;
    }

    public function setErrors(... $errors) : self {
        $this->errors = $errors;

        return $this;
    }

    public function setView(string $view) : self {
        $this->view = $view;

        return $this;
    }

    public function removeView() : self {
        $this->view = config('zen.form.view.' . $this->type);

        return $this;
    }

    public function render($default = null) : string {
        return view($this->view, [
            'attributes' => $this->attribute->html(),
            'value' => $this->value,
        ])->render();
    }

    public static function make(string|FieldType $type, string $name, array $groups = []) : Input|TextArea|Select {
        switch ($type instanceof FieldType ? $type->value : $type) {
            case FieldType::TEXTAREA->value: return TextArea::init($name, $groups);
            case FieldType::SELECT->value: return Select::init($name, $groups);
            case FieldType::EMAIL->value:
            case FieldType::PASSWORD->value:
            case FieldType::DATE->value:
            case FieldType::TIME->value:
            case FieldType::HIDDEN->value:
            case FieldType::TEXT->value: return Input::init($type, $name, $groups);
        }

        throw new FieldTypeNotFoundException();
    }
}