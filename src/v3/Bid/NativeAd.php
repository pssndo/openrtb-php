<?php

declare(strict_types=1);

namespace OpenRTB\v3\Bid;

use OpenRTB\Common\HasData;
use OpenRTB\Interfaces\ObjectInterface;

class NativeAd implements ObjectInterface
{
    use HasData;

    protected static array $schema = [
        'link' => Link::class,
        'asset' => [Asset::class],
        'event' => [Event::class],
        'privacy' => 'string',
    ];

    public static function getSchema(): array
    {
        return static::$schema;
    }

    public function setLink(Link $link): self
    {
        return $this->set('link', $link);
    }

    public function getLink(): ?Link
    {
        return $this->get('link');
    }

    /** @param list<Asset> $asset */
    public function setAsset(array $asset): self
    {
        return $this->set('asset', $asset);
    }

    /** @return list<Asset>|null */
    public function getAsset(): ?array
    {
        return $this->get('asset');
    }

    /** @param list<Event> $event */
    public function setEvent(array $event): self
    {
        return $this->set('event', $event);
    }

    /** @return list<Event>|null */
    public function getEvent(): ?array
    {
        return $this->get('event');
    }

    public function setPrivacy(string $privacy): self
    {
        return $this->set('privacy', $privacy);
    }

    public function getPrivacy(): ?string
    {
        return $this->get('privacy');
    }
}
