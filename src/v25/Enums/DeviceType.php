<?php

declare(strict_types=1);

namespace OpenRTB\v25\Enums;

/**
 * Device Type - AdCOM List: Device Type.
 *
 * @see https://iabtechlab.com/wp-content/uploads/2016/03/OpenRTB-API-Specification-Version-2-5-FINAL.pdf
 */
enum DeviceType: int
{
    case MOBILE_TABLET = 1;
    case PERSONAL_COMPUTER = 2;
    case CONNECTED_TV = 3;
    case PHONE = 4;
    case TABLET = 5;
    case CONNECTED_DEVICE = 6;
    case SET_TOP_BOX = 7;
    case OOH_DEVICE = 8;
}
