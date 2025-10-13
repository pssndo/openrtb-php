<?php

declare(strict_types=1);

namespace OpenRTB\v3\Enums\Placement;

/**
 * The following table lists the various playback cessation modes for a video ad.
 *
 * @see https://github.com/InteractiveAdvertisingBureau/AdCOM/blob/master/AdCOM%20v1.0%20FINAL.md#list--playback-cessation-modes-
 */
enum PlaybackCessationMode: int
{
    case ON_VIDEO_COMPLETION = 1;
    case ON_LEAVING_VIEWPORT = 2;
    case ON_LEAVING_VIEWPORT_CONTINUES_FLOATING = 3;
}
