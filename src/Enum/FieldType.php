<?php

namespace Zen\Form\Enum;

enum FieldType : string {
    case TEXT = 'text';
    case TEXTAREA = 'textarea';
    case EMAIL = 'email';
    case PASSWORD = 'password';
    case DATE = 'date';
    case TIME = 'time';
    case HIDDEN = 'hidden';
    case SELECT = 'select';
    case NUMBER = 'number';
}
