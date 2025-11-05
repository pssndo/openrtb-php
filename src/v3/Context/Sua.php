<?php

declare(strict_types=1);

namespace OpenRTB\v3\Context;

use OpenRTB\Common\HasData;
use OpenRTB\Interfaces\ObjectInterface;

class Sua implements ObjectInterface
{
    use HasData;

    /**
     * @var array<string, int|string|array<array<string, string>>>
     */
    protected static array $schema = [
        'browsers' => 'array',
        'platform' => 'array',
        'source' => 'int',
        'model' => 'string',
        'mobile' => 'int',
    ];

    /**
     * @return array<string, int|string|array<array<string, string>>>
     */
    public static function getSchema(): array
    {
        return static::$schema;
    }

    /** @param list<array<string, string>> $browsers */
    public function setBrowsers(array $browsers): static
    {
        return $this->set('browsers', $browsers);
    }

    /** @return list<array<string, string>>|null */
    public function getBrowsers(): ?array
    {
        return $this->get('browsers');
    }

    /** @param list<array<string, string>> $platform */
    public function setPlatform(array $platform): static
    {
        return $this->set('platform', $platform);
    }

    /** @return list<array<string, string>>|null */
    public function getPlatform(): ?array
    {
        return $this->get('platform');
    }

    public function setSource(int $source): static
    {
        return $this->set('source', $source);
    }

    public function getSource(): ?int
    {
        return $this->get('source');
    }

    public function setModel(string $model): static
    {
        return $this->set('model', $model);
    }

    public function getModel(): ?string
    {
        return $this->get('model');
    }

    public function setMobile(int $mobile): static
    {
        return $this->set('mobile', $mobile);
    }

    public function getMobile(): ?int
    {
        return $this->get('mobile');
    }
}
