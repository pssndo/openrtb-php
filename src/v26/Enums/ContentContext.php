<?php

declare(strict_types=1);

namespace OpenRTB\v26\Enums;

/**
 * Content Context - AdCOM List: Content Context.
 *
 * @see https://iabtechlab.com/wp-content/uploads/2022/04/OpenRTB-2-6_FINAL.pdf
 */
enum ContentContext: int
{
    case VIDEO = 1;
    case GAME = 2;
    case MUSIC = 3;
    case APPLICATION = 4;
    case TEXT = 5;
    case OTHER = 6;
    case UNKNOWN = 7;
}
