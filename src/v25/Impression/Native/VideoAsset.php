<?php

declare(strict_types=1);

namespace OpenRTB\v25\Impression\Native;

/**
 * Video Asset for Native Ads
 *
 * @see https://www.iab.com/wp-content/uploads/2016/03/OpenRTB-Native-Ads-Specification-1-2_2016.pdf
 */
class VideoAsset extends NativeAsset
{
    /** @var array<string>|null */
    private ?array $mimes = null;

    private ?int $minduration = null;
    private ?int $maxduration = null;

    /** @var array<int>|null */
    private ?array $protocols = null;

    public function __construct(int $id, bool $required = false)
    {
        parent::__construct($id, $required);
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

    public function setMinduration(int $minduration): static
    {
        $this->minduration = $minduration;
        return $this;
    }

    public function getMinduration(): ?int
    {
        return $this->minduration;
    }

    public function setMaxduration(int $maxduration): static
    {
        $this->maxduration = $maxduration;
        return $this;
    }

    public function getMaxduration(): ?int
    {
        return $this->maxduration;
    }

    /** @param array<int> $protocols */
    public function setProtocols(array $protocols): static
    {
        $this->protocols = $protocols;
        return $this;
    }

    /** @return array<int>|null */
    public function getProtocols(): ?array
    {
        return $this->protocols;
    }

    protected function getAssetData(): array
    {
        $video = [];

        if ($this->mimes !== null) {
            $video['mimes'] = $this->mimes;
        }

        if ($this->minduration !== null) {
            $video['minduration'] = $this->minduration;
        }

        if ($this->maxduration !== null) {
            $video['maxduration'] = $this->maxduration;
        }

        if ($this->protocols !== null) {
            $video['protocols'] = $this->protocols;
        }

        return ['video' => $video];
    }

    public static function fromArray(array $data): static
    {
        $videoData = $data['video'] ?? [];

        $asset = new self(
            $data['id'],
            ($data['required'] ?? 0) === 1
        );

        if (isset($videoData['mimes'])) {
            $asset->setMimes($videoData['mimes']);
        }

        if (isset($videoData['minduration'])) {
            $asset->setMinduration($videoData['minduration']);
        }

        if (isset($videoData['maxduration'])) {
            $asset->setMaxduration($videoData['maxduration']);
        }

        if (isset($videoData['protocols'])) {
            $asset->setProtocols($videoData['protocols']);
        }

        if (isset($data['ext'])) {
            $asset->setExt($data['ext']);
        }

        /** @var static */
        return $asset;
    }
}