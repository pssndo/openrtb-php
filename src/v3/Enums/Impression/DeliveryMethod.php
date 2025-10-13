<?php

declare(strict_types=1);

namespace OpenRTB\v3\Enums\Impression;

/**
 * The following table lists the various delivery methods for an ad.
 *
 * @see https://github.com/InteractiveAdvertisingBureau/AdCOM/blob/master/AdCOM%20v1.0%20FINAL.md#list--delivery-methods-
 */
enum DeliveryMethod: int
{
    case PROGRAMMATIC = 0;
    case TAG = 1;
}
