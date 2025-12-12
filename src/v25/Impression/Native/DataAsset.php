<?php

declare(strict_types=1);

namespace OpenRTB\v25\Impression\Native;

/**
 * Data Asset for Native Ads
 *
 * @see https://www.iab.com/wp-content/uploads/2016/03/OpenRTB-Native-Ads-Specification-1-2_2016.pdf
 */
class DataAsset extends NativeAsset
{
    // Data type constants
    public const TYPE_SPONSORED = 1;
    public const TYPE_DESC = 2;
    public const TYPE_RATING = 3;
    public const TYPE_LIKES = 4;
    public const TYPE_DOWNLOADS = 5;
    public const TYPE_PRICE = 6;
    public const TYPE_SALEPRICE = 7;
    public const TYPE_PHONE = 8;
    public const TYPE_ADDRESS = 9;
    public const TYPE_DESC2 = 10;
    public const TYPE_DISPLAYURL = 11;
    public const TYPE_CTATEXT = 12;

    private int $type;
    private ?int $len = null;

    public function __construct(int $id, int $type, ?int $len = null, bool $required = false)
    {
        parent::__construct($id, $required);
        $this->type = $type;
        $this->len = $len;
    }

    public function setType(int $type): static
    {
        $this->type = $type;
        return $this;
    }

    public function getType(): int
    {
        return $this->type;
    }

    public function setLen(int $len): static
    {
        $this->len = $len;
        return $this;
    }

    public function getLen(): ?int
    {
        return $this->len;
    }

    protected function getAssetData(): array
    {
        $data = [
            'type' => $this->type,
        ];

        if ($this->len !== null) {
            $data['len'] = $this->len;
        }

        return ['data' => $data];
    }

    public static function fromArray(array $data): static
    {
        $dataData = $data['data'] ?? [];

        $asset = new static(
            $data['id'],
            $dataData['type'] ?? self::TYPE_DESC,
            $dataData['len'] ?? null,
            ($data['required'] ?? 0) === 1
        );

        if (isset($data['ext'])) {
            $asset->setExt($data['ext']);
        }

        return $asset;
    }
}