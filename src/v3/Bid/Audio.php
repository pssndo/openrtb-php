<?php

declare(strict_types=1);

namespace OpenRTB\v3\Bid;

use OpenRTB\Common\HasData;
use OpenRTB\Interfaces\ObjectInterface;
use OpenRTB\v3\Enums\Placement\ApiFramework;

/**
 * @see https://iabtechlab.com/wp-content/uploads/2022/04/OpenRTB-3.0-Framework-FINAL.pdf#page=60
 */
class Audio implements ObjectInterface
{
    use HasData;

    /**
     * @var array<string, string|int|array<class-string>>
     */
    protected static array $schema = [
        'adm' => 'string',
        'curl' => 'string',
        'api' => [ApiFramework::class],
        'mime' => 'string',
        'dur' => 'int',
    ];

    /**
     * @return array<string, string|int|array<class-string>>
     */
    public static function getSchema(): array
    {
        return static::$schema;
    }

    public function getAdm(): ?string
    {
        return $this->get('adm');
    }

    public function setAdm(string $adm): static
    {
        return $this->set('adm', $adm);
    }

    public function getCurl(): ?string
    {
        return $this->get('curl');
    }

    public function setCurl(string $curl): static
    {
        return $this->set('curl', $curl);
    }

    /** @return list<ApiFramework>|null */
    public function getApi(): ?array
    {
        return $this->get('api');
    }

    /** @param list<ApiFramework> $api */
    public function setApi(array $api): static
    {
        return $this->set('api', $api);
    }

    public function getMime(): ?string
    {
        return $this->get('mime');
    }

    public function setMime(string $mime): static
    {
        return $this->set('mime', $mime);
    }

    public function getDur(): ?int
    {
        return $this->get('dur');
    }

    public function setDur(int $dur): static
    {
        return $this->set('dur', $dur);
    }
}
