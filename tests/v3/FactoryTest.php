<?php

declare(strict_types=1);

namespace OpenRTB\Tests\v3;

use OpenRTB\v3\Factory;
use OpenRTB\v3\Util\RequestBuilder;
use PHPUnit\Framework\TestCase;

/**
 * @covers \OpenRTB\v3\Factory
 */
class FactoryTest extends TestCase
{
    public function testCreateRequestBuilder(): void
    {
        $builder = (new Factory())();

        $this->assertInstanceOf(RequestBuilder::class, $builder);
    }
}
