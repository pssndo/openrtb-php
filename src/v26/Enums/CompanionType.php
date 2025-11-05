<?php

declare(strict_types=1);

namespace OpenRTB\v26\Enums;

/**
 * Companion Ad Types - AdCOM List: Companion Types.
 *
 * @see https://iabtechlab.com/wp-content/uploads/2022/04/OpenRTB-2-6_FINAL.pdf
 */
enum CompanionType: int
{
    case STATIC_RESOURCE = 1;
    case HTML_RESOURCE = 2;
    case IFRAME_RESOURCE = 3;
}
