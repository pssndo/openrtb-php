<?php

declare(strict_types=1);

namespace OpenRTB\Tests\Factory;

use OpenRTB\Factory\OpenRTBFactory;
use OpenRTB\Factory\ProviderRegistry;
use OpenRTB\v26\Util\BidResponseBuilder;
use OpenRTB\v3\Util\Parser;
use OpenRTB\v3\Util\RequestBuilder;
use OpenRTB\v3\Util\ResponseBuilder;
use OpenRTB\v3\Util\Validator;
use PHPUnit\Framework\TestCase;

/**
 * @covers \OpenRTB\Factory\OpenRTBFactory
 */
final class OpenRTBFactoryTest extends TestCase
{
    public function testConstructorWithVersion26(): void
    {
        $factory = new OpenRTBFactory('2.6');
        $this->assertEquals('2.6', $factory->getVersion());
    }

    public function testConstructorWithVersion30(): void
    {
        $factory = new OpenRTBFactory('3.0');
        $this->assertEquals('3.0', $factory->getVersion());
    }

    public function testConstructorWithVersion25MapsTo26(): void
    {
        $factory = new OpenRTBFactory('2.5');
        $this->assertEquals('2.6', $factory->getVersion());
    }

    public function testConstructorWithUnsupportedVersionThrowsException(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Unsupported OpenRTB version: 4.0');
        new OpenRTBFactory('4.0');
    }

    public function testConstructorWithInvalidVersionThrowsException(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Unsupported OpenRTB version: 1.0');
        new OpenRTBFactory('1.0');
    }

    public function testCreateRequestBuilderForVersion26(): void
    {
        $factory = new OpenRTBFactory('2.6');
        $builder = $factory->createRequestBuilder();
        $this->assertInstanceOf(\OpenRTB\v26\Util\RequestBuilder::class, $builder);
    }

    public function testCreateRequestBuilderForVersion30(): void
    {
        $factory = new OpenRTBFactory('3.0');
        $builder = $factory->createRequestBuilder();
        $this->assertInstanceOf(RequestBuilder::class, $builder);
    }

    public function testCreateParserForVersion26(): void
    {
        $factory = new OpenRTBFactory('2.6');
        $parser = $factory->createParser();
        $this->assertInstanceOf(\OpenRTB\v26\Util\Parser::class, $parser);
    }

    public function testCreateParserForVersion30(): void
    {
        $factory = new OpenRTBFactory('3.0');
        $parser = $factory->createParser();
        $this->assertInstanceOf(Parser::class, $parser);
    }

    public function testCreateResponseBuilderForVersion26(): void
    {
        $factory = new OpenRTBFactory('2.6');
        $builder = $factory->createResponseBuilder('request-123');
        $this->assertInstanceOf(BidResponseBuilder::class, $builder);
    }

    public function testCreateResponseBuilderForVersion30(): void
    {
        $factory = new OpenRTBFactory('3.0');
        $builder = $factory->createResponseBuilder('request-456');
        $this->assertInstanceOf(ResponseBuilder::class, $builder);
    }

    public function testCreateResponseBuilderWithEmptyRequestId(): void
    {
        $factory = new OpenRTBFactory('2.6');
        $builder = $factory->createResponseBuilder();
        $this->assertInstanceOf(BidResponseBuilder::class, $builder);
    }

    public function testCreateValidatorForVersion26(): void
    {
        $factory = new OpenRTBFactory('2.6');
        $validator = $factory->createValidator();
        $this->assertInstanceOf(\OpenRTB\v26\Util\Validator::class, $validator);
    }

    public function testCreateValidatorForVersion30(): void
    {
        $factory = new OpenRTBFactory('3.0');
        $validator = $factory->createValidator();
        $this->assertInstanceOf(Validator::class, $validator);
    }

    public function testGetVersion(): void
    {
        $factory26 = new OpenRTBFactory('2.6');
        $this->assertEquals('2.6', $factory26->getVersion());

        $factory30 = new OpenRTBFactory('3.0');
        $this->assertEquals('3.0', $factory30->getVersion());
    }

    public function testForProviderWithKnownProvider(): void
    {
        $registry = ProviderRegistry::getInstance();
        $registry->register('testprovider', '3.0');

        $factory = OpenRTBFactory::forProvider('testprovider');
        $this->assertEquals('3.0', $factory->getVersion());

        // Cleanup
        $registry->unregister('testprovider');
    }

    public function testForProviderWithCustomRegistry(): void
    {
        $customRegistry = ProviderRegistry::getInstance();
        $customRegistry->register('customprovider', '2.6');

        $factory = OpenRTBFactory::forProvider('customprovider', $customRegistry);
        $this->assertEquals('2.6', $factory->getVersion());

        // Cleanup
        $customRegistry->unregister('customprovider');
    }

    public function testForProviderWithDefaultEpomProvider(): void
    {
        $factory = OpenRTBFactory::forProvider('epom');
        $this->assertEquals('3.0', $factory->getVersion());
    }

    public function testForProviderWithDefaultDianomiProvider(): void
    {
        $factory = OpenRTBFactory::forProvider('dianomi');
        $this->assertEquals('2.6', $factory->getVersion());
    }

    public function testIsVersionSupportedReturnsTrueForVersion26(): void
    {
        $this->assertTrue(OpenRTBFactory::isVersionSupported('2.6'));
    }

    public function testIsVersionSupportedReturnsTrueForVersion25(): void
    {
        $this->assertTrue(OpenRTBFactory::isVersionSupported('2.5'));
    }

    public function testIsVersionSupportedReturnsTrueForVersion30(): void
    {
        $this->assertTrue(OpenRTBFactory::isVersionSupported('3.0'));
    }

    public function testIsVersionSupportedReturnsFalseForUnsupportedVersion(): void
    {
        $this->assertFalse(OpenRTBFactory::isVersionSupported('4.0'));
        $this->assertFalse(OpenRTBFactory::isVersionSupported('1.0'));
        $this->assertFalse(OpenRTBFactory::isVersionSupported('2.4'));
    }

    public function testGetSupportedVersions(): void
    {
        $versions = OpenRTBFactory::getSupportedVersions();
        $this->assertContains('2.5', $versions);
        $this->assertContains('2.6', $versions);
        $this->assertContains('3.0', $versions);
        $this->assertCount(3, $versions);
    }

    public function testFullWorkflowForVersion26(): void
    {
        $factory = new OpenRTBFactory('2.6');

        // Test all factory methods work correctly
        $this->assertInstanceOf(\OpenRTB\v26\Util\RequestBuilder::class, $factory->createRequestBuilder());
        $this->assertInstanceOf(\OpenRTB\v26\Util\Parser::class, $factory->createParser());
        $this->assertInstanceOf(BidResponseBuilder::class, $factory->createResponseBuilder('req-1'));
        $this->assertInstanceOf(\OpenRTB\v26\Util\Validator::class, $factory->createValidator());
        $this->assertEquals('2.6', $factory->getVersion());
    }

    public function testFullWorkflowForVersion30(): void
    {
        $factory = new OpenRTBFactory('3.0');

        // Test all factory methods work correctly
        $this->assertInstanceOf(RequestBuilder::class, $factory->createRequestBuilder());
        $this->assertInstanceOf(Parser::class, $factory->createParser());
        $this->assertInstanceOf(ResponseBuilder::class, $factory->createResponseBuilder('req-2'));
        $this->assertInstanceOf(Validator::class, $factory->createValidator());
        $this->assertEquals('3.0', $factory->getVersion());
    }
}
