<?php

declare(strict_types=1);

namespace OpenRTB\v26\Enums;

/**
 * Creative Attributes - AdCOM List: Creative Attributes.
 *
 * @see https://iabtechlab.com/wp-content/uploads/2022/04/OpenRTB-2-6_FINAL.pdf
 */
enum CreativeAttribute: int
{
    case AUDIO_AD_AUTO_PLAY = 1;
    case AUDIO_AD_USER_INITIATED = 2;
    case EXPANDABLE_AUTOMATIC = 3;
    case EXPANDABLE_USER_INITIATED_CLICK = 4;
    case EXPANDABLE_USER_INITIATED_ROLLOVER = 5;
    case IN_BANNER_VIDEO_AD_AUTO_PLAY = 6;
    case IN_BANNER_VIDEO_AD_USER_INITIATED = 7;
    case POP = 8;
    case PROVOCATIVE_OR_SUGGESTIVE_IMAGERY = 9;
    case SHAKY_FLASHING_FLICKERING_EXTREME_ANIMATION = 10;
    case SURVEYS = 11;
    case TEXT_ONLY = 12;
    case USER_INTERACTIVE = 13;
    case WINDOWS_DIALOG_OR_ALERT_STYLE = 14;
    case HAS_AUDIO_ON_OFF_BUTTON = 15;
    case AD_PROVIDES_SKIP_BUTTON = 16;
    case ADOBE_FLASH = 17;
    case RESPONSIVE = 18;
}
