<?php

declare(strict_types=1);

namespace OpenRTB\v25\Enums;

/**
 * Companion Ad Types - AdCOM List: Companion Types.
 *
 * @see https://iabtechlab.com/wp-content/uploads/2016/03/OpenRTB-API-Specification-Version-2-5-FINAL.pdf
 */
enum CompanionType: int
{
    case STATIC_RESOURCE = 1;
    case HTML_RESOURCE = 2;
    case IFRAME_RESOURCE = 3;
}
