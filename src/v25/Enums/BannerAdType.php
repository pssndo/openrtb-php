<?php

declare(strict_types=1);

namespace OpenRTB\v25\Enums;

/**
 * Banner Ad Types - AdCOM List: Banner Ad Types.
 *
 * @see https://iabtechlab.com/wp-content/uploads/2016/03/OpenRTB-API-Specification-Version-2-5-FINAL.pdf
 */
enum BannerAdType: int
{
    case XHTML_TEXT_AD = 1;
    case XHTML_BANNER_AD = 2;
    case JAVASCRIPT_AD = 3;
    case IFRAME = 4;
}
