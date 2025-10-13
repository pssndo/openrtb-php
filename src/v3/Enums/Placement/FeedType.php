<?php

declare(strict_types=1);

namespace OpenRTB\v3\Enums\Placement;

/**
 * The following table lists the various feed types for an audio placement.
 *
 * @see https://github.com/InteractiveAdvertisingBureau/AdCOM/blob/master/AdCOM%20v1.0%20FINAL.md#list--feed-types-
 */
enum FeedType: int
{
    case MUSIC_SERVICE = 1;
    case FM_AM_BROADCAST = 2;
    case PODCAST = 3;
}
