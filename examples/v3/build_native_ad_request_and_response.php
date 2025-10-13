<?php

/**
 * OpenRTB 3.0 PHP Library - Complete Native Ad Request & Response Example
 */

// In a real project, you would include Composer's autoloader.
require_once __DIR__ . '/../../../../vendor/autoload.php';

// Core Utilities
use src\v3\Bid\{Media};
use src\v3\Bid\Ad;
use src\v3\Bid\Asset;
use src\v3\Bid\Bid;
use src\v3\Bid\Data;
use src\v3\Bid\Image;
use src\v3\Bid\Link;
use src\v3\Bid\NativeAd;
use src\v3\Bid\Seatbid;
use src\v3\Bid\Title;
use src\v3\Context\Context;
use src\v3\Context\Site;
use src\v3\Enums\AuctionType;
use src\v3\Enums\Placement\AdPosition;
use src\v3\Impression\{Spec};
use src\v3\Impression\Item;
use src\v3\Placement\{ImageFormat};
use src\v3\Placement\AssetFormat;
use src\v3\Placement\DataFormat;
use src\v3\Placement\NativeFormat;
use src\v3\Placement\Placement;
use src\v3\Placement\TitleFormat;
use src\v3\Util\{ResponseBuilder};
use src\v3\Util\RequestBuilder;

// Request-side objects

// Response-side objects

// Enums

// --- 1. Build a Native Ad Request ---

// Define the assets required for the native ad placement.
// Asset 1: A title with a max length of 50 characters.
$titleAsset = (new AssetFormat())
    ->setId(1)
    ->setReq(1) // This asset is required
    ->setTitle((new TitleFormat())->setLen(50));

// Asset 2: A main image of a specific size.
$imageAsset = (new AssetFormat())
    ->setId(2)
    ->setReq(1)
    ->setImg((new ImageFormat())->setW(1200)->setH(627));

// Asset 3: A "sponsored by" data asset.
$sponsoredByAsset = (new AssetFormat())
    ->setId(3)
    ->setReq(1)
    ->setData((new DataFormat())->setType(1)); // Type 1: "sponsored by"

// Create the NativeFormat object containing the asset definitions.
$nativeFormat = (new NativeFormat())
    ->setAsset([$titleAsset, $imageAsset, $sponsoredByAsset]);

// Create the main Placement object.
$placement = (new Placement())
    ->setTagid('native-ad-slot-1')
    ->setPos(AdPosition::IN_FEED)
    ->setNativefmt($nativeFormat);

$spec = (new Spec())->setPlacement($placement);
$item = (new Item())->setId('native-item-1')->setSpec($spec);

// Build the full request.
$requestBuilder = new RequestBuilder();
$request = $requestBuilder
    ->setAuctionType(AuctionType::SECOND_PRICE)
    ->addItem($item)
    ->setContext((new Context())->setSite((new Site())->setDomain('native-publisher.com')))
    ->build();

echo "--- Native Ad Request --- \n";
echo $request->toJson(JSON_PRETTY_PRINT);
echo "\n\n";


// --- 2. Build a Native Ad Response ---

// The ID of the bid request to which this is a response.
$requestId = $request->getId();

// Create the assets for the response, fulfilling the request's requirements.
// Asset 1: The title text.
$responseTitle = (new Asset())
    ->setId(1) // Corresponds to the ID in the request's AssetFormat
    ->setTitle((new Title())->setText('This is the Native Ad Title'));

// Asset 2: The image URL.
$responseImage = (new Asset())
    ->setId(2)
    ->setImg((new Image())->setUrl('https://cdn.example.com/native-ad-image.jpg'));

// Asset 3: The "sponsored by" text.
$responseSponsoredBy = (new Asset())
    ->setId(3)
    ->setData((new Data())->setValue('Our Great Sponsor'));

// Create the main Link object for the ad's click-through.
$link = (new Link())
    ->setUrl('https://advertiser-landing-page.com')
    ->setTrkr(['https://analytics.example.com/click-tracker']);

// Create the NativeAd object containing the response assets and link.
$nativeAd = (new NativeAd())
    ->setAsset([$responseTitle, $responseImage, $responseSponsoredBy])
    ->setLink($link)
    ->setImptrackers(['https://analytics.example.com/impression-tracker']);

// Wrap the NativeAd in the standard Ad/Media/Bid/Seatbid structure.
$ad = (new Ad())
    ->setId('native-ad-creative-1')
    ->setAdomain(['advertiser.com'])
    ->setNative($nativeAd);

$media = (new Media())->setAd($ad);

$bid = (new Bid())
    ->setId('native-bid-1')
    ->setItem('native-item-1') // Corresponds to the Item ID in the request
    ->setPrice(2.50)
    ->setMedia($media);

$seatbid = (new Seatbid())
    ->setSeat('native-dsp-seat-1')
    ->addBid($bid);

// Build the final response.
$responseBuilder = new ResponseBuilder($requestId);
$response = $responseBuilder
    ->setCurrency('USD')
    ->addSeatbid($seatbid)
    ->build();

echo "--- Native Ad Response --- \n";
echo $response->toJson(JSON_PRETTY_PRINT);
echo "\n";
