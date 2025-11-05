<?php

declare(strict_types=1);

namespace OpenRTB\v26\Enums;

/**
 * Feed Quality - AdCOM List: Feed Type.
 *
 * @see https://iabtechlab.com/wp-content/uploads/2022/04/OpenRTB-2-6_FINAL.pdf
 */
enum Feed: int
{
    case MUSIC_SERVICE = 1;
    case FM_AM_BROADCAST = 2;
    case PODCAST = 3;
}
