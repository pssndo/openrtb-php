<?php

declare(strict_types=1);

namespace OpenRTB\v25\Enums;

/**
 * Native Data Asset Types - AdCOM List: Native Data Asset Types.
 *
 * @see https://iabtechlab.com/wp-content/uploads/2016/03/OpenRTB-API-Specification-Version-2-5-FINAL.pdf
 */
enum NativeDataAssetType: int
{
    case SPONSORED = 1;
    case DESC = 2;
    case RATING = 3;
    case LIKES = 4;
    case DOWNLOADS = 5;
    case PRICE = 6;
    case SALEPRICE = 7;
    case PHONE = 8;
    case ADDRESS = 9;
    case DESC2 = 10;
    case DISPLAYURL = 11;
    case CTATEXT = 12;
}
