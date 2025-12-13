<?php

declare(strict_types=1);

require_once __DIR__ . '/../../vendor/autoload.php';

use OpenRTB\Factory\OpenRTBFactory;
use OpenRTB\v26\Context\Site;
use OpenRTB\v26\Context\App;
use OpenRTB\v26\Context\Device;
use OpenRTB\v26\Context\User;
use OpenRTB\v26\Context\Regs;
use OpenRTB\v26\Impression\Imp;
use OpenRTB\v26\Impression\Banner;
use OpenRTB\v26\Enums\AuctionType;

$factory = new OpenRTBFactory('2.6');

// Example 1: Site-based request
$siteRequest = $factory
    ->createRequestBuilder()
    ->setId(uniqid('', true))
    ->setTest(1)
    ->setAt(AuctionType::SECOND_PRICE_PLUS)
    ->setTmax(200)
    ->setCur(['USD'])
    ->setBcat(['IAB25', 'IAB7-39'])
    ->setSite((new Site())
        ->setId('102855')
        ->setPage('http://www.example.com/index.html')
        ->setDomain('example.com'))
    ->addImp((new Imp())
        ->setId('1')
        ->setBanner(new Banner()))
    ->setDevice((new Device())
        ->setIp('123.145.167.189')
        ->setUa('Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36'))
    ->setUser((new User())
        ->setId('ab382f34-b927-44c6-a8a5-039f544b2973'))
    ->setRegs((new Regs())
        ->setGdpr(1))();

echo $siteRequest->toJson(JSON_PRETTY_PRINT);
