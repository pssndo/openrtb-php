<?php

declare(strict_types=1);

namespace OpenRTB\v25\Enums;

/**
 * Content Context - AdCOM List: Content Context.
 *
 * @see https://iabtechlab.com/wp-content/uploads/2016/03/OpenRTB-API-Specification-Version-2-5-FINAL.pdf
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
