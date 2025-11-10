<?php

declare(strict_types=1);

namespace OpenRTB\Tests\v25;

use OpenRTB\v25\BidRequest;
use OpenRTB\v25\Impression\Banner;
use OpenRTB\v25\Impression\Imp;
use OpenRTB\v25\Util\Validator;
use PHPUnit\Framework\TestCase;

/**
 * @covers \OpenRTB\v25\Util\Validator
 */
class ValidatorTest extends TestCase
{
    private Validator $validator;

    protected function setUp(): void
    {
        $this->validator = new Validator();
    }

    public function testValidateBidRequestValid(): void
    {
        $request = new BidRequest();
        $request->setId('req-1');
        $imp = (new Imp())->setId('imp-1')->setBanner(new Banner());
        $request->addImp($imp);

        $result = $this->validator->validateBidRequest($request);
        $this->assertTrue($result);
        $this->assertEmpty($this->validator->getErrors());
    }

    public function testValidateBidRequestMissingId(): void
    {
        $request = new BidRequest();
        $imp = (new Imp())->setId('imp-1')->setBanner(new Banner());
        $request->addImp($imp);

        $result = $this->validator->validateBidRequest($request);
        $this->assertFalse($result);
        $errors = $this->validator->getErrors();
        $this->assertNotEmpty($errors);
        $this->assertContains('Request ID is required', $errors);
    }

    public function testValidateBidRequestMissingImp(): void
    {
        $request = new BidRequest();
        $request->setId('req-1');

        $result = $this->validator->validateBidRequest($request);
        $this->assertFalse($result);
        $errors = $this->validator->getErrors();
        $this->assertNotEmpty($errors);
        $this->assertContains('Request must contain at least one Imp object', $errors);
    }

    public function testValidateBidRequestImpMissingId(): void
    {
        $request = new BidRequest();
        $request->setId('req-1');
        $imp = new Imp();
        $imp->setBanner(new Banner());
        $request->addImp($imp);

        $result = $this->validator->validateBidRequest($request);
        $this->assertFalse($result);
        $errors = $this->validator->getErrors();
        $this->assertNotEmpty($errors);
        $this->assertContains('Imp ID is required', $errors);
    }

    public function testValidateBidRequestImpMissingMedia(): void
    {
        $request = new BidRequest();
        $request->setId('req-1');
        $imp = new Imp();
        $imp->setId('imp-1');
        $request->addImp($imp);

        $result = $this->validator->validateBidRequest($request);
        $this->assertFalse($result);
        $errors = $this->validator->getErrors();
        $this->assertNotEmpty($errors);
        // Check that error message contains reference to media type
        $foundError = false;
        foreach ($errors as $error) {
            if (str_contains($error, 'must contain at least one of Banner, Video, Audio, or Native')) {
                $foundError = true;
                break;
            }
        }
        $this->assertTrue($foundError, 'Expected error about missing media type');
    }

    public function testGetErrorsReturnsArray(): void
    {
        $request = new BidRequest();
        $this->validator->validateBidRequest($request);

        $errors = $this->validator->getErrors();
        /* @phpstan-ignore-next-line method.alreadyNarrowedType */
        $this->assertIsArray($errors);
    }

    public function testMultipleErrors(): void
    {
        $request = new BidRequest();
        // Missing both ID and impressions

        $this->validator->validateBidRequest($request);
        $errors = $this->validator->getErrors();

        $this->assertCount(2, $errors);
        $this->assertContains('Request ID is required', $errors);
        $this->assertContains('Request must contain at least one Imp object', $errors);
    }

    public function testValidateBidRequestWithMultipleValidImps(): void
    {
        $request = new BidRequest();
        $request->setId('req-1');

        // Add multiple valid impressions to test loop iteration
        $imp1 = (new Imp())->setId('imp-1')->setBanner(new Banner());
        $imp2 = (new Imp())->setId('imp-2')->setBanner(new Banner());
        $imp3 = (new Imp())->setId('imp-3')->setBanner(new Banner());
        $request->addImp($imp1);
        $request->addImp($imp2);
        $request->addImp($imp3);

        $result = $this->validator->validateBidRequest($request);
        $this->assertTrue($result);
        $this->assertEmpty($this->validator->getErrors());
    }

    public function testValidateBidRequestWithInvalidImpInCollection(): void
    {
        $request = new BidRequest();
        $request->setId('req-1');

        // Create a Collection and use reflection to inject null/invalid item
        $imp = (new Imp())->setId('imp-1')->setBanner(new Banner());
        $collection = new \OpenRTB\Common\Collection([$imp], Imp::class);

        // Use reflection to add null to the collection's items
        $reflection = new \ReflectionClass($collection);
        $itemsProperty = $reflection->getProperty('items');
        $items = $itemsProperty->getValue($collection);
        $items[] = null; // Add null which is not an Imp instance
        $itemsProperty->setValue($collection, $items);

        // Set the collection with null item
        $request->setImp($collection);

        $result = $this->validator->validateBidRequest($request);
        $this->assertFalse($result);
        $errors = $this->validator->getErrors();
        $this->assertNotEmpty($errors);

        // Should have error about invalid Imp object
        $foundError = false;
        foreach ($errors as $error) {
            if (str_contains($error, 'Invalid Imp object at index')) {
                $foundError = true;
                break;
            }
        }
        $this->assertTrue($foundError, 'Expected error about invalid Imp object');
    }
}
