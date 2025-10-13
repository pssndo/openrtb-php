<?php

declare(strict_types=1);

namespace OpenRTB\v3\Enums\Placement;

/**
 * The following table lists the various context types for display ads.
 *
 * @see https://github.com/InteractiveAdvertisingBureau/AdCOM/blob/master/AdCOM%20v1.0%20FINAL.md#list--context-type-
 */
enum ContextType: int
{
    case CONTENT = 1;
    case SOCIAL = 2;
    case PRODUCT = 3;
}
