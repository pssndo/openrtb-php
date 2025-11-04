<?php

declare(strict_types=1);

namespace OpenRTB\v26\Enums;

/**
 * Video Linearity - AdCOM List: Linearity
 * @see https://iabtechlab.com/wp-content/uploads/2022/04/OpenRTB-2-6_FINAL.pdf
 */
enum VideoLinearity: int
{
    case LINEAR_IN_STREAM = 1;
    case NON_LINEAR_OVERLAY = 2;
}
