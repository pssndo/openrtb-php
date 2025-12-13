<?php

declare(strict_types=1);

require_once __DIR__ . '/../../vendor/autoload.php';

use OpenRTB\Factory\OpenRTBFactory;

$factory = new OpenRTBFactory('2.5');

$nativeResponse = json_encode([
    'ver' => '1.2',
    'assets' => [
        ['id' => 1, 'required' => 1, 'title' => ['text' => 'Amazing Product - Save 50% Today!']],
        ['id' => 2, 'required' => 1, 'img' => [
            'url' => 'https://cdn.example.com/ads/product-image-300x250.jpg',
            'w' => 300,
            'h' => 250
        ]],
        ['id' => 3, 'required' => 0, 'data' => ['value' => 'Sponsored by ACME Corp']]
    ],
    'link' => [
        'url' => 'https://advertiser.com/landing',
        'clicktrackers' => ['https://tracker.com/click']
    ],
    'imptrackers' => ['https://tracker.com/impression']
]);

$responseJson = json_encode([
    'id' => 'request-123',
    'seatbid' => [[
        'seat' => 'advertiser-seat',
        'bid' => [[
            'id' => 'bid-native-1',
            'impid' => 'imp-native-1',
            'price' => 3.50,
            'adm' => $nativeResponse,
            'crid' => 'native-creative-456'
        ]]
    ]],
    'cur' => 'USD'
]);

$response = $factory->createParser()->parseBidResponse($responseJson);

echo $response->toJson(JSON_PRETTY_PRINT);
