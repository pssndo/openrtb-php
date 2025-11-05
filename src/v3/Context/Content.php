<?php

declare(strict_types=1);

namespace OpenRTB\v3\Context;

use OpenRTB\Common\Collection;
use OpenRTB\Common\Resources\Content as CommonContent;

class Content extends CommonContent
{
    /**
     * @var array<string, string|array<string>|int>
     */
    protected static array $schema = [
        'artist' => 'string',
        'genre' => 'string',
        'album' => 'string',
        'isrc' => 'string',
        'cat' => 'array',
        'cattax' => 'int',
        'prodq' => 'int',
        'context' => 'int',
        'userrating' => 'string',
        'qagmediarating' => 'int',
        'livestream' => 'int',
        'sourcerelationship' => 'int',
        'len' => 'int',
        'language' => 'string',
        'embeddable' => 'int',
        'data' => 'array',
    ];

    /**
     * @return array<string, string|array<string>|int>
     */
    protected static function getBaseSchema(): array
    {
        return static::$schema;
    }

    public static function getSchema(): array
    {
        return array_merge(parent::getSchema(), static::getBaseSchema());
    }

    public function setArtist(string $artist): static
    {
        return $this->set('artist', $artist);
    }

    public function getArtist(): ?string
    {
        return $this->get('artist');
    }

    public function setGenre(string $genre): static
    {
        return $this->set('genre', $genre);
    }

    public function getGenre(): ?string
    {
        return $this->get('genre');
    }

    public function setAlbum(string $album): static
    {
        return $this->set('album', $album);
    }

    public function getAlbum(): ?string
    {
        return $this->get('album');
    }

    public function setIsrc(string $isrc): static
    {
        return $this->set('isrc', $isrc);
    }

    public function getIsrc(): ?string
    {
        return $this->get('isrc');
    }

    /** @param Collection<string>|array<string> $cat */
    public function setCat(Collection|array $cat): static
    {
        return $this->set('cat', $cat);
    }

    /** @return list<string>|null */
    public function getCat(): ?array
    {
        return $this->get('cat');
    }

    public function setCattax(int $cattax): static
    {
        return $this->set('cattax', $cattax);
    }

    public function getCattax(): ?int
    {
        return $this->get('cattax');
    }

    public function setProdq(int $prodq): static
    {
        return $this->set('prodq', $prodq);
    }

    public function getProdq(): ?int
    {
        return $this->get('prodq');
    }

    public function setContext(int $context): static
    {
        return $this->set('context', $context);
    }

    public function getContext(): ?int
    {
        return $this->get('context');
    }

    public function setUserrating(string $userrating): static
    {
        return $this->set('userrating', $userrating);
    }

    public function getUserrating(): ?string
    {
        return $this->get('userrating');
    }

    public function setQagmediarating(int $qagmediarating): static
    {
        return $this->set('qagmediarating', $qagmediarating);
    }

    public function getQagmediarating(): ?int
    {
        return $this->get('qagmediarating');
    }

    public function setLivestream(int $livestream): static
    {
        return $this->set('livestream', $livestream);
    }

    public function getLivestream(): ?int
    {
        return $this->get('livestream');
    }

    public function setSourcerelationship(int $sourcerelationship): static
    {
        return $this->set('sourcerelationship', $sourcerelationship);
    }

    public function getSourcerelationship(): ?int
    {
        return $this->get('sourcerelationship');
    }

    public function setLen(int $len): static
    {
        return $this->set('len', $len);
    }

    public function getLen(): ?int
    {
        return $this->get('len');
    }

    public function setLanguage(string $language): static
    {
        return $this->set('language', $language);
    }

    public function getLanguage(): ?string
    {
        return $this->get('language');
    }

    public function setEmbeddable(int $embeddable): static
    {
        return $this->set('embeddable', $embeddable);
    }

    public function getEmbeddable(): ?int
    {
        return $this->get('embeddable');
    }

    /** @param list<array<string, mixed>> $data */
    public function setData(array $data): static
    {
        return $this->set('data', $data);
    }

    /** @return list<array<string, mixed>>|null */
    public function getData(): ?array
    {
        return $this->get('data');
    }
}
