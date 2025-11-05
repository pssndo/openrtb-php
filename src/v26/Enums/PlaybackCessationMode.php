<?php

declare(strict_types=1);

namespace OpenRTB\v26\Enums;

/**
 * Playback Cessation Mode - AdCOM List: Playback Cessation Modes.
 *
 * @see https://iabtechlab.com/wp-content/uploads/2022/04/OpenRTB-2-6_FINAL.pdf
 */
enum PlaybackCessationMode: int
{
    case ON_VIDEO_COMPLETION_OR_TERMINATION = 1;
    case ON_LEAVING_VIEWPORT = 2;
    case ON_LEAVING_VIEWPORT_CONTINUES_UNTIL_COMPLETION = 3;
}
