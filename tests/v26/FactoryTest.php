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
        $builder = (new Factory())();

        $this->assertInstanceOf(RequestBuilder::class, $builder);
    }
}