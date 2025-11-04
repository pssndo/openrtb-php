<?php

declare(strict_types=1);

namespace OpenRTB\v26\Impression;

use OpenRTB\Common\HasData;
use OpenRTB\Common\Resources\Ext;
use OpenRTB\Interfaces\ObjectInterface;
use OpenRTB\Common\Collection;

/**
 * @see https://iabtechlab.com/wp-content/uploads/2022/04/OpenRTB-2-6_FINAL.pdf#page=23
 */
class Banner implements ObjectInterface
{
    use HasData;

    /**
     * @var array<string, string|class-string|array<class-string>|array<int>|array<string>>
     */
    protected static array $schema = [
        'format' => [Format::class],
        'w' => 'int',
        'h' => 'int',
        'pos' => 'int',
        'btype' => 'array',
        'battr' => 'array',
        'mimes' => ['string'],
        'topframe' => 'int',
        'expdir' => ['int'],
        'api' => 'array',
        'id' => 'string',
        'vcm' => 'int',
        'ext' => Ext::class,
    ];

    /**
     * @return array<string, string|class-string|array<class-string>|array<int>|array<string>>
     */
    public static function getSchema(): array
    {
        return static::$schema;
    }

    /** @param Collection<Format>|array<Format> $format */
    public function setFormat(Collection|array $format): static
    {
        return $this->set('format', $format);
    }

    /** @return list<Format>|null */
    public function getFormat(): ?array
    {
        return $this->get('format');
    }

    public function setW(int $w): static
    {
        return $this->set('w', $w);
    }

    public function getW(): ?int
    {
        return $this->get('w');
    }

    public function setH(int $h): static
    {
        return $this->set('h', $h);
    }

    public function getH(): ?int
    {
        return $this->get('h');
    }

    public function setPos(int $pos): static
    {
        return $this->set('pos', $pos);
    }

    public function getPos(): ?int
    {
        return $this->get('pos');
    }

    /** @param Collection<int>|array<int> $btype */
    public function setBtype(Collection|array $btype): static
    {
        return $this->set('btype', $btype);
    }

    /** @return list<int>|null */
    public function getBtype(): ?array
    {
        return $this->get('btype');
    }

    /** @param Collection<int>|array<int> $battr */
    public function setBattr(Collection|array $battr): static
    {
        return $this->set('battr', $battr);
    }

    /** @return list<int>|null */
    public function getBattr(): ?array
    {
        return $this->get('battr');
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

    public function setId(string $id): static
    {
        return $this->set('id', $id);
    }

    public function getId(): ?string
    {
        return $this->get('id');
    }

    public function setVcm(int $vcm): static
    {
        return $this->set('vcm', $vcm);
    }

    public function getVcm(): ?int
    {
        return $this->get('vcm');
    }

    /** @param array<string> $mimes */
    public function setMimes(array $mimes): static
    {
        return $this->set('mimes', $mimes);
    }

    /** @return list<string>|null */
    public function getMimes(): ?array
    {
        return $this->get('mimes');
    }

    public function setTopframe(int $topframe): static
    {
        return $this->set('topframe', $topframe);
    }

    public function getTopframe(): ?int
    {
        return $this->get('topframe');
    }

    /** @param array<int> $expdir */
    public function setExpdir(array $expdir): static
    {
        return $this->set('expdir', $expdir);
    }

    /** @return list<int>|null */
    public function getExpdir(): ?array
    {
        return $this->get('expdir');
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
