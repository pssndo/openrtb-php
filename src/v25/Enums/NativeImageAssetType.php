<?php

declare(strict_types=1);

namespace OpenRTB\v25\Enums;

/**
 * Native Image Asset Types - AdCOM List: Native Image Asset Types.
 *
 * @see https://iabtechlab.com/wp-content/uploads/2016/03/OpenRTB-API-Specification-Version-2-5-FINAL.pdf
 */
enum NativeImageAssetType: int
{
    case ICON = 1;
    case LOGO = 2;
    case MAIN_IMAGE = 3;
}
