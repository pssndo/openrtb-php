<?php

declare(strict_types=1);

namespace OpenRTB\v25\Enums;

/**
 * Video Linearity - AdCOM List: Linearity.
 *
 * @see https://iabtechlab.com/wp-content/uploads/2016/03/OpenRTB-API-Specification-Version-2-5-FINAL.pdf
 */
enum VideoLinearity: int
{
    case LINEAR_IN_STREAM = 1;
    case NON_LINEAR_OVERLAY = 2;
}
