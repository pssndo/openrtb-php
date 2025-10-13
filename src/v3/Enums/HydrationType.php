<?php

declare(strict_types=1);

namespace OpenRTB\v3\Enums;

enum HydrationType: string
{
    case PRIMITIVE = 'primitive';
    case ENUM = 'enum';
    case OBJECT = 'object';
    case ARRAY_OF_ENUMS = 'array_of_enums';
    case ARRAY_OF_OBJECTS = 'array_of_objects';
}
