<?php

namespace Zen\Form\Manager;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Zen\Form\Field;

class ValueManager {
    /**
     * @param Field[] $fields
     * @param $obj
     * @return void
     */
    public function fill(array & $fields, $obj) : void {
        $obj = $this->mapObject($obj);

        foreach ($fields as $name => $field) {
            $nameStructure = explode('.', $name);
            $fieldValue = $field->getValue();

            if ($this->shouldFill($nameStructure, 1, $fieldValue)) {
                $field->setValue($this->getNestedValue($obj, $nameStructure, $fieldValue));
            }
            elseif ($this->shouldFill($obj, $name, $fieldValue)) {
                $field->setValue($obj[$name]);
            }
        }
    }

    private function shouldFill(array $array, string|int $field, $value) : bool {
        return isset($array[$field]) && ((is_array($value) && count($value) == 0) || $value === null);
    }

    private function getNestedValue($value, array $structure, $fieldValue) {
        for ($i = 0; $i < count($structure); $i++) {
            $value = $obj_val[$structure[$i]] ?? $fieldValue;
        }

        return $value;
    }

    private function mapObject($obj) : array {
        if (is_object($obj)) {
            $array = $obj instanceof Model ? $obj->toArray() : (array) $obj;

            foreach ($array as $field => $value) {
                if ($value instanceof Carbon) {
                    $array[$field] = $value->format('Y-m-d H:i:s');
                }
            }

            return $array;
        }

        return (array) $obj;
    }
}