<?php

declare(strict_types=1);

namespace OpenRTB\v3\Enums\Placement;

enum AdPosition: int
{
    case UNKNOWN = 0;
    case ABOVE_FOLD = 1;
    case BELOW_FOLD = 3;
    case HEADER = 4;
    case FOOTER = 5;
    case SIDEBAR = 6;
    case FULLSCREEN = 7;
}
