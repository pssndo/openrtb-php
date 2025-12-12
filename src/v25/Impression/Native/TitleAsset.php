<?php

declare(strict_types=1);

namespace OpenRTB\v25\Impression\Native;

/**
 * Title Asset for Native Ads
 *
 * @see https://www.iab.com/wp-content/uploads/2016/03/OpenRTB-Native-Ads-Specification-1-2_2016.pdf
 */
class TitleAsset extends NativeAsset
{
    private int $len;

    public function __construct(int $id, int $len, bool $required = true)
    {
        parent::__construct($id, $required);
        $this->len = $len;
    }

    public function setLen(int $len): static
    {
        $this->len = $len;
        return $this;
    }

    public function getLen(): int
    {
        return $this->len;
    }

    protected function getAssetData(): array
    {
        return [
            'title' => [
                'len' => $this->len,
            ],
        ];
    }

    public static function fromArray(array $data): static
    {
        $asset = new static(
            $data['id'],
            $data['title']['len'] ?? 90,
            ($data['required'] ?? 0) === 1
        );

        if (isset($data['ext'])) {
            $asset->setExt($data['ext']);
        }

        return $asset;
    }
}