<?php

declare(strict_types=1);

namespace OpenRTB\Tests\v3;

use OpenRTB\v3\BidRequest as Request;
use OpenRTB\v3\BidResponse as Response;
use OpenRTB\v3\Impression\Item;
use OpenRTB\v3\Impression\Spec;
use OpenRTB\v3\Placement\Placement;
use OpenRTB\v3\Util\Validator;
use PHPUnit\Framework\TestCase;

/**
 * @covers \OpenRTB\v3\Util\Validator
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
        $request = new Request();
        $item = new Item();
        $spec = new Spec();
        $placement = new Placement();

        $spec->setPlacement($placement);
        $item->setId('item-1')->setSpec($spec);
        $request->setId('req-1')->addItem($item);

        $this->assertTrue($this->validator->validateRequest($request));
        $this->assertEmpty($this->validator->getErrors());
    }

    public function testInvalidRequestMissingId(): void
    {
        $request = new Request();
        // We don't set the ID
        $request->addItem(new Item());

        $this->assertFalse($this->validator->validateRequest($request));
        $this->assertNotEmpty($this->validator->getErrors());
        $this->assertContains('Request ID is required', $this->validator->getErrors());
    }

    public function testInvalidRequestMissingItem(): void
    {
        $request = new Request();
        $request->setId('test-id');
        // We don't add an item

        $this->assertFalse($this->validator->validateRequest($request));
        $this->assertNotEmpty($this->validator->getErrors());
        $this->assertContains('Request must contain at least one Item', $this->validator->getErrors());
    }

    public function testInvalidItemMissingId(): void
    {
        $request = new Request();
        $item = new Item(); // Missing ID
        $request->setId('req-1')->addItem($item);

        $this->assertFalse($this->validator->validateRequest($request));
        $this->assertNotEmpty($this->validator->getErrors());
        $this->assertContains('Item ID is required', $this->validator->getErrors());
    }

    public function testInvalidItemMissingSpec(): void
    {
        $request = new Request();
        $item = new Item();
        $item->setId('item-1'); // Missing Spec
        $request->setId('req-1')->addItem($item);

        $this->assertFalse($this->validator->validateRequest($request));
        $this->assertNotEmpty($this->validator->getErrors());
        $this->assertContains('Item Spec is required', $this->validator->getErrors());
    }

    public function testInvalidSpecMissingPlacement(): void
    {
        $request = new Request();
        $item = new Item();
        $spec = new Spec(); // Missing Placement
        $item->setId('item-1')->setSpec($spec);
        $request->setId('req-1')->addItem($item);

        $this->assertFalse($this->validator->validateRequest($request));
        $this->assertNotEmpty($this->validator->getErrors());
        $this->assertContains('Spec Placement is required', $this->validator->getErrors());
    }

    public function testValidateResponse(): void
    {
        $response = new Response();
        $response->setId('res-1');
        $this->assertTrue($this->validator->validateResponse($response));

        $invalidResponse = new Response();
        $this->assertFalse($this->validator->validateResponse($invalidResponse));
        $this->assertContains('Response ID is required', $this->validator->getErrors());
    }
}
