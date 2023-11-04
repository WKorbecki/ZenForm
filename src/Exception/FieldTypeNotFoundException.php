<?php

namespace Zen\Form\Exception;

use Override;

class FieldTypeNotFoundException extends \Exception {
    #[Override]
    public function __construct(?Throwable $previous = null) {
        parent::__construct('Field type not found!', 500, $previous);
    }
}