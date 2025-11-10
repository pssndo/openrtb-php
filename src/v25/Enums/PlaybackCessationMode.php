<?php

declare(strict_types=1);

namespace OpenRTB\v25\Enums;

/**
 * Playback Cessation Mode - AdCOM List: Playback Cessation Modes.
 *
 * @see https://iabtechlab.com/wp-content/uploads/2016/03/OpenRTB-API-Specification-Version-2-5-FINAL.pdf
 */
enum PlaybackCessationMode: int
{
    case ON_VIDEO_COMPLETION_OR_TERMINATION = 1;
    case ON_LEAVING_VIEWPORT = 2;
    case ON_LEAVING_VIEWPORT_CONTINUES_UNTIL_COMPLETION = 3;
}
