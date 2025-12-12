<?php

declare(strict_types=1);

namespace OpenRTB\v25\Impression\Native;

use JsonSerializable;

/**
 * Base Native Asset class
 *
 * @see https://www.iab.com/wp-content/uploads/2016/03/OpenRTB-Native-Ads-Specification-1-2_2016.pdf
 */
abstract class NativeAsset implements JsonSerializable
{
    protected int $id;
    protected bool $required;
    protected mixed $ext = null;

    public function __construct(int $id, bool $required = false)
    {
        $this->id = $id;
        $this->required = $required;
    }

    public function setId(int $id): static
    {
        $this->id = $id;
        return $this;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setRequired(bool $required): static
    {
        $this->required = $required;
        return $this;
    }

    public function isRequired(): bool
    {
        return $this->required;
    }

    public function setExt(mixed $ext): static
    {
        $this->ext = $ext;
        return $this;
    }

    public function getExt(): mixed
    {
        return $this->ext;
    }

    /**
     * Get the base asset data
     *
     * @return array<string, mixed>
     */
    protected function getBaseData(): array
    {
        $data = [
            'id' => $this->id,
            'required' => $this->required ? 1 : 0,
        ];

        if ($this->ext !== null) {
            $data['ext'] = $this->ext;
        }

        return $data;
    }

    /**
     * Get asset-specific data
     *
     * @return array<string, mixed>
     */
    abstract protected function getAssetData(): array;

    /**
     * Convert to JSON-serializable array
     *
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return array_merge($this->getBaseData(), $this->getAssetData());
    }

    /**
     * Create asset from array
     *
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        // Determine asset type from data
        if (isset($data['title'])) {
            return TitleAsset::fromArray($data);
        }

        if (isset($data['img'])) {
            return ImageAsset::fromArray($data);
        }

        if (isset($data['data'])) {
            return DataAsset::fromArray($data);
        }

        if (isset($data['video'])) {
            return VideoAsset::fromArray($data);
        }

        throw new \InvalidArgumentException('Unknown asset type in data');
    }
}