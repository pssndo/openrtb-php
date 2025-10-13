<?php

/**
 * OpenRTB 3.0 PHP Library - App Banner Request with Privacy Example
 */

// In a real project, you would include Composer's autoloader.
require_once __DIR__ . '/../../../../vendor/autoload.php';

use src\v3\Context\{Device};
use src\v3\Context\App;
use src\v3\Context\Context;
use src\v3\Context\Regs;
use src\v3\Context\Source;
use src\v3\Context\User;
use src\v3\Enums\{AuctionType, Placement\AdPosition, Placement\ClickType};
use src\v3\Enums\Context\DeviceType;
use src\v3\Enums\CreativeType;
use src\v3\Enums\Placement\{SizeUnit};
use src\v3\Enums\Placement\PlacementType;
use src\v3\Impression\{Spec};
use src\v3\Impression\Item;
use src\v3\Placement\{DisplayPlacement};
use src\v3\Placement\Placement;
use src\v3\Util\RequestBuilder;

// Create display placement
$displayPlacement = new DisplayPlacement();
$displayPlacement
    ->setPos(AdPosition::ABOVE_FOLD)
    ->setInstl(0)  // Not interstitial
    ->setW(320)
    ->setH(50)
    ->setUnit(SizeUnit::DENSITY_INDEPENDENT_PIXELS)
    ->setMime(['image/jpeg', 'image/png'])
    ->setCtype([CreativeType::HTML])
    ->setClktype(ClickType::CLICKABLE)
    ->setPtype(PlacementType::IN_ATOMIC_UNIT);

// Create placement
$placement = new Placement();
$placement
    ->setTagid('app-banner-bottom')
    ->setDisplay($displayPlacement);

// Create spec
$spec = new Spec();
$spec->setPlacement($placement);

// Create item
$item = new Item();
$item
    ->setId('1')
    ->setQty(1)
    ->setFlr(1.50)
    ->setFlrcur('USD')
    ->setSpec($spec);

// Create app
$app = new App();
$app
    ->setId('app456')
    ->setName('My Mobile Game')
    ->setBundle('com.example.game')
    ->setStoreurl('https://apps.apple.com/app/id123456')
    ->setCat(['IAB9'])  // Hobbies & Interests
    ->setVer('2.1.0')
    ->setPaid(0);  // Free app

// Create device
$device = new Device();
$device
    ->setType(DeviceType::PHONE)
    ->setIfa('AEBE52E7-03EE-455A-B3C4-E57283966239')
    ->setLmt(0)  // Limit ad tracking disabled
    ->setIp('192.168.1.1')
    ->setMake('Samsung')
    ->setModel('Galaxy S21')
    ->setOs('Android')
    ->setOsv('13');

// Create user with consent
$user = new User();
$user
    ->setId('user789')
    ->setConsent('CPXxRfAPXxRfAAfKABENBsCsAP_AAH_AACiQGaNf_X_fb3...');  // TCF v2 consent string

// Create regulations
$regs = new Regs();
$regs
    ->setGdpr(1)
    ->setCoppa(0)
    ->setGpp('DBABMA~CPXxRfAPXxRfAAfKABENB')  // GPP string
    ->setGppSid([2, 6]);  // GPP section IDs

// Create context
$context = new Context();
$context
    ->setApp($app)
    ->setDevice($device)
    ->setUser($user)
    ->setRegs($regs);

// Create source
$source = new Source();
$source
    ->setTid('txn-' . uniqid('', true))
    ->setTs(time());

// Build request
$builder = new RequestBuilder();
$request = $builder
    ->setTimeout(120)
    ->setAuctionType(AuctionType::SECOND_PRICE)
    ->setCurrencies(['USD'])
    ->addItem($item)
    ->setContext($context)
    ->setSource($source)
    ->build();

// Add custom extension
$request->set('ext', ['custom_param' => ['key' => 'value']]);

// Output the JSON
header('Content-Type: application/json');
echo $request->toJson();
