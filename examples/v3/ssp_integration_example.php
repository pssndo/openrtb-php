<?php

declare(strict_types=1);

/**
 * OpenRTB 3.0 PHP Library - Complete SSP Integration Example
 */

// In a real project, you would include Composer's autoloader.
require_once __DIR__ . '/../../vendor/autoload.php';

use OpenRTB\v3\Bid\Ad;
use OpenRTB\v3\Bid\{Media};
use OpenRTB\v3\Bid\Display;
use OpenRTB\v3\Bid\Bid;
use OpenRTB\v3\Bid\Seatbid;
use OpenRTB\v3\Enums\NoBidReason;
use OpenRTB\v3\Impression\Item;
use OpenRTB\v3\Util\Parser;
use OpenRTB\v3\Util\ResponseBuilder;
use OpenRTB\v3\Util\Validator;

class SSPIntegration
{
    private Validator $validator;

    public function __construct()
    {
        $this->validator = new Validator();
    }

    /**
     * Handles an incoming JSON bid request from an exchange or bidder.
     */
    public function handleBidRequest(string $jsonRequest): string
    {
        // 1. Parse the incoming JSON into a Request object.
        $request = Parser::parseBidRequest($jsonRequest);

        // 2. Validate the request against the OpenRTB specification.
        if (!$this->validator->validateRequest($request)) {
            $errors = implode(', ', $this->validator->getErrors());
            return $this->buildNoBidResponse($request->getId(), NoBidReason::INVALID_REQUEST, $errors);
        }

        $requestId = $request->getId();
        $items = $request->getItem();

        // If there are no items, there's nothing to bid on. A Collection object is never "empty".
        if ($items === null || $items->count() === 0) {
            return $this->buildNoBidResponse($requestId, NoBidReason::INVALID_REQUEST, 'Request contains no items');
        }

        // 3. Process each item and decide whether to create a bid.
        // The bids must be grouped by seat ID into Seatbid objects.
        $responseBuilder = new ResponseBuilder($requestId);
        $bidsBySeat = [];

        foreach ($items as $item) {
            // In a real SSP, this is where you would run your internal auction,
            // query demand partners, and apply business logic.
            $bid = $this->createBidForItem($item);

            if ($bid !== null) {
                // Group bids by seat. For simplicity, all bids go to a single seat.
                // In a real SSP, you might have different seats for different demand partners.
                $seatId = 'default-seat';
                if (!isset($bidsBySeat[$seatId])) {
                    $bidsBySeat[$seatId] = [];
                }
                $bidsBySeat[$seatId][] = $bid;
            }
        }

        // 4. If we have bids, build a complete response. Otherwise, send a no-bid.
        if (!empty($bidsBySeat)) {
            foreach ($bidsBySeat as $seatId => $bids) {
                $seatbid = new Seatbid();
                $seatbid->setSeat($seatId);
                foreach ($bids as $bid) {
                    $seatbid->addBid($bid);
                }
                $responseBuilder->addSeatbid($seatbid);
            }
            $responseBuilder->setCurrency('USD');
            $response = $responseBuilder->build();
            return json_encode($response, JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        }

        return $this->buildNoBidResponse($requestId, NoBidReason::UNMATCHED_USER, 'No matching demand for the requested items');
    }

    /**
     * A placeholder for your business logic to create a bid for a given item.
     */
    private function createBidForItem(Item $item): ?Bid
    {
        // Example logic: Only bid on items with a floor price below $2.00
        $floorPrice = $item->getFlr() ?? 0;
        if ($floorPrice > 2.00) {
            return null;
        }

        // Calculate a bid price (e.g., 50% above the floor).
        $bidPrice = $floorPrice * 1.5;

        // Create a simple display ad for the bid.
        $banner = (new Display\Banner())
            ->setImg('https://cdn.example.com/ad.jpg')
            ->setW(300)
            ->setH(250);

        $displayAd = (new Display())->setBanner($banner);

        $ad = (new Ad())
            ->setId('ad-' . uniqid('', true))
            ->setAdomain(['example.com'])
            ->setDisplay($displayAd);

        $media = (new Media())->setAd($ad);

        $bid = (new Bid())
            ->setId('ssp-bid-' . uniqid('', true))
            ->setPrice($bidPrice)
            ->setMedia($media);

        // Use the generic set() method for properties not yet implemented
        $bid->set('item', $item->getId()); // Link to the request item ID
        $bid->set('cid', 'creative-id-12345'); // Campaign ID

        return $bid;
    }

    private function buildNoBidResponse(string $requestId, NoBidReason $reason, string $details = ''): string
    {
        $builder = new ResponseBuilder($requestId);
        $builder->setNoBidReason($reason);
        $response = $builder->build();

        // You can add custom extensions to provide more details.
        if ($details) {
            $response->set('ext', ['details' => $details]);
        }

        return json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    }

    private function buildErrorResponse(string $message): string
    {
        // Note: This is not a valid OpenRTB response, but a simple error message.
        // A real SSP might return an empty 204 or a specific error format.
        http_response_code(400);
        return json_encode(['error' => $message], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    }
}

// --- Example Usage ---

$ssp = new SSPIntegration();

// Simulate an incoming request
$incomingJson = <<<'JSON'
{
  "id": "ssp-test-request",
  "at": 2,
  "item": [
    {
      "id": "item-1",
      "flr": 1.50
    },
    {
      "id": "item-2",
      "flr": 2.50
    }
  ]
}
JSON;

// Handle the request and get the response
$responseJson = $ssp->handleBidRequest($incomingJson);

// Output the result
header('Content-Type: application/json; charset=utf-8');
echo $responseJson;
