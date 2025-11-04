<?php

declare(strict_types=1);

namespace OpenRTB\Tests\Factory;

use InvalidArgumentException;
use OpenRTB\Factory\ProviderRegistry;
use PHPUnit\Framework\TestCase;

/**
 * @covers \OpenRTB\Factory\ProviderRegistry
 */
final class ProviderRegistryTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        // Reset registry before each test to ensure clean state
        ProviderRegistry::getInstance()->reset();
    }

    protected function tearDown(): void
    {
        // Reset registry after each test to clean up
        ProviderRegistry::getInstance()->reset();
        parent::tearDown();
    }

    public function testGetInstanceReturnsSingleton(): void
    {
        $instance1 = ProviderRegistry::getInstance();
        $instance2 = ProviderRegistry::getInstance();

        $this->assertSame($instance1, $instance2);
    }

    public function testRegisterNewProvider(): void
    {
        $registry = ProviderRegistry::getInstance();
        $registry->register('newprovider', '3.0');

        $this->assertTrue($registry->hasProvider('newprovider'));
        $this->assertEquals('3.0', $registry->getVersionForProvider('newprovider'));
    }

    public function testRegisterProviderCaseInsensitive(): void
    {
        $registry = ProviderRegistry::getInstance();
        $registry->register('TestProvider', '2.6');

        // Should be accessible with lowercase
        $this->assertTrue($registry->hasProvider('testprovider'));
        $this->assertTrue($registry->hasProvider('TESTPROVIDER'));
        $this->assertTrue($registry->hasProvider('TestProvider'));
        $this->assertEquals('2.6', $registry->getVersionForProvider('testprovider'));
        $this->assertEquals('2.6', $registry->getVersionForProvider('TESTPROVIDER'));
    }

    public function testRegisterOverwritesExistingProvider(): void
    {
        $registry = ProviderRegistry::getInstance();
        $registry->register('provider', '2.6');
        $this->assertEquals('2.6', $registry->getVersionForProvider('provider'));

        // Overwrite with new version
        $registry->register('provider', '3.0');
        $this->assertEquals('3.0', $registry->getVersionForProvider('provider'));
    }

    public function testRegisterBatch(): void
    {
        $registry = ProviderRegistry::getInstance();
        $providers = [
            'provider1' => '2.6',
            'provider2' => '3.0',
            'provider3' => '2.5',
        ];

        $registry->registerBatch($providers);

        $this->assertEquals('2.6', $registry->getVersionForProvider('provider1'));
        $this->assertEquals('3.0', $registry->getVersionForProvider('provider2'));
        $this->assertEquals('2.5', $registry->getVersionForProvider('provider3'));
    }

    public function testGetVersionForProviderWithDefaultProviders(): void
    {
        $registry = ProviderRegistry::getInstance();

        // Test default providers
        $this->assertEquals('3.0', $registry->getVersionForProvider('epom'));
        $this->assertEquals('2.6', $registry->getVersionForProvider('dianomi'));
        $this->assertEquals('2.6', $registry->getVersionForProvider('google'));
        $this->assertEquals('2.6', $registry->getVersionForProvider('rubicon'));
        $this->assertEquals('2.5', $registry->getVersionForProvider('appnexus'));
        $this->assertEquals('2.6', $registry->getVersionForProvider('pubmatic'));
    }

    public function testGetVersionForProviderThrowsExceptionForUnknownProvider(): void
    {
        $registry = ProviderRegistry::getInstance();

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Unknown provider: unknownprovider');
        $registry->getVersionForProvider('unknownprovider');
    }

    public function testGetVersionForProviderExceptionIncludesAvailableProviders(): void
    {
        $registry = ProviderRegistry::getInstance();

        try {
            $registry->getVersionForProvider('unknownprovider');
            $this->fail('Expected InvalidArgumentException was not thrown');
        } catch (InvalidArgumentException $e) {
            $message = $e->getMessage();
            $this->assertStringContainsString('Available providers:', $message);
            $this->assertStringContainsString('epom', $message);
            $this->assertStringContainsString('dianomi', $message);
        }
    }

    public function testHasProviderReturnsTrueForRegisteredProvider(): void
    {
        $registry = ProviderRegistry::getInstance();
        $registry->register('testprovider', '2.6');

        $this->assertTrue($registry->hasProvider('testprovider'));
    }

    public function testHasProviderReturnsTrueForDefaultProvider(): void
    {
        $registry = ProviderRegistry::getInstance();

        $this->assertTrue($registry->hasProvider('epom'));
        $this->assertTrue($registry->hasProvider('dianomi'));
        $this->assertTrue($registry->hasProvider('google'));
    }

    public function testHasProviderReturnsFalseForUnregisteredProvider(): void
    {
        $registry = ProviderRegistry::getInstance();

        $this->assertFalse($registry->hasProvider('nonexistent'));
        $this->assertFalse($registry->hasProvider('unknownprovider'));
    }

    public function testHasProviderIsCaseInsensitive(): void
    {
        $registry = ProviderRegistry::getInstance();

        $this->assertTrue($registry->hasProvider('EPOM'));
        $this->assertTrue($registry->hasProvider('Epom'));
        $this->assertTrue($registry->hasProvider('epom'));
    }

    public function testGetProvidersReturnsAllProviders(): void
    {
        $registry = ProviderRegistry::getInstance();

        $providers = $registry->getProviders();

        $this->assertIsArray($providers);
        $this->assertArrayHasKey('epom', $providers);
        $this->assertArrayHasKey('dianomi', $providers);
        $this->assertArrayHasKey('google', $providers);
        $this->assertArrayHasKey('rubicon', $providers);
        $this->assertArrayHasKey('appnexus', $providers);
        $this->assertArrayHasKey('pubmatic', $providers);
    }

    public function testGetProvidersIncludesCustomProviders(): void
    {
        $registry = ProviderRegistry::getInstance();
        $registry->register('custom', '3.0');

        $providers = $registry->getProviders();

        $this->assertArrayHasKey('custom', $providers);
        $this->assertEquals('3.0', $providers['custom']);
    }

    public function testUnregisterRemovesProvider(): void
    {
        $registry = ProviderRegistry::getInstance();
        $registry->register('temporaryprovider', '2.6');

        $this->assertTrue($registry->hasProvider('temporaryprovider'));

        $registry->unregister('temporaryprovider');

        $this->assertFalse($registry->hasProvider('temporaryprovider'));
    }

    public function testUnregisterIsCaseInsensitive(): void
    {
        $registry = ProviderRegistry::getInstance();
        $registry->register('TestProvider', '2.6');

        $this->assertTrue($registry->hasProvider('testprovider'));

        $registry->unregister('TESTPROVIDER');

        $this->assertFalse($registry->hasProvider('testprovider'));
    }

    public function testUnregisterNonExistentProviderDoesNothing(): void
    {
        $registry = ProviderRegistry::getInstance();

        // Should not throw exception
        $registry->unregister('nonexistent');

        $this->assertFalse($registry->hasProvider('nonexistent'));
    }

    public function testResetClearsInstance(): void
    {
        $instance1 = ProviderRegistry::getInstance();
        $instance1->register('testprovider', '2.6');

        $this->assertTrue($instance1->hasProvider('testprovider'));

        $instance1->reset();

        // After reset, getInstance returns a new instance
        $instance2 = ProviderRegistry::getInstance();

        // New instance should have default providers but not custom ones
        $this->assertTrue($instance2->hasProvider('epom'));
        $this->assertFalse($instance2->hasProvider('testprovider'));

        // Instances should be different
        $this->assertNotSame($instance1, $instance2);
    }

    public function testFullWorkflow(): void
    {
        $registry = ProviderRegistry::getInstance();

        // Register custom providers
        $registry->register('provider1', '2.6');
        $registry->registerBatch([
            'provider2' => '3.0',
            'provider3' => '2.5',
        ]);

        // Check providers exist
        $this->assertTrue($registry->hasProvider('provider1'));
        $this->assertTrue($registry->hasProvider('provider2'));
        $this->assertTrue($registry->hasProvider('provider3'));

        // Get versions
        $this->assertEquals('2.6', $registry->getVersionForProvider('provider1'));
        $this->assertEquals('3.0', $registry->getVersionForProvider('provider2'));
        $this->assertEquals('2.5', $registry->getVersionForProvider('provider3'));

        // Check all providers
        $providers = $registry->getProviders();
        $this->assertArrayHasKey('provider1', $providers);
        $this->assertArrayHasKey('provider2', $providers);
        $this->assertArrayHasKey('provider3', $providers);

        // Unregister one
        $registry->unregister('provider2');
        $this->assertFalse($registry->hasProvider('provider2'));

        // Others should still exist
        $this->assertTrue($registry->hasProvider('provider1'));
        $this->assertTrue($registry->hasProvider('provider3'));
    }
}
