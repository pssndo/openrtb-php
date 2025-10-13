<?php

declare(strict_types=1);

namespace OpenRTB\v3\Enums\Placement;

/**
 * The following table lists the options for the unit of size used for dimensions.
 *
 * @see https://github.com/InteractiveAdvertisingBureau/AdCOM/blob/master/AdCOM%20v1.0%20FINAL.md#list--size-units-
 */
enum SizeUnit: int
{
    case DENSITY_INDEPENDENT_PIXELS = 1;
    case INCHES = 2;
    case CENTIMETERS = 3;
}
