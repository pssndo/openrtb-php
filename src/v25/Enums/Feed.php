<?php

declare(strict_types=1);

namespace OpenRTB\v25\Enums;

/**
 * Feed Quality - AdCOM List: Feed Type.
 *
 * @see https://iabtechlab.com/wp-content/uploads/2016/03/OpenRTB-API-Specification-Version-2-5-FINAL.pdf
 */
enum Feed: int
{
    case MUSIC_SERVICE = 1;
    case FM_AM_BROADCAST = 2;
    case PODCAST = 3;
}
