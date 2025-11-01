<?php

declare(strict_types=1);

namespace OpenRTB\v3\Enums\Bid;

/**
 * @see https://iabtechlab.com/wp-content/uploads/2022/04/OpenRTB-3.0-Framework-FINAL.pdf#page=60
 */
enum EventType: int
{
    case IMPRESSION = 1;
    case VIEWABLE_MRC50 = 2;
    case VIEWABLE_MRC100 = 3;
    case VIEWABLE_VIDEO50 = 4;
}
