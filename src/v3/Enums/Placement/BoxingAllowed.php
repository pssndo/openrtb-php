<?php

declare(strict_types=1);

namespace OpenRTB\v3\Enums\Placement;

/**
 * The following table lists the options for whether boxing is allowed.
 *
 * @see https://github.com/InteractiveAdvertisingBureau/AdCOM/blob/master/AdCOM%20v1.0%20FINAL.md#list--boxing-allowed-
 */
enum BoxingAllowed: int
{
    case NOT_ALLOWED = 0;
    case ALLOWED = 1;
}
