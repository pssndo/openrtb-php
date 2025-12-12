<?php

declare(strict_types=1);

namespace OpenRTB\v25\Impression\Native;

use JsonSerializable;

/**
 * Native Ad Request object following IAB Native Ad Specification 1.2
 *
 * This object automatically serializes to JSON string for OpenRTB 2.5 compatibility
 *
 * @see https://www.iab.com/wp-content/uploads/2016/03/OpenRTB-Native-Ads-Specification-1-2_2016.pdf
 */
class NativeRequest implements JsonSerializable
{
    private string $ver = '1.2';

    /** @var int|null Context type */
    private ?int $context = null;

    /** @var int|null Placement type */
    private ?int $plcmttype = null;

    /** @var int|null Context subtype */
    private ?int $contextsubtype = null;

    /** @var int|null Placement count */
    private ?int $plcmtcnt = null;

    /** @var int|null Sequence number */
    private ?int $seq = null;

    /** @var array<NativeAsset> Assets array */
    private array $assets = [];

    /** @var int|null Asset URL support */
    private ?int $aurlsupport = null;

    /** @var int|null Data URL support */
    private ?int $durlsupport = null;

    /** @var array<int>|null Event trackers */
    private ?array $eventtrackers = null;

    /** @var int|null Privacy indicator */
    private ?int $privacy = null;

    /** @var mixed|null Extension object */
    private mixed $ext = null;

    public function setVer(string $ver): static
    {
        $this->ver = $ver;
        return $this;
    }

    public function getVer(): string
    {
        return $this->ver;
    }

    /**
     * Context type
     * 1 = Content-centric context
     * 2 = Social-centric context
     * 3 = Product context
     */
    public function setContext(int $context): static
    {
        $this->context = $context;
        return $this;
    }

    public function getContext(): ?int
    {
        return $this->context;
    }

    /**
     * Placement type
     * 1 = In the feed of content
     * 2 = In the atomic unit of the content
     * 3 = Outside the core content
     * 4 = Recommendation widget
     */
    public function setPlcmttype(int $plcmttype): static
    {
        $this->plcmttype = $plcmttype;
        return $this;
    }

    public function getPlcmttype(): ?int
    {
        return $this->plcmttype;
    }

    public function setContextsubtype(int $contextsubtype): static
    {
        $this->contextsubtype = $contextsubtype;
        return $this;
    }

    public function getContextsubtype(): ?int
    {
        return $this->contextsubtype;
    }

    public function setPlcmtcnt(int $plcmtcnt): static
    {
        $this->plcmtcnt = $plcmtcnt;
        return $this;
    }

    public function getPlcmtcnt(): ?int
    {
        return $this->plcmtcnt;
    }

    public function setSeq(int $seq): static
    {
        $this->seq = $seq;
        return $this;
    }

    public function getSeq(): ?int
    {
        return $this->seq;
    }

    public function addAsset(NativeAsset $asset): static
    {
        $this->assets[] = $asset;
        return $this;
    }

    /** @param array<NativeAsset> $assets */
    public function setAssets(array $assets): static
    {
        $this->assets = $assets;
        return $this;
    }

    /** @return array<NativeAsset> */
    public function getAssets(): array
    {
        return $this->assets;
    }

    public function setAurlsupport(int $aurlsupport): static
    {
        $this->aurlsupport = $aurlsupport;
        return $this;
    }

    public function getAurlsupport(): ?int
    {
        return $this->aurlsupport;
    }

    public function setDurlsupport(int $durlsupport): static
    {
        $this->durlsupport = $durlsupport;
        return $this;
    }

    public function getDurlsupport(): ?int
    {
        return $this->durlsupport;
    }

    /** @param array<int> $eventtrackers */
    public function setEventtrackers(array $eventtrackers): static
    {
        $this->eventtrackers = $eventtrackers;
        return $this;
    }

    /** @return array<int>|null */
    public function getEventtrackers(): ?array
    {
        return $this->eventtrackers;
    }

    public function setPrivacy(int $privacy): static
    {
        $this->privacy = $privacy;
        return $this;
    }

    public function getPrivacy(): ?int
    {
        return $this->privacy;
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
     * Convert to JSON-serializable array
     *
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        $data = [
            'ver' => $this->ver,
        ];

        if ($this->context !== null) {
            $data['context'] = $this->context;
        }

        if ($this->plcmttype !== null) {
            $data['plcmttype'] = $this->plcmttype;
        }

        if ($this->contextsubtype !== null) {
            $data['contextsubtype'] = $this->contextsubtype;
        }

        if ($this->plcmtcnt !== null) {
            $data['plcmtcnt'] = $this->plcmtcnt;
        }

        if ($this->seq !== null) {
            $data['seq'] = $this->seq;
        }

        if (!empty($this->assets)) {
            $data['assets'] = array_map(fn($asset) => $asset->jsonSerialize(), $this->assets);
        }

        if ($this->aurlsupport !== null) {
            $data['aurlsupport'] = $this->aurlsupport;
        }

        if ($this->durlsupport !== null) {
            $data['durlsupport'] = $this->durlsupport;
        }

        if ($this->eventtrackers !== null) {
            $data['eventtrackers'] = $this->eventtrackers;
        }

        if ($this->privacy !== null) {
            $data['privacy'] = $this->privacy;
        }

        if ($this->ext !== null) {
            $data['ext'] = $this->ext;
        }

        return $data;
    }

    /**
     * Convert to JSON string (for OpenRTB 2.5 compatibility)
     */
    public function toJson(int $options = 0): string
    {
        $json = json_encode($this->jsonSerialize(), $options);
        if ($json === false) {
            throw new \RuntimeException('Failed to encode NativeRequest to JSON');
        }
        return $json;
    }

    /**
     * Create from JSON string
     */
    public static function fromJson(string $json): static
    {
        $data = json_decode($json, true);
        if (!is_array($data)) {
            throw new \InvalidArgumentException('Invalid JSON for NativeRequest');
        }

        return static::fromArray($data);
    }

    /**
     * Create from array
     *
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        $request = new self();

        if (isset($data['ver'])) {
            $request->setVer($data['ver']);
        }

        if (isset($data['context'])) {
            $request->setContext($data['context']);
        }

        if (isset($data['plcmttype'])) {
            $request->setPlcmttype($data['plcmttype']);
        }

        if (isset($data['contextsubtype'])) {
            $request->setContextsubtype($data['contextsubtype']);
        }

        if (isset($data['plcmtcnt'])) {
            $request->setPlcmtcnt($data['plcmtcnt']);
        }

        if (isset($data['seq'])) {
            $request->setSeq($data['seq']);
        }

        if (isset($data['assets']) && is_array($data['assets'])) {
            foreach ($data['assets'] as $assetData) {
                $request->addAsset(NativeAsset::fromArray($assetData));
            }
        }

        if (isset($data['aurlsupport'])) {
            $request->setAurlsupport($data['aurlsupport']);
        }

        if (isset($data['durlsupport'])) {
            $request->setDurlsupport($data['durlsupport']);
        }

        if (isset($data['eventtrackers'])) {
            $request->setEventtrackers($data['eventtrackers']);
        }

        if (isset($data['privacy'])) {
            $request->setPrivacy($data['privacy']);
        }

        if (isset($data['ext'])) {
            $request->setExt($data['ext']);
        }

        /** @var static */
        return $request;
    }
}
