<?php

declare(strict_types=1);

namespace OpenRTB\v25\Enums;

/**
 * QAG Media Ratings - AdCOM List: Media Ratings.
 *
 * @see https://iabtechlab.com/wp-content/uploads/2016/03/OpenRTB-API-Specification-Version-2-5-FINAL.pdf
 */
enum QAGMediaRating: int
{
    case ALL_AUDIENCES = 1;
    case EVERYONE_OVER_12 = 2;
    case MATURE_AUDIENCES = 3;
}
