<?php

declare(strict_types=1);

namespace OpenRTB\Common\Resources;

use OpenRTB\Common\Collection;
use OpenRTB\Common\HasData;
use OpenRTB\Interfaces\ObjectInterface;

class Content implements ObjectInterface
{
    use HasData;

    /**
     * @return array<string, string|class-string|array<string>|int>
     */
    protected static function getBaseSchema(): array
    {
        return [
            'id' => 'string',
            'episode' => 'int',
            'title' => 'string',
            'series' => 'string',
            'season' => 'string',
            'artist' => 'string',
            'genre' => 'string',
            'album' => 'string',
            'isrc' => 'string',
            'producer' => Producer::class,
            'url' => 'string',
            'cat' => 'array',
            'prodq' => 'int',
            'videoquality' => 'int',
            'context' => 'int',
            'contentrating' => 'string',
            'userrating' => 'string',
            'qagmediarating' => 'int',
            'keywords' => 'string',
            'livestream' => 'int',
            'sourcerelationship' => 'int',
            'len' => 'int',
            'language' => 'string',
            'embeddable' => 'int',
            'data' => 'array',
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
        $value = $this->get('id');
        assert($value === null || is_string($value));
        return $value;
    }

    public function setEpisode(int $episode): static
    {
        return $this->set('episode', $episode);
    }

    public function getEpisode(): ?int
    {
        $value = $this->get('episode');
        assert($value === null || is_int($value));
        return $value;
    }

    public function setTitle(string $title): static
    {
        return $this->set('title', $title);
    }

    public function getTitle(): ?string
    {
        $value = $this->get('title');
        assert($value === null || is_string($value));
        return $value;
    }

    public function setSeries(string $series): static
    {
        return $this->set('series', $series);
    }

    public function getSeries(): ?string
    {
        $value = $this->get('series');
        assert($value === null || is_string($value));
        return $value;
    }

    public function setSeason(string $season): static
    {
        return $this->set('season', $season);
    }

    public function getSeason(): ?string
    {
        $value = $this->get('season');
        assert($value === null || is_string($value));
        return $value;
    }

    public function setProducer(Producer $producer): static
    {
        return $this->set('producer', $producer);
    }

    public function getProducer(): ?Producer
    {
        $value = $this->get('producer');
        assert($value === null || $value instanceof Producer);
        return $value;
    }

    public function setUrl(string $url): static
    {
        return $this->set('url', $url);
    }

    public function getUrl(): ?string
    {
        $value = $this->get('url');
        assert($value === null || is_string($value));
        return $value;
    }

    public function setContentrating(string $contentrating): static
    {
        return $this->set('contentrating', $contentrating);
    }

    public function getContentrating(): ?string
    {
        $value = $this->get('contentrating');
        assert($value === null || is_string($value));
        return $value;
    }

    public function setKeywords(string $keywords): static
    {
        return $this->set('keywords', $keywords);
    }

    public function getKeywords(): ?string
    {
        $value = $this->get('keywords');
        assert($value === null || is_string($value));
        return $value;
    }

    public function setArtist(string $artist): static
    {
        return $this->set('artist', $artist);
    }

    public function getArtist(): ?string
    {
        $value = $this->get('artist');
        assert($value === null || is_string($value));
        return $value;
    }

    public function setGenre(string $genre): static
    {
        return $this->set('genre', $genre);
    }

    public function getGenre(): ?string
    {
        $value = $this->get('genre');
        assert($value === null || is_string($value));
        return $value;
    }

    public function setAlbum(string $album): static
    {
        return $this->set('album', $album);
    }

    public function getAlbum(): ?string
    {
        $value = $this->get('album');
        assert($value === null || is_string($value));
        return $value;
    }

    public function setIsrc(string $isrc): static
    {
        return $this->set('isrc', $isrc);
    }

    public function getIsrc(): ?string
    {
        $value = $this->get('isrc');
        assert($value === null || is_string($value));
        return $value;
    }

    /** @param Collection<string>|array<string> $cat */
    public function setCat(Collection|array $cat): static
    {
        return $this->set('cat', $cat);
    }

    /** @return list<string>|null */
    public function getCat(): ?array
    {
        $value = $this->get('cat');
        assert($value === null || is_array($value));
        /** @var list<string>|null */
        return $value;
    }

    public function setProdq(int $prodq): static
    {
        return $this->set('prodq', $prodq);
    }

    public function getProdq(): ?int
    {
        $value = $this->get('prodq');
        assert($value === null || is_int($value));
        return $value;
    }

    /**
     * @deprecated This field is deprecated in OpenRTB 2.5
     */
    public function setVideoquality(int $videoquality): static
    {
        return $this->set('videoquality', $videoquality);
    }

    /**
     * @deprecated This field is deprecated in OpenRTB 2.5
     * @return int|null
     */
    public function getVideoquality(): ?int
    {
        $value = $this->get('videoquality');
        assert($value === null || is_int($value));
        return $value;
    }

    public function setContext(int $context): static
    {
        return $this->set('context', $context);
    }

    public function getContext(): ?int
    {
        $value = $this->get('context');
        assert($value === null || is_int($value));
        return $value;
    }

    public function setUserrating(string $userrating): static
    {
        return $this->set('userrating', $userrating);
    }

    public function getUserrating(): ?string
    {
        $value = $this->get('userrating');
        assert($value === null || is_string($value));
        return $value;
    }

    public function setQagmediarating(int $qagmediarating): static
    {
        return $this->set('qagmediarating', $qagmediarating);
    }

    public function getQagmediarating(): ?int
    {
        $value = $this->get('qagmediarating');
        assert($value === null || is_int($value));
        return $value;
    }

    public function setLivestream(int $livestream): static
    {
        return $this->set('livestream', $livestream);
    }

    public function getLivestream(): ?int
    {
        $value = $this->get('livestream');
        assert($value === null || is_int($value));
        return $value;
    }

    public function setSourcerelationship(int $sourcerelationship): static
    {
        return $this->set('sourcerelationship', $sourcerelationship);
    }

    public function getSourcerelationship(): ?int
    {
        $value = $this->get('sourcerelationship');
        assert($value === null || is_int($value));
        return $value;
    }

    public function setLen(int $len): static
    {
        return $this->set('len', $len);
    }

    public function getLen(): ?int
    {
        $value = $this->get('len');
        assert($value === null || is_int($value));
        return $value;
    }

    public function setLanguage(string $language): static
    {
        return $this->set('language', $language);
    }

    public function getLanguage(): ?string
    {
        $value = $this->get('language');
        assert($value === null || is_string($value));
        return $value;
    }

    public function setEmbeddable(int $embeddable): static
    {
        return $this->set('embeddable', $embeddable);
    }

    public function getEmbeddable(): ?int
    {
        $value = $this->get('embeddable');
        assert($value === null || is_int($value));
        return $value;
    }

    /** @param list<array<string, mixed>> $data */
    public function setData(array $data): static
    {
        return $this->set('data', $data);
    }

    /** @return list<array<string, mixed>>|null */
    public function getData(): ?array
    {
        $value = $this->get('data');
        assert($value === null || is_array($value));
        /** @var list<array<string, mixed>>|null */
        return $value;
    }
}
