<?php

declare(strict_types=1);

/**
 * OpenRTB 2.6 PHP Library - Complete SSP Integration Example
 *
 * This example demonstrates how an SSP would integrate the OpenRTB 2.6 library
 * to handle incoming bid requests and generate bid responses.
 */

require_once __DIR__ . '/../../vendor/autoload.php';

use OpenRTB\v26\Response\Bid;
use OpenRTB\v26\Response\SeatBid;
use OpenRTB\v26\Util\BidResponseBuilder;
use OpenRTB\v26\Util\Parser;
use OpenRTB\v26\Util\Validator;

class SSPIntegration
{
    private Validator $validator;

    public function __construct()
    {
        $this->validator = new Validator();
    }

    /**
     * Handles an incoming JSON bid request from an exchange or bidder.
     * @throws JsonException
     */
    public function handleBidRequest(string $jsonRequest): string
    {
        // 1. Parse the incoming JSON into a BidRequest object
        $parser = new Parser();
        $request = $parser->parseBidRequest($jsonRequest);

        // 2. Validate the request against the OpenRTB specification
        $this->validator->validateBidRequest($request);
        if ($this->validator->hasErrors()) {
            $errors = implode(', ', $this->validator->getErrors());
            return $this->buildNoBidResponse($request->getId(), 2, $errors); // 2 = Invalid Request
        }

        $requestId = $request->getId();
        $impressions = $request->getImp();

        // If there are no impressions, return a no-bid
        if ($impressions === null || count($impressions) === 0) {
            return $this->buildNoBidResponse($requestId, 2, 'No impressions in request');
        }

        // 3. Process each impression and decide whether to create a bid
        $bids = [];
        foreach ($impressions as $imp) {
            $bid = $this->createBidForImpression($imp);
            if ($bid !== null) {
                $bids[] = $bid;
            }
        }

        // 4. If we have bids, build a complete response. Otherwise, send a no-bid.
        if (!empty($bids)) {
            // Group all bids into a single SeatBid
            $seatBid = new SeatBid();
            $seatBid->setSeat('my-dsp-seat');
            $seatBid->setBid($bids);

            $responseBuilder = new BidResponseBuilder($requestId);
            $response = $responseBuilder
                ->setCur('USD')
                ->addSeatBid($seatBid)
                ->build();

            return json_encode($response, JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        }

        return $this->buildNoBidResponse($requestId, 8, 'No matching demand'); // 8 = Unmatched User
    }

    /**
     * Creates a bid for a given impression (example business logic).
     */
    private function createBidForImpression($imp): ?Bid
    {
        // Example logic: Only bid on impressions with a floor price below $2.00
        $floorPrice = $imp->get('bidfloor') ?? 0.0;
        if ($floorPrice > 2.00) {
            return null;
        }

        // Calculate a bid price (e.g., 50% above the floor)
        $bidPrice = $floorPrice > 0 ? $floorPrice * 1.5 : 1.0;

        // Create a simple display ad creative
        $adMarkup = '<a href="%%CLICK_URL_ESC%%https://example.com">' .
                    '<img src="https://cdn.example.com/ad.jpg" width="300" height="250" alt=""/>' .
                    '</a>';

        $bid = new Bid();
        $bid
            ->setId('bid-' . uniqid('', true))
            ->setImpid($imp->getId())
            ->setPrice($bidPrice)
            ->setAdid('ad-123')
            ->setCrid('creative-456')
            ->setAdm($adMarkup)
            ->setW(300)
            ->setH(250)
            ->setBurl('https://dsp.example.com/win?id=${AUCTION_ID}&price=${AUCTION_PRICE}');

        // Set additional fields using the generic set() method
        $bid->set('adomain', ['example.com']);
        $bid->set('cat', ['IAB3-1']);

        return $bid;
    }

    /**
     * Builds a no-bid response with a reason code.
     */
    private function buildNoBidResponse(string $requestId, int $reason, string $details = ''): string
    {
        $builder = new BidResponseBuilder($requestId);
        $builder->setNbr($reason);
        $response = $builder->build();

        // Optionally add custom extension data
        if ($details) {
            $response->set('ext', ['details' => $details]);
        }

        return json_encode($response, JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    }
}

// --- Example Usage ---

$ssp = new SSPIntegration();

// Simulate an incoming request
$incomingJson = <<<'JSON'
{
  "id": "ssp-test-request-26",
  "imp": [
    {
      "id": "imp-1",
      "banner": {
        "w": 300,
        "h": 250,
        "pos": 1
      },
      "bidfloor": 1.50,
      "bidfloorcur": "USD"
    },
    {
      "id": "imp-2",
      "banner": {
        "w": 728,
        "h": 90,
        "pos": 1
      },
      "bidfloor": 2.50,
      "bidfloorcur": "USD"
    }
  ],
  "site": {
    "domain": "example.com",
    "page": "https://example.com/article"
  },
  "device": {
    "ua": "Mozilla/5.0...",
    "ip": "192.168.1.1"
  },
  "at": 2,
  "tmax": 150
}
JSON;

// Handle the request and get the response
try {
    $responseJson = $ssp->handleBidRequest($incomingJson);

    // Output the result
    header('Content-Type: application/json; charset=utf-8');
    echo $responseJson;
} catch (\Exception $e) {
    header('Content-Type: text/plain; charset=utf-8', true, 500);
    echo "Error: " . $e->getMessage();
}
