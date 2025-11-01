<?php

declare(strict_types=1);

namespace OpenRTB\v26\Enums;

/**
 * @see https://iabtechlab.com/wp-content/uploads/2022/04/OpenRTB-2-6_FINAL.pdf#page=22
 */
enum AuctionType: int
{
    case FIRST_PRICE = 1;
    case SECOND_PRICE_PLUS = 2;
}