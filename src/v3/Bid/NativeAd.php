<?php

declare(strict_types=1);

namespace OpenRTB\v3\Bid;

use OpenRTB\Common\Collection;
use OpenRTB\Common\HasData;
use OpenRTB\Interfaces\ObjectInterface;

class NativeAd implements ObjectInterface
{
    use HasData;

    /**
     * @var array<string, class-string|array<class-string>|array<string>|string>
     */
    protected static array $schema = [
        'link' => Link::class,
        'asset' => [Asset::class],
        'event' => [Event::class],
        'privacy' => 'string',
        'imptrackers' => ['string'],
    ];

    /**
     * @return array<string, class-string|array<class-string>|array<string>|string>
     */
    public static function getSchema(): array
    {
        return static::$schema;
    }

    public function setLink(Link $link): static
    {
        return $this->set('link', $link);
    }

    public function getLink(): ?Link
    {
        return $this->get('link');
    }

    /** @param Collection<Asset>|array<Asset> $asset */
    public function setAsset(Collection|array $asset): static
    {
        $collection = $asset instanceof Collection ? $asset : new Collection($asset, Asset::class);

        return $this->set('asset', $collection);
    }

    /** @return Collection<Asset>|null */
    public function getAsset(): ?Collection
    {
        $value = $this->get('asset');
        if ($value instanceof Collection) {
            return $value;
        }
        if (is_array($value)) {
            return new Collection($value, Asset::class);
        }

        return null;
    }

    /** @param Collection<Event>|array<Event> $event */
    public function setEvent(Collection|array $event): static
    {
        $collection = $event instanceof Collection ? $event : new Collection($event, Event::class);

        return $this->set('event', $collection);
    }

    /** @return Collection<Event>|null */
    public function getEvent(): ?Collection
    {
        $value = $this->get('event');
        if ($value instanceof Collection) {
            return $value;
        }
        if (is_array($value)) {
            return new Collection($value, Event::class);
        }

        return null;
    }

    public function setPrivacy(string $privacy): static
    {
        return $this->set('privacy', $privacy);
    }

    public function getPrivacy(): ?string
    {
        return $this->get('privacy');
    }

    /** @param array<string> $imptrackers */
    public function setImptrackers(array $imptrackers): static
    {
        return $this->set('imptrackers', $imptrackers);
    }

    /** @return list<string>|null */
    public function getImptrackers(): ?array
    {
        return $this->get('imptrackers');
    }
}
