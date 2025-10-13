<?php

declare(strict_types=1);

namespace OpenRTB\v3\Enums\Context;

/**
 * The following table lists the supported taxonomies for classifying content.
 *
 * @see https://github.com/InteractiveAdvertisingBureau/AdCOM/blob/master/AdCOM%20v1.0%20FINAL.md#list--content-taxonomies-
 */
enum ContentTaxonomy: int
{
    case IAB_CONTENT_CATEGORY_1_0 = 1;
    case IAB_CONTENT_CATEGORY_2_0 = 2;
    case IAB_AD_PRODUCT_TAXONOMY_1_0 = 3;
    case IAB_AUDIENCE_TAXONOMY_1_1 = 4;
    case IAB_CONTENT_TAXONOMY_2_1 = 5;
    case IAB_CONTENT_TAXONOMY_2_2 = 6;
    case IAB_CONTENT_TAXONOMY_3_0 = 7;
}
