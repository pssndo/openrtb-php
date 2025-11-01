<?php

declare(strict_types=1);

namespace OpenRTB\v3\Enums\Bid;

/**
 * @see https://iabtechlab.com/wp-content/uploads/2022/04/OpenRTB-3.0-Framework-FINAL.pdf#page=60
 */
enum Status: int
{
    case PENDING_AUDIT = 1;
    case PRE_APPROVED = 2;
    case APPROVED = 3;
    case DENIED = 4;
}