<?php

declare(strict_types=1);

namespace OpenRTB\v3\Enums\Context;

/**
 * The following table lists the various network connection types.
 *
 * @see https://github.com/InteractiveAdvertisingBureau/AdCOM/blob/master/AdCOM%20v1.0%20FINAL.md#list--connection-types-
 */
enum ConnectionType: int
{
    case UNKNOWN = 0;
    case ETHERNET = 1;
    case WIFI = 2;
    case CELLULAR_UNKNOWN = 3;
    case CELLULAR_2G = 4;
    case CELLULAR_3G = 5;
    case CELLULAR_4G = 6;
    case CELLULAR_5G = 7;
}
