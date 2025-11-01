<?php

declare(strict_types=1);

namespace OpenRTB\Tests\v26;

use OpenRTB\v26\BidRequest;
use OpenRTB\v26\Impression\Banner;
use OpenRTB\v26\Impression\Imp;
use OpenRTB\v26\Util\Validator;
use PHPUnit\Framework\TestCase;

/**
 * @covers \OpenRTB\v26\Util\Validator
 * @covers \OpenRTB\v26\BidRequest
 */
class ValidatorTest extends TestCase
{
    private Validator $validator;

    protected function setUp(): void
    {
        $this->validator = new Validator();
    }

    public function testValidRequest(): void
    {
        $request = (new BidRequest())->setId('req-1')->addImp((new Imp())->setId('imp-1')->setBanner(new Banner()))->setTest(1);

        $this->assertEquals(1, $request->getTest());
        $this->assertTrue($this->validator->validateBidRequest($request));
        $this->assertEmpty($this->validator->getErrors());
    }

    public function testRequestMissingId(): void
    {
        $request = (new BidRequest())->addImp((new Imp())->setId('imp-1')->setBanner(new Banner()));
        $this->assertFalse($this->validator->validateBidRequest($request));
        $this->assertContains('Request ID is required', $this->validator->getErrors());
    }

    public function testRequestMissingImp(): void
    {
        $request = (new BidRequest())->setId('req-1');
        $this->assertFalse($this->validator->validateBidRequest($request));
        $this->assertContains('Request must contain at least one Imp object', $this->validator->getErrors());
    }

    public function testImpMissingMedia(): void
    {
        $request = (new BidRequest())->setId('req-1')->addImp((new Imp())->setId('imp-1'));
        $this->assertFalse($this->validator->validateBidRequest($request));
        $this->assertContains(
            'Imp (ID: imp-1) must contain at least one of Banner, Video, Audio, or Native',
            $this->validator->getErrors()
        );
    }

    public function testImpMissingId(): void
    {
        $request = (new BidRequest())->setId('req-1')->addImp((new Imp())->setBanner(new Banner()));
        $this->assertFalse($this->validator->validateBidRequest($request));
        $this->assertContains('Imp ID is required', $this->validator->getErrors());
    }
}