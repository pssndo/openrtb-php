<?php

declare(strict_types=1);

namespace OpenRTB\v3\Enums\Placement;

/**
 * @see https://iabtechlab.com/wp-content/uploads/2022/04/OpenRTB-3.0-Framework-FINAL.pdf#page=68
 */
enum ContextType: int
{
    case CONTENT = 1;
    case SOCIAL = 2;
    case PRODUCT = 3;
    case USER_GENERATED_CONTENT = 4;
    case SOCIAL_CENTRIC_FEED = 5;
}