<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use OpenRTB\Factory\OpenRTBFactory;

/**
 * OpenRTB Version Comparison
 *
 * This example demonstrates the key differences between OpenRTB 2.6 and 3.0
 * when building requests and responses.
 */

echo "=== OpenRTB Version Comparison: 2.6 vs 3.0 ===\n\n";

// ============================================================================
// Example 1: Basic Display Banner Request
// ============================================================================

echo "Example 1: Display Banner Request (300x250)\n";
echo str_repeat('=', 70) . "\n\n";

// OpenRTB 2.6
echo "OpenRTB 2.6:\n";
echo str_repeat('-', 70) . "\n";

$factory26 = new OpenRTBFactory('2.6');
$builder26 = $factory26->createRequestBuilder();

$request26 = $builder26
    ->setId('req-12345')
    ->setTmax(100)
    ->addImp(
        (new \OpenRTB\v26\Impression\Imp())
            ->setId('imp-1')
            ->setBanner(
                (new \OpenRTB\v26\Impression\Banner())
                    ->setW(300)
                    ->setH(250)
                    ->setPos(1)
            )
    )
    ->setSite(
        (new \OpenRTB\v26\Context\Site())
            ->setDomain('example.com')
            ->setPage('https://example.com/article')
    )();

echo "Structure: BidRequest > Imp > Banner\n";
echo "Key fields:\n";
echo "  - imp[].id: Impression identifier\n";
echo "  - imp[].banner: Banner object with w/h/pos\n";
echo "  - site: Site object at root level\n\n";
echo "JSON Size: " . strlen($request26->toJson()) . " bytes\n";
echo json_encode($request26->toArray(), JSON_PRETTY_PRINT) . "\n\n";

// OpenRTB 3.0
echo "OpenRTB 3.0:\n";
echo str_repeat('-', 70) . "\n";

$factory30 = new OpenRTBFactory('3.0');
$builder30 = $factory30->createRequestBuilder();

$request30 = $builder30
    ->setId('req-12345')
    ->setTmax(100)
    ->addItem(
        (new \OpenRTB\v3\Impression\Item())
            ->setId('item-1')
            ->setQty(1)
            ->setSpec(
                (new \OpenRTB\v3\Impression\Spec())
                    ->setPlacement(
                        (new \OpenRTB\v3\Placement\Placement())
                            ->setTagid('banner-300x250')
                            ->setDisplay(
                                (new \OpenRTB\v3\Placement\DisplayPlacement())
                                    ->setW(300)
                                    ->setH(250)
                                    ->setPos(\OpenRTB\v3\Enums\Placement\AdPosition::ABOVE_FOLD)
                            )
                    )
            )
    )
    ->setContext(
        (new \OpenRTB\v3\Context\Context())
            ->setSite(
                (new \OpenRTB\v3\Context\Site())
                    ->setDomain('example.com')
                    ->setPage('https://example.com/article')
            )
    )();

echo "Structure: Request > Item > Spec > Placement > Display\n";
echo "Key fields:\n";
echo "  - item[].id: Item identifier (replaces imp)\n";
echo "  - item[].qty: Quantity of items\n";
echo "  - item[].spec.placement: Placement specification\n";
echo "  - context: Context object (moved from root)\n\n";
echo "JSON Size: " . strlen($request30->toJson()) . " bytes\n";
echo json_encode($request30->toArray(), JSON_PRETTY_PRINT) . "\n\n";

// ============================================================================
// Example 2: Bid Response
// ============================================================================

echo "Example 2: Bid Response\n";
echo str_repeat('=', 70) . "\n\n";

// OpenRTB 2.6
echo "OpenRTB 2.6:\n";
echo str_repeat('-', 70) . "\n";

$response26 = (new \OpenRTB\v26\BidResponse())
    ->setId('req-12345')
    ->setBidid('resp-67890')
    ->setCur('USD')
    ->setSeatbid([
        (new \OpenRTB\v26\Response\SeatBid())
            ->setSeat('advertiser-seat')
            ->setBid([
                (new \OpenRTB\v26\Response\Bid())
                    ->setId('bid-1')
                    ->setImpid('imp-1')  // References impression ID
                    ->setPrice(2.50)
                    ->setAdm('<a href=""><img src="" alt=""/></a>')  // HTML creative
                    ->setW(300)
                    ->setH(250)
            ])
    ]);

echo "Structure: BidResponse > SeatBid > Bid\n";
echo "Key fields:\n";
echo "  - seatbid[].bid[].impid: References imp[].id from request\n";
echo "  - seatbid[].bid[].adm: Ad markup (HTML/VAST/Native JSON)\n";
echo "  - seatbid[].bid[].w/h: Creative dimensions\n\n";
echo json_encode($response26->toArray(), JSON_PRETTY_PRINT) . "\n\n";

// OpenRTB 3.0
echo "OpenRTB 3.0:\n";
echo str_repeat('-', 70) . "\n";

$response30 = (new \OpenRTB\v3\BidResponse())
    ->setId('req-12345')
    ->setBidid('resp-67890')
    ->setCur('USD')
    ->setSeatbid([
        (new \OpenRTB\v3\Bid\Seatbid())
            ->setSeat('advertiser-seat')
            ->addBid(
                (new \OpenRTB\v3\Bid\Bid())
                    ->setId('bid-1')
                    ->set('item', 'item-1')  // References item ID (not impid)
                    ->setPrice(2.50)
                    ->setMedia(  // Media object (not adm string)
                        (new \OpenRTB\v3\Bid\Media())
                            ->setAd(
                                (new \OpenRTB\v3\Bid\Ad())
                                    ->setAdomain(['advertiser.com'])
                                    ->setDisplay(
                                        (new \OpenRTB\v3\Bid\Display())
                                            ->setBanner(
                                                (new \OpenRTB\v3\Bid\Display\Banner())
                                                    ->setImg('https://cdn.advertiser.com/ad.jpg')
                                                    ->setW(300)
                                                    ->setH(250)
                                                    ->setLink(
                                                        (new \OpenRTB\v3\Bid\Link())
                                                            ->setUrl('https://advertiser.com/click')
                                                    )
                                            )
                                    )
                            )
                    )
            )
    ]);

echo "Structure: BidResponse > Seatbid > Bid > Media > Ad\n";
echo "Key fields:\n";
echo "  - seatbid[].bid[].item: References item[].id from request\n";
echo "  - seatbid[].bid[].media: Structured media object (not string)\n";
echo "  - media.ad.display: Structured display creative\n\n";
echo json_encode($response30->toArray(), JSON_PRETTY_PRINT) . "\n\n";

// ============================================================================
// Key Differences Summary
// ============================================================================

echo "Key Differences Summary\n";
echo str_repeat('=', 70) . "\n\n";

$differences = [
    [
        'Aspect' => 'Request Structure',
        'OpenRTB 2.6' => 'Flat: imp[] at root level',
        'OpenRTB 3.0' => 'Nested: item[] > spec > placement'
    ],
    [
        'Aspect' => 'Context',
        'OpenRTB 2.6' => 'site/app/device at root',
        'OpenRTB 3.0' => 'Grouped in context object'
    ],
    [
        'Aspect' => 'Impression Identifier',
        'OpenRTB 2.6' => 'imp[].id',
        'OpenRTB 3.0' => 'item[].id'
    ],
    [
        'Aspect' => 'Media Specification',
        'OpenRTB 2.6' => 'banner/video/native objects',
        'OpenRTB 3.0' => 'spec.placement.display/video/audio'
    ],
    [
        'Aspect' => 'Bid Reference',
        'OpenRTB 2.6' => 'bid[].impid',
        'OpenRTB 3.0' => 'bid[].item'
    ],
    [
        'Aspect' => 'Creative Markup',
        'OpenRTB 2.6' => 'bid[].adm (string)',
        'OpenRTB 3.0' => 'bid[].media (structured)'
    ],
    [
        'Aspect' => 'Ad Domain',
        'OpenRTB 2.6' => 'bid[].adomain[]',
        'OpenRTB 3.0' => 'media.ad.adomain[]'
    ],
    [
        'Aspect' => 'Quantity',
        'OpenRTB 2.6' => 'Not supported',
        'OpenRTB 3.0' => 'item[].qty (multi-item bidding)'
    ],
];

// Print table
printf("%-25s | %-20s | %-20s\n", 'Aspect', 'OpenRTB 2.6', 'OpenRTB 3.0');
echo str_repeat('-', 70) . "\n";

foreach ($differences as $diff) {
    printf("%-25s | %-20s | %-20s\n", $diff['Aspect'], $diff['OpenRTB 2.6'], $diff['OpenRTB 3.0']);
}

echo "\n";

// ============================================================================
// Migration Tips
// ============================================================================

echo "Migration Tips: 2.6 → 3.0\n";
echo str_repeat('=', 70) . "\n\n";

echo "Request Migration:\n";
echo "  1. Replace 'imp' array with 'item' array\n";
echo "  2. Add 'qty: 1' to each item\n";
echo "  3. Wrap banner/video/native in: item.spec.placement.display/video\n";
echo "  4. Move site/app/device into 'context' object\n";
echo "  5. Rename 'imp.id' to 'item.id'\n\n";

echo "Response Migration:\n";
echo "  1. Rename bid.impid to bid.item\n";
echo "  2. Wrap bid.adm in structured media.ad object\n";
echo "  3. For display: Convert HTML to media.ad.display structure\n";
echo "  4. Move bid.adomain to media.ad.adomain\n";
echo "  5. Convert bid.w/h to media.ad.display.banner.w/h\n\n";

echo "Using the Factory Pattern:\n";
echo "  - Factory automatically handles version differences\n";
echo "  - Use OpenRTBFactory::forProvider('partner') for automatic version\n";
echo "  - Parser/Builder abstracts the complexity\n";
echo "  - Same code works with both versions!\n\n";

echo "=== Version Comparison Complete ===\n";
