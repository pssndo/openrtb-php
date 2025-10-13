<?php

declare(strict_types=1);

namespace OpenRTB\v3\Enums\Impression;

/**
 * The following table indicates the types of metrics that can be specified.
 *
 * @see https://github.com/InteractiveAdvertisingBureau/AdCOM/blob/master/AdCOM%20v1.0%20FINAL.md#list--metric-types-
 */
enum MetricType: int
{
    case VIEW_COUNTS = 1;
    case CLICKS = 2;
    case CONVERSIONS = 3;
}
