<?php

declare(strict_types=1);

namespace OpenRTB\v26\Enums;

/**
 * Protocols - AdCOM List: Creative Subtypes - Video/Audio
 * @see https://iabtechlab.com/wp-content/uploads/2022/04/OpenRTB-2-6_FINAL.pdf
 */
enum Protocol: int
{
    case VAST_1_0 = 1;
    case VAST_2_0 = 2;
    case VAST_3_0 = 3;
    case VAST_1_0_WRAPPER = 4;
    case VAST_2_0_WRAPPER = 5;
    case VAST_3_0_WRAPPER = 6;
    case VAST_4_0 = 7;
    case VAST_4_0_WRAPPER = 8;
    case DAAST_1_0 = 9;
    case DAAST_1_0_WRAPPER = 10;
    case VAST_4_1 = 11;
    case VAST_4_1_WRAPPER = 12;
    case VAST_4_2 = 13;
    case VAST_4_2_WRAPPER = 14;
}
