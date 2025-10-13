<?php

declare(strict_types=1);

namespace OpenRTB\v3\Enums\Placement;

/**
 * The following table lists the types of companion ads that can be included.
 *
 * @see https://github.com/InteractiveAdvertisingBureau/AdCOM/blob/master/AdCOM%20v1.0%20FINAL.md#list--companion-type-
 */
enum CompanionType: int
{
    case STATIC_RESOURCE = 1;
    case HTML_RESOURCE = 2;
    case IFRAME_RESOURCE = 3;
}
