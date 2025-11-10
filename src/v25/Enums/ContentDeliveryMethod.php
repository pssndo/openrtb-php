<?php

declare(strict_types=1);

namespace OpenRTB\v25\Enums;

/**
 * Content Delivery Methods - AdCOM List: Content Delivery Methods.
 *
 * @see https://iabtechlab.com/wp-content/uploads/2016/03/OpenRTB-API-Specification-Version-2-5-FINAL.pdf
 */
enum ContentDeliveryMethod: int
{
    case STREAMING = 1;
    case PROGRESSIVE = 2;
    case DOWNLOAD = 3;
}
