<?php

declare(strict_types=1);

namespace OpenRTB\v3\Enums\Placement;

/**
 * The following table lists the various video playback methods.
 *
 * @see https://github.com/InteractiveAdvertisingBureau/AdCOM/blob/master/AdCOM%20v1.0%20FINAL.md#list--playback-methods-
 */
enum PlaybackMethod: int
{
    case ON_PAGE_LOAD_SOUND_ON = 1;
    case ON_PAGE_LOAD_SOUND_OFF = 2;
    case ON_CLICK_SOUND_ON = 3;
    case ON_MOUSE_OVER_SOUND_ON = 4;
    case ON_ENTERING_VIEWPORT_SOUND_ON = 5;
    case ON_ENTERING_VIEWPORT_SOUND_OFF = 6;
}
