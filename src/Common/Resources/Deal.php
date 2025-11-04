<?php

declare(strict_types=1);

namespace OpenRTB\Common\Resources;

use OpenRTB\Common\Collection;
use OpenRTB\Common\HasData;
use OpenRTB\Interfaces\ObjectInterface;

class Deal implements ObjectInterface
{
    use HasData;

    /**
     * @return array<string, string|float|int|array<string>|class-string>
     */
    protected static function getBaseSchema(): array
    {
        return [
            'id' => 'string',
            'flr' => 'float',
            'flrcur' => 'string',
            'wseat' => ['string'],
            'wadv' => ['string'],
        ];
    }

    public static function getSchema(): array
    {
        return static::getBaseSchema();
    }

    public function setId(string $id): static
    {
        return $this->set('id', $id);
    }

    public function getId(): ?string
    {
        return $this->get('id');
    }

    public function setFlr(float $flr): static
    {
        return $this->set('flr', $flr);
    }

    public function getFlr(): ?float
    {
        return $this->get('flr');
    }

    public function setFlrcur(string $flrcur): static
    {
        return $this->set('flrcur', $flrcur);
    }

    public function getFlrcur(): ?string
    {
        return $this->get('flrcur');
    }

    /** @param Collection<string>|array<string> $wseat */
    public function setWseat(Collection|array $wseat): static
    {
        return $this->set('wseat', is_array($wseat) ? $wseat : $wseat->toArray());
    }

    /** @return Collection<string>|null */
    public function getWseat(): ?Collection
    {
        return new Collection($this->get('wseat') ?? [], 'string');
    }

    /** @param Collection<string>|array<string> $wadv */
    public function setWadv(Collection|array $wadv): static
    {
        return $this->set('wadv', is_array($wadv) ? $wadv : $wadv->toArray());
    }

    /** @return Collection<string>|null */
    public function getWadv(): ?Collection
    {
        return new Collection($this->get('wadv') ?? [], 'string');
    }
}
