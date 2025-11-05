<?php

declare(strict_types=1);

namespace OpenRTB\v26\Enums;

/**
 * Ad Position - AdCOM List: Placement Position.
 *
 * @see https://iabtechlab.com/wp-content/uploads/2022/04/OpenRTB-2-6_FINAL.pdf
 */
enum AdPosition: int
{
    case UNKNOWN = 0;
    case ABOVE_THE_FOLD = 1;
    case DEPRECATED_MAY_BE_TREATED_AS_ABOVE_THE_FOLD = 2;
    case BELOW_THE_FOLD = 3;
    case HEADER = 4;
    case FOOTER = 5;
    case SIDEBAR = 6;
    case FULL_SCREEN = 7;
}
