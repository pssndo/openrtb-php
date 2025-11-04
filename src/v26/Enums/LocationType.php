<?php

declare(strict_types=1);

namespace OpenRTB\v26\Enums;

/**
 * Location Type - AdCOM List: Location Type
 * @see https://iabtechlab.com/wp-content/uploads/2022/04/OpenRTB-2-6_FINAL.pdf
 */
enum LocationType: int
{
    case GPS_LOCATION_SERVICES = 1;
    case IP_ADDRESS = 2;
    case USER_PROVIDED = 3;
}
