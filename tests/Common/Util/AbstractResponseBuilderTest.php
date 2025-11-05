<?php

declare(strict_types=1);

namespace OpenRTB\Tests\Common\Util;

use OpenRTB\Common\Resources\Bid;
use OpenRTB\Common\Util\AbstractResponseBuilder;
use OpenRTB\Interfaces\ObjectInterface;
use PHPUnit\Framework\TestCase;

/**
 * @covers \OpenRTB\Common\Util\AbstractResponseBuilder
 */
class AbstractResponseBuilderTest extends TestCase
{
    public function testBuild(): void
    {
        $builder = new class extends AbstractResponseBuilder {
            public function __construct()
            {
                // Create a simple response object
                $this->response = new Bid();
                $this->response->setId('test-response-id');
                $this->response->setPrice(5.0);
            }
        };

        $response = $builder->build();

        $this->assertInstanceOf(ObjectInterface::class, $response);
        $this->assertInstanceOf(Bid::class, $response);
        $this->assertEquals('test-response-id', $response->getId());
        $this->assertEquals(5.0, $response->getPrice());
    }

    public function testInvoke(): void
    {
        $builder = new class extends AbstractResponseBuilder {
            public function __construct()
            {
                // Create a simple response object
                $this->response = new Bid();
                $this->response->setId('invoke-test-id');
                $this->response->setPrice(10.5);
            }
        };

        // Test that the builder can be invoked as a function
        $response = $builder();

        $this->assertInstanceOf(ObjectInterface::class, $response);
        $this->assertInstanceOf(Bid::class, $response);
        $this->assertEquals('invoke-test-id', $response->getId());
        $this->assertEquals(10.5, $response->getPrice());
    }

    public function testInvokeCallsBuild(): void
    {
        $builder = new class extends AbstractResponseBuilder {
            public function __construct()
            {
                $this->response = new Bid();
                $this->response->setId('test-id');
            }
        };

        // Both methods should return the same object
        $responseFromBuild = $builder->build();
        $responseFromInvoke = $builder();

        $this->assertSame($responseFromBuild, $responseFromInvoke);
    }

    public function testFluentInterface(): void
    {
        $builder = new class extends AbstractResponseBuilder {
            /** @var Bid */
            protected ObjectInterface $response;

            public function __construct()
            {
                $this->response = new Bid();
            }

            public function setId(string $id): static
            {
                /** @var Bid $response */
                $response = $this->response;
                $response->setId($id);

                return $this;
            }

            public function setPrice(float $price): static
            {
                /** @var Bid $response */
                $response = $this->response;
                $response->setPrice($price);

                return $this;
            }
        };

        // Test fluent interface
        $response = $builder
            ->setId('fluent-id')
            ->setPrice(7.5)
            ->build();

        /* @var \OpenRTB\Common\Resources\Bid $response */
        $this->assertEquals('fluent-id', $response->getId());
        $this->assertEquals(7.5, $response->getPrice());
    }
}
