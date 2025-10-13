<?php

declare(strict_types=1);

namespace OpenRTB\v3\Enums;

enum AuctionType: int
{
    case FIRST_PRICE = 1;
    case SECOND_PRICE = 2;
    case FIXED_PRICE = 3;
}
