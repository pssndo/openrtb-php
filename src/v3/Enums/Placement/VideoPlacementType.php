<?php

declare(strict_types=1);

namespace OpenRTB\v3\Enums\Placement;

/**
 * The following table lists the various types of video placements.
 *
 * @see https://github.com/InteractiveAdvertisingBureau/AdCOM/blob/master/AdCOM%20v1.0%20FINAL.md#list--video-placement-type-
 */
enum VideoPlacementType: int
{
    case INSTREAM = 1;
    case BANNER = 2;
    case ARTICLE = 3;
    case FEED = 4;
    case INTERSTITIAL = 5;
    case SLIDER = 6;
    case FLOATING = 7;
}
