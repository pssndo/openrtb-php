<?php

declare(strict_types=1);

namespace OpenRTB\v3\Enums\Placement;

/**
 * The following table lists the options for the type of click.
 *
 * @see https://github.com/InteractiveAdvertisingBureau/AdCOM/blob/master/AdCOM%20v1.0%20FINAL.md#list--click-type-
 */
enum ClickType: int
{
    case NON_CLICKABLE = 0;
    case CLICKABLE = 1;
}
