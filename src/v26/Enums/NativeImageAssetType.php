<?php

declare(strict_types=1);

namespace OpenRTB\v26\Enums;

/**
 * Native Image Asset Types - AdCOM List: Native Image Asset Types.
 *
 * @see https://iabtechlab.com/wp-content/uploads/2022/04/OpenRTB-2-6_FINAL.pdf
 */
enum NativeImageAssetType: int
{
    case ICON = 1;
    case LOGO = 2;
    case MAIN_IMAGE = 3;
}
