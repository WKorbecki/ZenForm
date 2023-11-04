<?php

namespace Zen\Form\Manager;

use Zen\Form\Enum\FieldAttribute;

class AttributeManager {
    private array $attributes = [];

    public function __construct(string|null $name = null, array $groups = []) {
        if ($name) {
            $this->set(FieldAttribute::ID, $this->generateId($name, $groups));
            $this->set(FieldAttribute::NAME, $this->generateName($name, $groups));
        }
    }

    public function set(string|FieldAttribute $name, string|int $value) : void {
        $this->attributes[$this->getAttributeName($name)] = $value;
    }

    public function get(string|FieldAttribute $name) : string|int|null {
        return $this->attributes[$this->getAttributeName($name)] ?? null;
    }

    public function remove(string $name) : bool {
        $name = $this->getAttributeName($name);

        if (isset($this->attributes[$name])) {
            unset($this->attributes[$name]);

            return true;
        }

        return false;
    }

    public function html() : string {
        return collect($this->attributes)
            ->implode(static fn (string|int $value, string $name) => $name.'="'.$value.'"', ' ');
    }

    private function getAttributeName(string|FieldAttribute $name) : string {
        return $name instanceof FieldAttribute ? $name->value : $name;
    }

    private function generateId(string $name, array $groups) : string {
        return implode('-', [...$groups, $name]);
    }

    private function generateName(string $name, array $groups) : string {
        if (empty($groups)) {
            return $name;
        }

        return '[' . implode('][', [... $groups, $name]) . ']';
    }
}