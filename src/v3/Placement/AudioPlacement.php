<?php

declare(strict_types=1);

namespace OpenRTB\v3\Placement;

use OpenRTB\Common\HasData;
use OpenRTB\Interfaces\ObjectInterface;
use OpenRTB\v3\Enums\CreativeType;
use OpenRTB\v3\Enums\Impression\DeliveryMethod;
use OpenRTB\v3\Enums\Placement\ApiFramework;
use OpenRTB\v3\Enums\Placement\CompanionType;
use OpenRTB\v3\Enums\Placement\FeedType;
use OpenRTB\v3\Enums\Placement\PlaybackCessationMode;
use OpenRTB\v3\Enums\Placement\PlaybackMethod;
use OpenRTB\v3\Enums\Placement\VolumeNormalizationMode;
use OpenRTB\Common\Collection;

class AudioPlacement implements ObjectInterface
{
    use HasData;

    /** @var array<string, string|int|class-string|array<class-string>|array<string>> */
    protected static array $schema = [
        'delay' => 'int',
        'skip' => 'int',
        'skipmin' => 'int',
        'skipafter' => 'int',
        'playmethod' => [PlaybackMethod::class],
        'playend' => PlaybackCessationMode::class,
        'feed' => FeedType::class,
        'nvol' => VolumeNormalizationMode::class,
        'mime' => ['string'],
        'api' => [ApiFramework::class],
        'ctype' => [CreativeType::class],
        'mindur' => 'int',
        'maxdur' => 'int',
        'maxext' => 'int',
        'minbitr' => 'int',
        'maxbitr' => 'int',
        'delivery' => [DeliveryMethod::class],
        'maxseq' => 'int',
        'comp' => [DisplayPlacement::class],
        'comptype' => [CompanionType::class],
    ];

    /**
     * @return array<string, string|int|class-string|array<class-string>|array<string>>
     */
    public static function getSchema(): array
    {
        return static::$schema;
    }

    public function setDelay(int $delay): static
    {
        return $this->set('delay', $delay);
    }

    public function getDelay(): ?int
    {
        return $this->get('delay');
    }

    public function setSkip(int $skip): static
    {
        return $this->set('skip', $skip);
    }

    public function getSkip(): ?int
    {
        return $this->get('skip');
    }

    public function setSkipmin(int $skipmin): static
    {
        return $this->set('skipmin', $skipmin);
    }

    public function getSkipmin(): ?int
    {
        return $this->get('skipmin');
    }

    public function setSkipafter(int $skipafter): static
    {
        return $this->set('skipafter', $skipafter);
    }

    public function getSkipafter(): ?int
    {
        return $this->get('skipafter');
    }

    /** @param Collection<PlaybackMethod>|array<PlaybackMethod> $playmethod */
    public function setPlaymethod(Collection|array $playmethod): static
    {
        return $this->set('playmethod', is_array($playmethod) ? $playmethod : $playmethod->toArray());
    }

    /** @return Collection<PlaybackMethod>|null */
    public function getPlaymethod(): ?Collection
    {
        return new Collection($this->get('playmethod') ?? [], PlaybackMethod::class);
    }

    public function setPlayend(PlaybackCessationMode $playend): static
    {
        return $this->set('playend', $playend);
    }

    public function getPlayend(): ?PlaybackCessationMode
    {
        return $this->get('playend');
    }

    public function setFeed(FeedType $feed): static
    {
        return $this->set('feed', $feed);
    }

    public function getFeed(): ?FeedType
    {
        return $this->get('feed');
    }

    public function setNvol(VolumeNormalizationMode $nvol): static
    {
        return $this->set('nvol', $nvol);
    }

    public function getNvol(): ?VolumeNormalizationMode
    {
        return $this->get('nvol');
    }

    /** @param Collection<string>|array<string> $mime */
    public function setMime(Collection|array $mime): static
    {
        return $this->set('mime', is_array($mime) ? $mime : $mime->toArray());
    }

    /** @return Collection<string>|null */
    public function getMime(): ?Collection
    {
        return new Collection($this->get('mime') ?? [], 'string');
    }

    /** @param Collection<ApiFramework>|array<ApiFramework> $api */
    public function setApi(Collection|array $api): static
    {
        return $this->set('api', is_array($api) ? $api : $api->toArray());
    }

    /** @return Collection<ApiFramework>|null */
    public function getApi(): ?Collection
    {
        return new Collection($this->get('api') ?? [], ApiFramework::class);
    }

    /** @param Collection<CreativeType>|array<CreativeType> $ctype */
    public function setCtype(Collection|array $ctype): static
    {
        return $this->set('ctype', is_array($ctype) ? $ctype : $ctype->toArray());
    }

    /** @return Collection<CreativeType>|null */
    public function getCtype(): ?Collection
    {
        return new Collection($this->get('ctype') ?? [], CreativeType::class);
    }

    public function setMindur(int $mindur): static
    {
        return $this->set('mindur', $mindur);
    }

    public function getMindur(): ?int
    {
        return $this->get('mindur');
    }

    public function setMaxdur(int $maxdur): static
    {
        return $this->set('maxdur', $maxdur);
    }

    public function getMaxdur(): ?int
    {
        return $this->get('maxdur');
    }

    public function setMaxext(int $maxext): static
    {
        return $this->set('maxext', $maxext);
    }

    public function getMaxext(): ?int
    {
        return $this->get('maxext');
    }

    public function setMinbitr(int $minbitr): static
    {
        return $this->set('minbitr', $minbitr);
    }

    public function getMinbitr(): ?int
    {
        return $this->get('minbitr');
    }

    public function setMaxbitr(int $maxbitr): static
    {
        return $this->set('maxbitr', $maxbitr);
    }

    public function getMaxbitr(): ?int
    {
        return $this->get('maxbitr');
    }

    /** @param Collection<DeliveryMethod>|array<DeliveryMethod> $delivery */
    public function setDelivery(Collection|array $delivery): static
    {
        return $this->set('delivery', is_array($delivery) ? $delivery : $delivery->toArray());
    }

    /** @return Collection<DeliveryMethod>|null */
    public function getDelivery(): ?Collection
    {
        return new Collection($this->get('delivery') ?? [], DeliveryMethod::class);
    }

    public function setMaxseq(int $maxseq): static
    {
        return $this->set('maxseq', $maxseq);
    }

    public function getMaxseq(): ?int
    {
        return $this->get('maxseq');
    }

    /** @param Collection<DisplayPlacement>|array<DisplayPlacement> $comp */
    public function setComp(Collection|array $comp): static
    {
        return $this->set('comp', is_array($comp) ? $comp : $comp->toArray());
    }

    /** @return Collection<DisplayPlacement>|null */
    public function getComp(): ?Collection
    {
        return new Collection($this->get('comp') ?? [], DisplayPlacement::class);
    }

    /** @param Collection<CompanionType>|array<CompanionType> $comptype */
    public function setComptype(Collection|array $comptype): static
    {
        return $this->set('comptype', (array)$comptype);
    }

    /** @return Collection<CompanionType>|null */
    public function getComptype(): ?Collection
    {
        return new Collection($this->get('comptype') ?? [], CompanionType::class);
    }
}
