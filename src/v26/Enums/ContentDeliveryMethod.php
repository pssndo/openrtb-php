<?php

declare(strict_types=1);

namespace OpenRTB\v26\Enums;

/**
 * Content Delivery Methods - AdCOM List: Content Delivery Methods.
 *
 * @see https://iabtechlab.com/wp-content/uploads/2022/04/OpenRTB-2-6_FINAL.pdf
 */
enum ContentDeliveryMethod: int
{
    case STREAMING = 1;
    case PROGRESSIVE = 2;
    case DOWNLOAD = 3;
}
