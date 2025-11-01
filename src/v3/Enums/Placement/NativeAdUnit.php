<?php

declare(strict_types=1);

namespace OpenRTB\v3\Enums\Placement;

/**
 * The native ad unit ID of the ad unit.
 *
 * @see https://iabtechlab.com/wp-content/uploads/2022/04/OpenRTB-3.0-Framework-FINAL.pdf#page=69
 */
enum NativeAdUnit: int
{
    case AD_UNIT_ID_PAID_SEARCH_UNITS = 1;
    case AD_UNIT_ID_RECOMMENDATION_WIDGETS = 2;
    case AD_UNIT_ID_PROMOTED_LISTINGS = 3;
    case AD_UNIT_ID_IN_AD_WITH_NATIVE_ELEMENT_UNITS = 4;
    case AD_UNIT_ID_CUSTOM_CAN_NOT_BE_CONTAINED = 5;
    case AD_UNIT_ID_IN_FEED_AD = 11;
    case AD_UNIT_ID_IN_ATOMIC_UNIT_OF_CONTENT = 12;
    case AD_UNIT_ID_OUTSIDE_CORE_CONTENT = 13;
    case AD_UNIT_ID_500_PLUS = 500;
}