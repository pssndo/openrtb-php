<?php

declare(strict_types=1);

namespace OpenRTB\Factory;

use InvalidArgumentException;

/**
 * Factory for creating OpenRTB version-specific builders and parsers
 *
 * Usage by version:
 *   $factory = new OpenRTBFactory('2.6');
 *   $builder = $factory->createRequestBuilder();
 *   $parser = $factory->createParser();
 *
 * Usage by provider:
 *   $factory = OpenRTBFactory::forProvider('epom');
 *   $builder = $factory->createRequestBuilder();
 */
class OpenRTBFactory
{
    private string $version;

    /**
     * Supported OpenRTB versions (with backward compatibility mapping)
     */
    private const SUPPORTED_VERSIONS = [
        '2.5' => '2.6', // Map 2.5 to 2.6 (backward compatible)
        '2.6' => '2.6',
        '3.0' => '3.0',
    ];

    public function __construct(string $version)
    {
        if (!isset(self::SUPPORTED_VERSIONS[$version])) {
            throw new InvalidArgumentException(
                "Unsupported OpenRTB version: {$version}. Supported versions: " .
                implode(', ', array_keys(self::SUPPORTED_VERSIONS))
            );
        }

        $this->version = self::SUPPORTED_VERSIONS[$version];
    }

    /**
     * Create factory from provider name using configured mapping
     *
     * Example: OpenRTBFactory::forProvider('epom') returns factory for OpenRTB 3.0
     */
    public static function forProvider(string $provider, ?ProviderRegistry $registry = null): self
    {
        $registry = $registry ?? ProviderRegistry::getInstance();
        $version = $registry->getVersionForProvider($provider);

        return new self($version);
    }

    /**
     * Create a request builder for the configured OpenRTB version
     */
    public function createRequestBuilder(): object
    {
        return match ($this->version) {
            '2.6' => new \OpenRTB\v26\Util\RequestBuilder(),
            '3.0' => new \OpenRTB\v3\Util\RequestBuilder(),
            default => throw new InvalidArgumentException("No builder for version {$this->version}"),
        };
    }

    /**
     * Create a parser for the configured OpenRTB version
     */
    public function createParser(): object
    {
        return match ($this->version) {
            '2.6' => new \OpenRTB\v26\Util\Parser(),
            '3.0' => new \OpenRTB\v3\Util\Parser(),
            default => throw new InvalidArgumentException("No parser for version {$this->version}"),
        };
    }

    /**
     * Create a response builder for the configured OpenRTB version
     */
    public function createResponseBuilder(string $requestId = ''): object
    {
        return match ($this->version) {
            '2.6' => new \OpenRTB\v26\Util\BidResponseBuilder($requestId),
            '3.0' => new \OpenRTB\v3\Util\ResponseBuilder($requestId),
            default => throw new InvalidArgumentException("No response builder for version {$this->version}"),
        };
    }

    /**
     * Create a validator for the configured OpenRTB version
     */
    public function createValidator(): object
    {
        return match ($this->version) {
            '2.6' => new \OpenRTB\v26\Util\Validator(),
            '3.0' => new \OpenRTB\v3\Util\Validator(),
            default => throw new InvalidArgumentException("No validator for version {$this->version}"),
        };
    }

    /**
     * Get the current OpenRTB version
     */
    public function getVersion(): string
    {
        return $this->version;
    }

    /**
     * Check if a version is supported
     */
    public static function isVersionSupported(string $version): bool
    {
        return isset(self::SUPPORTED_VERSIONS[$version]);
    }

    /**
     * Get all supported versions
     *
     * @return array<string>
     */
    public static function getSupportedVersions(): array
    {
        return array_keys(self::SUPPORTED_VERSIONS);
    }
}
