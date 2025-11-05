<?php

declare(strict_types=1);

namespace OpenRTB\v26\Enums;

/**
 * Playback Methods - AdCOM List: Playback Methods.
 *
 * @see https://iabtechlab.com/wp-content/uploads/2022/04/OpenRTB-2-6_FINAL.pdf
 */
enum PlaybackMethod: int
{
    case AUTO_PLAY_SOUND_ON = 1;
    case AUTO_PLAY_SOUND_OFF = 2;
    case CLICK_TO_PLAY = 3;
    case MOUSE_OVER = 4;
    case ENTERING_VIEWPORT_SOUND_ON = 5;
    case ENTERING_VIEWPORT_SOUND_OFF = 6;
}
