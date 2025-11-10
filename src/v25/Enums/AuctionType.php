<?php

declare(strict_types=1);

namespace OpenRTB\v25\Enums;

/**
 * @see https://iabtechlab.com/wp-content/uploads/2016/03/OpenRTB-API-Specification-Version-2-5-FINAL.pdf#page=22
 */
enum AuctionType: int
{
    case FIRST_PRICE = 1;
    case SECOND_PRICE_PLUS = 2;
}
