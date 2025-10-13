<?php

declare(strict_types=1);

namespace OpenRTB\v3\Enums\Context;

/**
 * The following table lists the options for the source of the location data.
 *
 * @see https://github.com/InteractiveAdvertisingBureau/AdCOM/blob/master/AdCOM%20v1.0%20FINAL.md#list--location-type-
 */
enum LocationType: int
{
    case GPS_LOCATION_SERVICES = 1;
    case IP_LOOKUP = 2;
    case USER_PROVIDED = 3;
}
