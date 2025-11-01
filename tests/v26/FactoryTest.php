<?php

declare(strict_types=1);

namespace OpenRTB\Tests\v26;

use OpenRTB\v26\Factory;
use OpenRTB\v26\Util\RequestBuilder;
use PHPUnit\Framework\TestCase;

/**
 * @covers \OpenRTB\v26\Factory
 */
class FactoryTest extends TestCase
{
    public function testCreateRequestBuilder(): void
    {
        $factory = new Factory();
        $builder = $factory->createRequestBuilder();

        $this->assertInstanceOf(RequestBuilder::class, $builder);
    }
}