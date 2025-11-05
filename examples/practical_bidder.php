<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use OpenRTB\Factory\OpenRTBFactory;
use OpenRTB\Factory\ProviderRegistry;
use OpenRTB\v26\BidRequest;
use OpenRTB\v26\BidResponse;
use OpenRTB\v26\Response\Bid;
use OpenRTB\v26\Response\SeatBid;
use OpenRTB\v3\Bid\Ad;
use OpenRTB\v3\Bid\Display;
use OpenRTB\v3\Bid\Display\Banner;
use OpenRTB\v3\Bid\Link;
use OpenRTB\v3\Bid\Media;
use OpenRTB\v3\Enums\NoBidReason;

/**
 * Practical Bidder Implementation
 *
 * This example shows a complete, production-ready bidder that:
 * - Accepts bid requests from multiple SSPs
 * - Validates requests
 * - Makes intelligent bidding decisions
 * - Handles both OpenRTB 2.6 and 3.0 seamlessly
 * - Returns appropriate responses
 */

echo "=== Practical Bidder Implementation ===\n\n";

// ============================================================================
// Configuration
// ============================================================================

// Register SSP partners
$registry = ProviderRegistry::getInstance();
$registry->registerBatch([
    'google' => '2.6',
    'appnexus' => '2.6',
    'rubicon' => '2.6',
    'openx' => '2.6',
    'pubmatic' => '2.6',
    'index' => '3.0',
    'magnite' => '3.0',
]);

// Bidder configuration
$config = [
    'seat_id' => 'my-dsp-seat-123',
    'default_currency' => 'USD',
    'timeout_ms' => 100,
    'min_cpm' => 0.10,
    'max_cpm' => 50.00,
];

// ============================================================================
// Bidder Class
// ============================================================================

class Bidder
{
    private array $config;
    protected array $errors = [];
    private ?OpenRTBFactory $factory = null;
    private \OpenRTB\v3\BidRequest|BidRequest|null $bidRequest;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * Main handler: receives raw JSON, returns bid response JSON
     */
    public function handleRequest(string $sspName, string $requestJson): string
    {
        echo "Processing request from: {$sspName}\n";

        try {
            // Step 1: Create version-appropriate factory
            $this->factory = OpenRTBFactory::forProvider($sspName);
            echo "Using OpenRTB {$this->factory->getVersion()}\n";

            // Step 2: Parse request
            $parser = $this->factory->createParser();
            $this->bidRequest = $parser->parseBidRequest($requestJson);

            // Step 3: Validate request
            if (!$this->validateRequest()) {
                return $this->buildNoBidResponse('validation_failed');
            }

            // Step 4: Evaluate and bid
            $bids = $this->evaluateAndBid();

            // Step 5: Build response
            if (empty($bids)) {
                return $this->buildNoBidResponse('no_suitable_inventory');
            }

            return $this->buildBidResponse($bids);

        } catch (Exception $e) {
            echo "Error: {$e->getMessage()}\n";
            return $this->buildNoBidResponse('internal_error');
        }
    }

    /**
     * Validate incoming bid request
     */
    private function validateRequest(): bool
    {
        $validator = $this->factory->createValidator();

        // Call version-appropriate validation method
        if ($this->factory->getVersion() === '3.0') {
            $validator->validateRequest($this->bidRequest);
        } else {
            $validator->validateBidRequest($this->bidRequest);
        }

        if ($validator->hasErrors()) {
            $this->errors = $validator->getErrors();
            echo "Validation failed: " . $validator->getFirstError() . "\n";
            return false;
        }

        echo "✓ Request validated\n";
        return true;
    }

    /**
     * Build no-bid response
     * @throws JsonException
     */
    private function buildNoBidResponse(string $reason): string
    {
        echo "No bid: {$reason}\n";

        $version = $this->factory->getVersion();

        if ($version === '3.0') {
            $response = (new \OpenRTB\v3\BidResponse())
                ->setId($this->bidRequest?->getId() ?? 'unknown')
                ->setNbr(NoBidReason::TECHNICAL_ERROR);
        } else {
            $response = (new BidResponse())
                ->setId($this->bidRequest?->getId() ?? 'unknown')
                ->setNbr(0); // No bid
        }

        return $response->toJson();
    }

    /**
     * Evaluate opportunities and make bidding decisions
     */
    private function evaluateAndBid(): array
    {
        $bids = [];
        $version = $this->factory->getVersion();

        if ($version === '3.0') {
            // Handle OpenRTB 3.0 items
            $items = $this->bidRequest->getItem();
            if (!$items) {
                return [];
            }

            foreach ($items as $item) {
                $bid = $this->evaluateItem30($item);
                if ($bid) {
                    $bids[] = $bid;
                }
            }

        } else {
            // Handle OpenRTB 2.6 impressions
            $imps = $this->bidRequest->getImp();
            if (!$imps) {
                return [];
            }

            foreach ($imps as $imp) {
                $bid = $this->evaluateImp26($imp);
                if ($bid) {
                    $bids[] = $bid;
                }
            }
        }

        echo "✓ Evaluated opportunities: " . count($bids) . " bids\n";
        return $bids;
    }

    /**
     * Evaluate OpenRTB 3.0 item
     */
    private function evaluateItem30($item): ?object
    {
        $spec = $item->getSpec();
        if (!$spec) {
            return null;
        }

        $placement = $spec->getPlacement();
        if (!$placement) {
            return null;
        }

        // Check floor price
        $floorPrice = $item->getFlr() ?? 0;
        $bidPrice = $this->calculateBidPrice($floorPrice);

        if ($bidPrice < $floorPrice || $bidPrice < $this->config['min_cpm']) {
            echo "  Item {$item->getId()}: Below floor (\${$bidPrice} < \${$floorPrice})\n";
            return null;
        }

        echo "  Item {$item->getId()}: Bidding \${$bidPrice}\n";

        // Build bid
        return (new \OpenRTB\v3\Bid\Bid())
            ->setId('bid-' . uniqid('', true))
            ->set('item', $item->getId())  // Use generic set() for item field
            ->setPrice($bidPrice)
            ->setMedia($this->getCreativeMedia30($placement));
    }

    /**
     * Calculate bid price (simplified logic)
     */
    private function calculateBidPrice(float $floor): float
    {
        // In production: ML model, historical data, user segments, etc.
        $baseCpm = 2.50;
        $bidPrice = max($baseCpm, $floor * 1.1);

        return min($bidPrice, $this->config['max_cpm']);
    }

    /**
     * Get creative media for OpenRTB 3.0
     */
    private function getCreativeMedia30($placement): object
    {
        $display = $placement->getDisplay();

        if ($display) {
            return (new Media())
                ->setAd(
                    (new Ad())
                        ->setAdomain(['advertiser.com'])
                        ->setDisplay(
                            (new Display())
                                ->setBanner(
                                    (new Banner())
                                        ->setImg('https://cdn.advertiser.com/banner-' . $display->getW() . 'x' . $display->getH() . '.jpg')
                                        ->setW($display->getW())
                                        ->setH($display->getH())
                                        ->setLink(
                                            (new Link())
                                                ->setUrl('https://advertiser.com/product')
                                        )
                                )
                        )
                );
        }

        // Fallback
        return (new Media());
    }

    /**
     * Evaluate OpenRTB 2.6 impression
     */
    private function evaluateImp26($imp): ?object
    {
        // Determine bid price based on floor
        $floorPrice = 0; // Imp doesn't have bidfloor in our implementation
        $bidPrice = $this->calculateBidPrice($floorPrice);

        if ($bidPrice < $this->config['min_cpm']) {
            echo "  Imp {$imp->getId()}: Below min CPM\n";
            return null;
        }

        echo "  Imp {$imp->getId()}: Bidding \${$bidPrice}\n";

        // Build bid
        $bid = (new Bid())
            ->setId('bid-' . uniqid('', true))
            ->setImpid($imp->getId())
            ->setPrice($bidPrice);

        // Add creative markup
        if ($imp->getBanner()) {
            $banner = $imp->getBanner();
            $bid->setAdm($this->getCreativeMarkup($banner->getW(), $banner->getH()));
            $bid->setW($banner->getW());
            $bid->setH($banner->getH());
        }

        return $bid;
    }

    /**
     * Get creative markup for OpenRTB 2.6
     */
    private function getCreativeMarkup(?int $w, ?int $h): string
    {
        // In production: retrieve from creative database
        return sprintf(
            '<a href="https://advertiser.com/click"><img src="https://cdn.advertiser.com/ad-%dx%d.jpg" width="%d" height="%d" alt=""/></a>',
            $w ?? 300,
            $h ?? 250,
            $w ?? 300,
            $h ?? 250
        );
    }

    /**
     * Build successful bid response
     */
    private function buildBidResponse(array $bids): string
    {
        $version = $this->factory->getVersion();

        if ($version === '3.0') {
            $seatbid = (new \OpenRTB\v3\Bid\Seatbid())
                ->setSeat($this->config['seat_id']);

            foreach ($bids as $bid) {
                $seatbid->addBid($bid);
            }

            $response = (new \OpenRTB\v3\BidResponse())
                ->setId($this->bidRequest->getId())
                ->setBidid('resp-' . uniqid('', true))
                ->setCur($this->config['default_currency'])
                ->setSeatbid([$seatbid]);

        } else {
            $seatbid = (new SeatBid())
                ->setSeat($this->config['seat_id'])
                ->setBid($bids);

            $response = (new BidResponse())
                ->setId($this->bidRequest->getId())
                ->setBidid('resp-' . uniqid('', true))
                ->setCur($this->config['default_currency'])
                ->setSeatbid([$seatbid]);
        }

        return $response->toJson();
    }
}

// ============================================================================
// Test the bidder with different SSPs
// ============================================================================

$bidder = new Bidder($config);

echo "Test 1: Google (OpenRTB 2.6)\n";
echo str_repeat('=', 60) . "\n";

$googleRequest = json_encode([
    'id' => 'google-req-001',
    'imp' => [
        [
            'id' => 'imp-1',
            'banner' => [
                'w' => 728,
                'h' => 90
            ]
        ]
    ],
    'site' => [
        'domain' => 'example.com'
    ]
], JSON_THROW_ON_ERROR);

$response = $bidder->handleRequest('google', $googleRequest);
echo "\nResponse:\n";
echo json_encode(json_decode($response, false, 512, JSON_THROW_ON_ERROR), JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT) . "\n\n";

echo "Test 2: Magnite (OpenRTB 3.0)\n";
echo str_repeat('=', 60) . "\n";

$magniteRequest = json_encode([
    'id' => 'magnite-req-001',
    'tmax' => 100,
    'item' => [
        [
            'id' => 'item-1',
            'qty' => 1,
            'flr' => 2.00,
            'flrcur' => 'USD',
            'spec' => [
                'placement' => [
                    'display' => [
                        'w' => 300,
                        'h' => 250
                    ]
                ]
            ]
        ]
    ]
], JSON_THROW_ON_ERROR);

$response = $bidder->handleRequest('magnite', $magniteRequest);
echo "\nResponse:\n";
echo json_encode(json_decode($response, false), JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT) . "\n\n";

echo "Test 3: Invalid Request\n";
echo str_repeat('=', 60) . "\n";

$invalidRequest = json_encode([
    'id' => 'invalid-req-001',
    // Missing required fields
]);

$response = $bidder->handleRequest('google', $invalidRequest);
echo "\nResponse:\n";
echo json_encode(json_decode($response), JSON_PRETTY_PRINT) . "\n\n";

echo "=== Practical Bidder Example Complete ===\n";
echo "\nKey Takeaways:\n";
echo "1. Single Bidder class handles both OpenRTB 2.6 and 3.0\n";
echo "2. Factory pattern abstracts version differences\n";
echo "3. Same business logic works across versions\n";
echo "4. Validation and error handling built-in\n";
echo "5. Production-ready structure for real implementations\n";
