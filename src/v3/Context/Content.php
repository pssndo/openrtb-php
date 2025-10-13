<?php

declare(strict_types=1);

namespace OpenRTB\v3\Context;

use OpenRTB\v3\BaseObject;

class Content extends BaseObject
{
    protected static array $schema = [
        'producer' => Producer::class,
    ];

    public function setId(string $id): static
    {
        return $this->set('id', $id);
    }

    public function getId(): ?string
    {
        return $this->get('id');
    }

    public function setEpisode(int $episode): static
    {
        return $this->set('episode', $episode);
    }

    public function getEpisode(): ?int
    {
        return $this->get('episode');
    }

    public function setTitle(string $title): static
    {
        return $this->set('title', $title);
    }

    public function getTitle(): ?string
    {
        return $this->get('title');
    }

    public function setSeries(string $series): static
    {
        return $this->set('series', $series);
    }

    public function getSeries(): ?string
    {
        return $this->get('series');
    }

    public function setSeason(string $season): static
    {
        return $this->set('season', $season);
    }

    public function getSeason(): ?string
    {
        return $this->get('season');
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

    public function setUrl(string $url): static
    {
        return $this->set('url', $url);
    }

    public function getUrl(): ?string
    {
        return $this->get('url');
    }

    /** @param list<string> $cat */
    public function setCat(array $cat): static
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

    public function setContentrating(string $contentrating): static
    {
        return $this->set('contentrating', $contentrating);
    }

    public function getContentrating(): ?string
    {
        return $this->get('contentrating');
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

    public function setKeywords(string $keywords): static
    {
        return $this->set('keywords', $keywords);
    }

    public function getKeywords(): ?string
    {
        return $this->get('keywords');
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

    public function setProducer(Producer $producer): static
    {
        return $this->set('producer', $producer);
    }

    public function getProducer(): ?Producer
    {
        return $this->get('producer');
    }
}
