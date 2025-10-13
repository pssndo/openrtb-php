<?php

declare(strict_types=1);

namespace OpenRTB\v3\Enums\Placement;

/**
 * The following table lists the types of events that can be tracked.
 *
 * @see https://github.com/InteractiveAdvertisingBureau/AdCOM/blob/master/AdCOM%20v1.0%20FINAL.md#list--event-types-
 */
enum EventType: int
{
    case IMPRESSION = 1;
    case VIEWABLE_MRC50 = 2;
    case VIEWABLE_MRC100 = 3;
    case VIEWABLE_VIDEO50 = 4;
}
