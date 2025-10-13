<?php

declare(strict_types=1);

namespace OpenRTB\v3\Enums\Context;

enum DeviceType: int
{
    case MOBILE = 1;
    case PC = 2;
    case TV = 3;
    case PHONE = 4;
    case TABLET = 5;
    case CONNECTED = 6;
    case SET_TOP = 7;
}
