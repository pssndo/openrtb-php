<?php

declare(strict_types=1);

namespace OpenRTB\v26\Enums;

/**
 * Location Service - AdCOM List: Location Service
 * @see https://iabtechlab.com/wp-content/uploads/2022/04/OpenRTB-2-6_FINAL.pdf
 */
enum LocationService: int
{
    case IP = 1;
    case GPS_LOCATION_SERVICES = 2;
    case USER_PROVIDED = 3;
}
