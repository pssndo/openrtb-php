<?php

declare(strict_types=1);

require_once __DIR__ . '/../../vendor/autoload.php';

use OpenRTB\Factory\OpenRTBFactory;
use OpenRTB\v25\Context\Site;
use OpenRTB\v25\Impression\Imp;
use OpenRTB\v25\Impression\Banner;
use OpenRTB\v25\Enums\AuctionType;

$factory = new OpenRTBFactory('2.5');

$request = $factory
    ->createRequestBuilder()
    ->setId(uniqid('', true))
    ->setTest(0)
    ->setAt(AuctionType::FIRST_PRICE)
    ->setTmax(200)
    ->setSite((new Site())
        ->setId('site-123')
        ->setDomain('example.com')
        ->setPage('https://example.com/page'))
    ->addImp((new Imp())
        ->setId('imp-1')
        ->setBanner((new Banner())
            ->setW(300)
            ->setH(250)))();

echo $request->toJson(JSON_PRETTY_PRINT);
