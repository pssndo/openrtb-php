<?php

declare(strict_types=1);

namespace OpenRTB\v3\Enums\Context;

/**
 * The following table lists the various IP-to-geo services.
 *
 * @see https://github.com/InteractiveAdvertisingBureau/AdCOM/blob/master/AdCOM%20v1.0%20FINAL.md#list--ip-location-services-
 */
enum IpLocationService: int
{
    case IP2LOCATION = 1;
    case NEUSTAR = 2;
    case MAXMIND = 3;
    case NETACUITY = 4;
}
