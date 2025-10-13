<?php

declare(strict_types=1);

namespace OpenRTB\v3\Enums\Placement;

enum ApiFramework: int
{
    case VPAID_1 = 1;
    case VPAID_2 = 2;
    case MRAID_1 = 3;
    case ORMMA = 4;
    case MRAID_2 = 5;
    case MRAID_3 = 6;
    case OMID_1 = 7;
}
