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

    protected static array $schema = [
        'adm' => 'string',
        'curl' => 'string',
        'api' => [ApiFramework::class],
        'mime' => 'string',
        'dur' => 'int',
    ];

    public static function getSchema(): array
    {
        return static::$schema;
    }

    public function getAdm(): ?string
    {
        return $this->get('adm');
    }

    public function setAdm(string $adm): self
    {
        return $this->set('adm', $adm);
    }

    public function getCurl(): ?string
    {
        return $this->get('curl');
    }

    public function setCurl(string $curl): self
    {
        return $this->set('curl', $curl);
    }

    /** @return list<ApiFramework>|null */
    public function getApi(): ?array
    {
        return $this->get('api');
    }

    /** @param list<ApiFramework> $api */
    public function setApi(array $api): self
    {
        return $this->set('api', $api);
    }

    public function getMime(): ?string
    {
        return $this->get('mime');
    }

    public function setMime(string $mime): self
    {
        return $this->set('mime', $mime);
    }

    public function getDur(): ?int
    {
        return $this->get('dur');
    }

    public function setDur(int $dur): self
    {
        return $this->set('dur', $dur);
    }
}
