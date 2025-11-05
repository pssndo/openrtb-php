<?php

declare(strict_types=1);

namespace OpenRTB\v26\Enums;

/**
 * Expandable Direction - AdCOM List: Expandable Direction.
 *
 * @see https://iabtechlab.com/wp-content/uploads/2022/04/OpenRTB-2-6_FINAL.pdf
 */
enum ExpandableDirection: int
{
    case LEFT = 1;
    case RIGHT = 2;
    case UP = 3;
    case DOWN = 4;
    case FULL_SCREEN = 5;
}
