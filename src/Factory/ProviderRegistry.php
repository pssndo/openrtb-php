<?php

declare(strict_types=1);

namespace OpenRTB\Factory;

/**
 * Registry mapping ad exchange providers to their OpenRTB version.
 *
 * Configure provider mappings in your application bootstrap
 */
class ProviderRegistry
{
    private static ?self $instance = null;

    /**
     * @var array<string, string> Provider name => OpenRTB version
     */
    private array $providers = [
        // Default provider mappings
        'epom' => '3.0',
        'dianomi' => '2.6',
        'google' => '2.6',
        'rubicon' => '2.6',
        'appnexus' => '2.5',
        'pubmatic' => '2.6',
    ];

    private function __construct()
    {
    }

    public static function getInstance(): self
    {
        if (null === self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * Register a provider with its OpenRTB version.
     */
    public function register(string $provider, string $version): void
    {
        $this->providers[strtolower($provider)] = $version;
    }

    /**
     * Register multiple providers at once.
     *
     * @param array<string, string> $providers
     */
    public function registerBatch(array $providers): void
    {
        foreach ($providers as $provider => $version) {
            $this->register($provider, $version);
        }
    }

    /**
     * Get OpenRTB version for a provider.
     */
    public function getVersionForProvider(string $provider): string
    {
        $provider = strtolower($provider);

        if (!isset($this->providers[$provider])) {
            throw new \InvalidArgumentException("Unknown provider: {$provider}. Available providers: ".implode(', ', array_keys($this->providers)));
        }

        return $this->providers[$provider];
    }

    /**
     * Check if provider is registered.
     */
    public function hasProvider(string $provider): bool
    {
        return isset($this->providers[strtolower($provider)]);
    }

    /**
     * Get all registered providers.
     *
     * @return array<string, string>
     */
    public function getProviders(): array
    {
        return $this->providers;
    }

    /**
     * Remove a provider from registry.
     */
    public function unregister(string $provider): void
    {
        unset($this->providers[strtolower($provider)]);
    }

    /**
     * Reset registry (useful for testing).
     */
    public function reset(): void
    {
        self::$instance = null;
    }
}
