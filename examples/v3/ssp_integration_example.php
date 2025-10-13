<?php

/**
 * OpenRTB 3.0 PHP Library - Complete SSP Integration Example
 */

// In a real project, you would include Composer's autoloader.
require_once __DIR__ . '/../../../../vendor/autoload.php';

use src\v3\{Bid\Bid, Util\Parser};
use src\v3\Bid\{Media};
use src\v3\Bid\Ad;
use src\v3\Bid\DisplayAd;
use src\v3\Bid\Seatbid;
use src\v3\Enums\NoBidReason;
use src\v3\Impression\Item;
use src\v3\Util\{Validator};
use src\v3\Util\ResponseBuilder;

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
        $request = Parser::parseRequest($jsonRequest);

        if ($request === null) {
            // In a real SSP, you would log this error and return a specific HTTP status.
            return $this->buildErrorResponse('Invalid JSON format');
        }

        // 2. Validate the request against the OpenRTB specification.
        if (!$this->validator->validateRequest($request)) {
            $errors = implode(', ', $this->validator->getErrors());
            return $this->buildNoBidResponse($request->getId(), NoBidReason::INVALID_REQUEST, $errors);
        }

        $requestId = $request->getId();
        $items = $request->getItem();

        // If there are no items, there's nothing to bid on.
        if (empty($items)) {
            return $this->buildNoBidResponse($requestId, NoBidReason::INVALID_REQUEST, 'Request contains no items');
        }

        // 3. Process each item and decide whether to create a bid.
        $responseBuilder = new ResponseBuilder($requestId);
        $seatbid = new Seatbid();
        $seatbid->setSeat('my-ssp-seat-1');

        $hasBids = false;
        foreach ($items as $item) {
            // In a real SSP, this is where you would run your internal auction,
            // query demand partners, and apply business logic.
            $bid = $this->createBidForItem($item);

            if ($bid !== null) {
                $seatbid->addBid($bid);
                $hasBids = true;
            }
        }

        // 4. If we have bids, build a complete response. Otherwise, send a no-bid.
        if ($hasBids) {
            $responseBuilder->addSeatbid($seatbid);
            $responseBuilder->setCurrency('USD');
            $response = $responseBuilder->build();
            return $response->toJson();
        } else {
            return $this->buildNoBidResponse($requestId, NoBidReason::UNMATCHED_USER, 'No matching demand for the requested items');
        }
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
        $displayAd = (new DisplayAd())
            ->setW(300)
            ->setH(250)
            ->setAdm('<a href="https://example.com"><img src="https://cdn.example.com/ad.jpg"/></a>');

        $ad = (new Ad())
            ->setId('ad-' . uniqid())
            ->setAdomain(['example.com'])
            ->setDisplay($displayAd);

        $media = (new Media())->setAd($ad);

        $bid = (new Bid())
            ->setId('ssp-bid-' . uniqid())
            ->setItem($item->getId()) // Link the bid to the request item
            ->setPrice($bidPrice)
            ->setMedia($media);

        return $bid;
    }

    private function buildNoBidResponse(string $requestId, NoBidReason $reason, string $details = ''): string
    {
        $builder = new ResponseBuilder($requestId);
        $builder->setNoBidReason($reason);
        // You can add custom extensions to provide more details.
        if ($details) {
            $builder->build()->set('ext', ['details' => $details]);
        }
        return $builder->build()->toJson();
    }

    private function buildErrorResponse(string $message): string
    {
        // Note: This is not a valid OpenRTB response, but a simple error message.
        // A real SSP might return an empty 204 or a specific error format.
        http_response_code(400);
        return json_encode(['error' => $message]);
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
header('Content-Type: application/json');
echo $responseJson;

