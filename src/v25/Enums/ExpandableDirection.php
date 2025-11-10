<?php

declare(strict_types=1);

namespace OpenRTB\v25\Enums;

/**
 * Expandable Direction - AdCOM List: Expandable Direction.
 *
 * @see https://iabtechlab.com/wp-content/uploads/2016/03/OpenRTB-API-Specification-Version-2-5-FINAL.pdf
 */
enum ExpandableDirection: int
{
    case LEFT = 1;
    case RIGHT = 2;
    case UP = 3;
    case DOWN = 4;
    case FULL_SCREEN = 5;
}
