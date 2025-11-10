<?php

declare(strict_types=1);

namespace OpenRTB\v25\Enums;

/**
 * Connection Type - AdCOM List: Connection Type.
 *
 * @see https://iabtechlab.com/wp-content/uploads/2016/03/OpenRTB-API-Specification-Version-2-5-FINAL.pdf
 */
enum ConnectionType: int
{
    case UNKNOWN = 0;
    case ETHERNET = 1;
    case WIFI = 2;
    case CELLULAR_NETWORK_UNKNOWN_GENERATION = 3;
    case CELLULAR_NETWORK_2G = 4;
    case CELLULAR_NETWORK_3G = 5;
    case CELLULAR_NETWORK_4G = 6;
    case CELLULAR_NETWORK_5G = 7;
}
