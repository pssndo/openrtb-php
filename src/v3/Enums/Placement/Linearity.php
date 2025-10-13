<?php

declare(strict_types=1);

namespace OpenRTB\v3\Enums\Placement;

/**
 * The following table lists the options for video linearity.
 *
 * @see https://github.com/InteractiveAdvertisingBureau/AdCOM/blob/master/AdCOM%20v1.0%20FINAL.md#list--linearity-modes-
 */
enum Linearity: int
{
    case LINEAR = 1;
    case NON_LINEAR = 2;
}
