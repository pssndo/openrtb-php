<?php

declare(strict_types=1);

namespace OpenRTB\v25\Impression\Native;

/**
 * Image Asset for Native Ads
 *
 * @see https://www.iab.com/wp-content/uploads/2016/03/OpenRTB-Native-Ads-Specification-1-2_2016.pdf
 */
class ImageAsset extends NativeAsset
{
    // Image type constants
    public const TYPE_ICON = 1;
    public const TYPE_LOGO = 2;
    public const TYPE_MAIN = 3;

    private ?int $type = null;
    private ?int $w = null;
    private ?int $h = null;
    private ?int $wmin = null;
    private ?int $hmin = null;
    private ?int $wratios = null;
    private ?int $hratios = null;
    private ?int $wratio = null;
    private ?int $hratio = null;

    /** @var array<string>|null */
    private ?array $mimes = null;

    public function __construct(int $id, ?int $type = null, ?int $wmin = null, ?int $hmin = null, bool $required = true)
    {
        parent::__construct($id, $required);
        $this->type = $type;
        $this->wmin = $wmin;
        $this->hmin = $hmin;
    }

    public function setType(int $type): static
    {
        $this->type = $type;
        return $this;
    }

    public function getType(): ?int
    {
        return $this->type;
    }

    public function setW(int $w): static
    {
        $this->w = $w;
        return $this;
    }

    public function getW(): ?int
    {
        return $this->w;
    }

    public function setH(int $h): static
    {
        $this->h = $h;
        return $this;
    }

    public function getH(): ?int
    {
        return $this->h;
    }

    public function setWmin(int $wmin): static
    {
        $this->wmin = $wmin;
        return $this;
    }

    public function getWmin(): ?int
    {
        return $this->wmin;
    }

    public function setHmin(int $hmin): static
    {
        $this->hmin = $hmin;
        return $this;
    }

    public function getHmin(): ?int
    {
        return $this->hmin;
    }

    public function setWratios(int $wratios): static
    {
        $this->wratios = $wratios;
        return $this;
    }

    public function getWratios(): ?int
    {
        return $this->wratios;
    }

    public function setHratios(int $hratios): static
    {
        $this->hratios = $hratios;
        return $this;
    }

    public function getHratios(): ?int
    {
        return $this->hratios;
    }

    public function setWratio(int $wratio): static
    {
        $this->wratio = $wratio;
        return $this;
    }

    public function getWratio(): ?int
    {
        return $this->wratio;
    }

    public function setHratio(int $hratio): static
    {
        $this->hratio = $hratio;
        return $this;
    }

    public function getHratio(): ?int
    {
        return $this->hratio;
    }

    /** @param array<string> $mimes */
    public function setMimes(array $mimes): static
    {
        $this->mimes = $mimes;
        return $this;
    }

    /** @return array<string>|null */
    public function getMimes(): ?array
    {
        return $this->mimes;
    }

    protected function getAssetData(): array
    {
        $img = [];

        if ($this->type !== null) {
            $img['type'] = $this->type;
        }

        if ($this->w !== null) {
            $img['w'] = $this->w;
        }

        if ($this->h !== null) {
            $img['h'] = $this->h;
        }

        if ($this->wmin !== null) {
            $img['wmin'] = $this->wmin;
        }

        if ($this->hmin !== null) {
            $img['hmin'] = $this->hmin;
        }

        if ($this->wratios !== null) {
            $img['wratios'] = $this->wratios;
        }

        if ($this->hratios !== null) {
            $img['hratios'] = $this->hratios;
        }

        if ($this->wratio !== null) {
            $img['wratio'] = $this->wratio;
        }

        if ($this->hratio !== null) {
            $img['hratio'] = $this->hratio;
        }

        if ($this->mimes !== null) {
            $img['mimes'] = $this->mimes;
        }

        return ['img' => $img];
    }

    public static function fromArray(array $data): static
    {
        $imgData = $data['img'] ?? [];

        $asset = new static(
            $data['id'],
            $imgData['type'] ?? null,
            $imgData['wmin'] ?? null,
            $imgData['hmin'] ?? null,
            ($data['required'] ?? 0) === 1
        );

        if (isset($imgData['w'])) {
            $asset->setW($imgData['w']);
        }

        if (isset($imgData['h'])) {
            $asset->setH($imgData['h']);
        }

        if (isset($imgData['wratios'])) {
            $asset->setWratios($imgData['wratios']);
        }

        if (isset($imgData['hratios'])) {
            $asset->setHratios($imgData['hratios']);
        }

        if (isset($imgData['wratio'])) {
            $asset->setWratio($imgData['wratio']);
        }

        if (isset($imgData['hratio'])) {
            $asset->setHratio($imgData['hratio']);
        }

        if (isset($imgData['mimes'])) {
            $asset->setMimes($imgData['mimes']);
        }

        if (isset($data['ext'])) {
            $asset->setExt($data['ext']);
        }

        return $asset;
    }
}
