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

class AudioPlacement implements ObjectInterface
{
    use HasData;

    /** @var array<string, class-string|array<class-string>> */
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

    public static function getSchema(): array
    {
        return static::$schema;
    }

    public function toArray(): array
    {
        $array = $this->data;
        if (isset($array['playmethod'])) {
            $array['playmethod'] = array_map(fn($pm) => $pm->value, $array['playmethod']);
        }
        if (isset($array['playend'])) {
            $array['playend'] = $array['playend']->value;
        }
        if (isset($array['feed'])) {
            $array['feed'] = $array['feed']->value;
        }
        if (isset($array['nvol'])) {
            $array['nvol'] = $array['nvol']->value;
        }
        if (isset($array['api'])) {
            $array['api'] = array_map(fn($api) => $api->value, $array['api']);
        }
        if (isset($array['ctype'])) {
            $array['ctype'] = array_map(fn($ct) => $ct->value, $array['ctype']);
        }
        if (isset($array['delivery'])) {
            $array['delivery'] = array_map(fn($dm) => $dm->value, $array['delivery']);
        }
        if (isset($array['comp'])) {
            $array['comp'] = array_map(fn($comp) => $comp->toArray(), $array['comp']);
        }
        if (isset($array['comptype'])) {
            $array['comptype'] = array_map(fn($ct) => $ct->value, $array['comptype']);
        }
        return $array;
    }

    public function toJson(int $flags = JSON_UNESCAPED_SLASHES): string|false
    {
        return json_encode($this->toArray(), $flags);
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

    /** @param list<PlaybackMethod> $playmethod */
    public function setPlaymethod(array $playmethod): static
    {
        return $this->set('playmethod', $playmethod);
    }

    /** @return list<PlaybackMethod>|null */
    public function getPlaymethod(): ?array
    {
        return $this->get('playmethod');
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

    /** @param list<string> $mime */
    public function setMime(array $mime): static
    {
        return $this->set('mime', $mime);
    }

    /** @return list<string>|null */
    public function getMime(): ?array
    {
        return $this->get('mime');
    }

    /** @param list<ApiFramework> $api */
    public function setApi(array $api): static
    {
        return $this->set('api', $api);
    }

    /** @return list<ApiFramework>|null */
    public function getApi(): ?array
    {
        return $this->get('api');
    }

    /** @param list<CreativeType> $ctype */
    public function setCtype(array $ctype): static
    {
        return $this->set('ctype', $ctype);
    }

    /** @return list<CreativeType>|null */
    public function getCtype(): ?array
    {
        return $this->get('ctype');
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

    /** @param list<DeliveryMethod> $delivery */
    public function setDelivery(array $delivery): static
    {
        return $this->set('delivery', $delivery);
    }

    /** @return list<DeliveryMethod>|null */
    public function getDelivery(): ?array
    {
        return $this->get('delivery');
    }

    public function setMaxseq(int $maxseq): static
    {
        return $this->set('maxseq', $maxseq);
    }

    public function getMaxseq(): ?int
    {
        return $this->get('maxseq');
    }

    /** @param list<DisplayPlacement> $comp */
    public function setComp(array $comp): static
    {
        return $this->set('comp', $comp);
    }

    /** @return list<DisplayPlacement>|null */
    public function getComp(): ?array
    {
        return $this->get('comp');
    }

    /** @param list<CompanionType> $comptype */
    public function setComptype(array $comptype): static
    {
        return $this->set('comptype', $comptype);
    }

    /** @return list<CompanionType>|null */
    public function getComptype(): ?array
    {
        return $this->get('comptype');
    }
}
