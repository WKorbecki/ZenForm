<?php

namespace Zen\Form\Manager;

use Illuminate\Support\Collection;
use Zen\Form\Enum\FieldAttribute;

class CssClassManager {
    private Collection $classes;

    public function __construct() {
        $this->classes = collect();
    }

    public function set(AttributeManager & $attribute, ... $classes) : void {
        $this->classes->merge($classes)->unique()->values();
        $attribute->set(FieldAttribute::CSSCLASS, $this->classes->implode(' '));
    }

    public function remove(AttributeManager & $attribute, ... $classes) : void {
        $this->classes = $this->classes
            ->filter(static fn ($class) => !in_array($class, $classes))
            ->unique()
            ->values();
        $attribute->set(FieldAttribute::CSSCLASS, $this->classes->implode(' '));
    }

    public function has(string $class) : bool {
        return (bool) $this->classes->filter(static fn ($_class) => $class === $_class)->count();
    }
}