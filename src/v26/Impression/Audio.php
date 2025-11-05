<?php

declare(strict_types=1);

namespace OpenRTB\v26\Impression;

use OpenRTB\Common\Collection;
use OpenRTB\Common\HasData;
use OpenRTB\Common\Resources\Ext;
use OpenRTB\Interfaces\ObjectInterface;

/**
 * @see https://iabtechlab.com/wp-content/uploads/2022/04/OpenRTB-2-6_FINAL.pdf#page=27
 */
class Audio implements ObjectInterface
{
    use HasData;

    /**
     * @var array<string, class-string|string|array<string>>
     */
    protected static array $schema = [
        'mimes' => ['string'],
        'minduration' => 'int',
        'maxduration' => 'int',
        'protocols' => ['int'],
        'maxseq' => 'int',
        'api' => ['int'],
        'ext' => Ext::class,
    ];

    public static function getSchema(): array
    {
        return static::$schema;
    }

    /** @param Collection<string>|array<string> $mimes */
    public function setMimes(Collection|array $mimes): static
    {
        return $this->set('mimes', $mimes);
    }

    /** @return list<string>|null */
    public function getMimes(): ?array
    {
        return $this->get('mimes');
    }

    public function setMinduration(int $minduration): static
    {
        return $this->set('minduration', $minduration);
    }

    public function getMinduration(): ?int
    {
        return $this->get('minduration');
    }

    public function setMaxduration(int $maxduration): static
    {
        return $this->set('maxduration', $maxduration);
    }

    public function getMaxduration(): ?int
    {
        return $this->get('maxduration');
    }

    /** @param Collection<int>|array<int> $protocols */
    public function setProtocols(Collection|array $protocols): static
    {
        return $this->set('protocols', $protocols);
    }

    /** @return list<int>|null */
    public function getProtocols(): ?array
    {
        return $this->get('protocols');
    }

    public function setMaxseq(int $maxseq): static
    {
        return $this->set('maxseq', $maxseq);
    }

    public function getMaxseq(): ?int
    {
        return $this->get('maxseq');
    }

    /** @param Collection<int>|array<int> $api */
    public function setApi(Collection|array $api): static
    {
        return $this->set('api', $api);
    }

    /** @return list<int>|null */
    public function getApi(): ?array
    {
        return $this->get('api');
    }

    public function setExt(Ext $ext): static
    {
        return $this->set('ext', $ext);
    }

    public function getExt(): ?Ext
    {
        return $this->get('ext');
    }
}
