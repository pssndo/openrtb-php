<?php

declare(strict_types=1);

namespace OpenRTB\v26\Enums;

/**
 * QAG Media Ratings - AdCOM List: Media Ratings.
 *
 * @see https://iabtechlab.com/wp-content/uploads/2022/04/OpenRTB-2-6_FINAL.pdf
 */
enum QAGMediaRating: int
{
    case ALL_AUDIENCES = 1;
    case EVERYONE_OVER_12 = 2;
    case MATURE_AUDIENCES = 3;
}
