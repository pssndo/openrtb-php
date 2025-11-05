<?php

declare(strict_types=1);

namespace OpenRTB\v26\Enums;

/**
 * API Frameworks - AdCOM List: API Frameworks.
 *
 * @see https://iabtechlab.com/wp-content/uploads/2022/04/OpenRTB-2-6_FINAL.pdf
 */
enum ApiFramework: int
{
    case VPAID_1_0 = 1;
    case VPAID_2_0 = 2;
    case MRAID_1 = 3;
    case ORMMA = 4;
    case MRAID_2 = 5;
    case MRAID_3 = 6;
    case OMID_1 = 7;
    case SIMID_1 = 8;
    case SIMID_1_1 = 9;
}
