<?php

declare(strict_types=1);

namespace OpenRTB\Tests\v3;

use OpenRTB\Common\Resources\Ext;
use OpenRTB\v3\Bid\Seatbid;
use OpenRTB\v3\BidResponse;
use OpenRTB\v3\Enums\NoBidReason;
use PHPUnit\Framework\TestCase;

/**
 * @covers \OpenRTB\v3\BidResponse
 */
class BidResponseTest extends TestCase
{
    public function testSetAndGetExt(): void
    {
        $bidResponse = new BidResponse();
        $ext = new Ext();

        $bidResponse->setExt($ext);
        $this->assertSame($ext, $bidResponse->getExt());
    }

    public function testToArrayWithNoOptionalFields(): void
    {
        $bidResponse = new BidResponse();
        $bidResponse->setId('test-id');

        $expectedArray = [
            'id' => 'test-id',
        ];

        $this->assertEquals($expectedArray, $bidResponse->toArray());
    }

    public function testToArrayWithAllFields(): void
    {
        $bidResponse = new BidResponse();
        $bidResponse->setId('test-id');
        $bidResponse->setBidid('test-bidid');
        $bidResponse->setCur('USD');
        $bidResponse->setNbr(NoBidReason::UNKNOWN_ERROR);

        $seatbid = $this->createMock(Seatbid::class);
        $seatbid->method('toArray')->willReturn(['seat' => 'test-seat']);
        $bidResponse->addSeatbid($seatbid);

        $ext = $this->createMock(Ext::class);
        $ext->method('toArray')->willReturn(['key' => 'value']);
        $bidResponse->setExt($ext);

        $expectedArray = [
            'id' => 'test-id',
            'bidid' => 'test-bidid',
            'cur' => 'USD',
            'nbr' => 0, // NoBidReason::UNKNOWN_ERROR->value
            'seatbid' => [
                ['seat' => 'test-seat']
            ],
            'ext' => ['key' => 'value'],
        ];

        $this->assertEquals($expectedArray, $bidResponse->toArray());
    }

    public function testToJson(): void
    {
        $bidResponse = new BidResponse();
        $bidResponse->setId('json-test-id');

        $expectedJson = '{"id":"json-test-id"}';

        $json = $bidResponse->toJson();
        $this->assertIsString($json);
        $this->assertJsonStringEqualsJsonString($expectedJson, $json);
    }
}
