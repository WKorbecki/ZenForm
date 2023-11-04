<?php

namespace Zen\Form\Enum;

enum FieldAttribute : string {
    case ID = 'id';
    case NAME = 'name';
    case FOR = 'for';
    case CSSCLASS = 'class';
    case TYPE = 'type';
    case STYLE = 'style';
    case VALUE = 'value';
    case PLACEHOLDER = 'placeholder';
}
