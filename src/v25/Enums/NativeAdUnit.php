<?php

declare(strict_types=1);

namespace OpenRTB\v25\Enums;

/**
 * Native Ad Unit - AdCOM List: Native Ad Unit.
 *
 * @see https://iabtechlab.com/wp-content/uploads/2016/03/OpenRTB-API-Specification-Version-2-5-FINAL.pdf
 */
enum NativeAdUnit: int
{
    case IN_FEED_AD = 1;
    case CONTENT_WALL = 2;
    case APP_WALL = 3;
    case CHAT_LIST = 4;
    case CAROUSEL = 5;
    case CONTENT_STREAM = 6;
    case GRID = 7;
}
