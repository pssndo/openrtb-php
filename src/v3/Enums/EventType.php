<?php

declare(strict_types=1);

namespace OpenRTB\v3\Enums;

/**
 * The following table lists the types of events that can be tracked.
 * Used across both Bid and Placement contexts.
 *
 * @see https://github.com/InteractiveAdvertisingBureau/AdCOM/blob/master/AdCOM%20v1.0%20FINAL.md#list--event-types-
 * @see https://iabtechlab.com/wp-content/uploads/2022/04/OpenRTB-3.0-Framework-FINAL.pdf#page=60
 */
enum EventType: int
{
    case IMPRESSION = 1;
    case VIEWABLE_MRC50 = 2;
    case VIEWABLE_MRC100 = 3;
    case VIEWABLE_VIDEO50 = 4;
}