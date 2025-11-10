<?php

declare(strict_types=1);

namespace OpenRTB\v25\Enums;

/**
 * Video Placement Type - AdCOM List: Placement Subtype - Video.
 *
 * @see https://iabtechlab.com/wp-content/uploads/2016/03/OpenRTB-API-Specification-Version-2-5-FINAL.pdf
 */
enum VideoPlacementType: int
{
    case IN_STREAM = 1;
    case IN_BANNER = 2;
    case IN_ARTICLE = 3;
    case IN_FEED = 4;
    case INTERSTITIAL_SLIDER_FLOATING = 5;
}
