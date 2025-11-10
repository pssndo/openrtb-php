<?php

declare(strict_types=1);

namespace OpenRTB\v25\Enums;

/**
 * Location Service - AdCOM List: Location Service.
 *
 * @see https://iabtechlab.com/wp-content/uploads/2016/03/OpenRTB-API-Specification-Version-2-5-FINAL.pdf
 */
enum LocationService: int
{
    case IP = 1;
    case GPS_LOCATION_SERVICES = 2;
    case USER_PROVIDED = 3;
}
