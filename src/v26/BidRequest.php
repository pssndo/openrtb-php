<?php

declare(strict_types=1);

namespace OpenRTB\v26;

use OpenRTB\Common\HasData;
use OpenRTB\Common\Resources\Ext;
use OpenRTB\Interfaces\ObjectInterface;
use OpenRTB\v26\Context\App;
use OpenRTB\v26\Context\Device;
use OpenRTB\v26\Context\Regs;
use OpenRTB\v26\Context\Site;
use OpenRTB\v26\Context\Source;
use OpenRTB\v26\Context\User;
use OpenRTB\v26\Enums\AuctionType;
use OpenRTB\v26\Impression\Imp;
use OpenRTB\Common\Collection;

/**
 * @see https://iabtechlab.com/wp-content/uploads/2022/04/OpenRTB-2-6_FINAL.pdf#page=19
 */
class BidRequest implements ObjectInterface
{
    use HasData;

    /**
     * @var array<string, string|class-string|list<class-string>|list<string>>
     */
    protected static array $schema = [
        'imp' => [Imp::class],
        'site' => Site::class,
        'app' => App::class,
        'device' => Device::class,
        'user' => User::class,
        'regs' => Regs::class,
        'source' => Source::class,
        'at' => AuctionType::class,
        'ext' => Ext::class,
        'id' => 'string',
        'test' => 'int',
        'tmax' => 'int',
        'wseat' => ['string'],
        'bseat' => ['string'],
        'allimps' => 'int',
        'cur' => ['string'],
        'wlang' => ['string'],
        'wlangb' => ['string'],
        'bcat' => ['string'],
        'badv' => ['string'],
        'bapp' => ['string'],
    ];

    public static function getSchema(): array
    {
        return static::$schema;
    }

    public function setId(string $id): static
    {
        return $this->set('id', $id);
    }

    public function getId(): ?string
    {
        return $this->get('id');
    }

    public function addImp(Imp $imp): static
    {
        $imps = $this->getImp() ?: new Collection([], Imp::class);
        $imps->add($imp);

        return $this->setImp($imps);
    }

    /** @return Collection<Imp>|null */
    public function getImp(): ?Collection
    {
        $value = $this->get('imp');
        if ($value instanceof Collection) {
            return $value;
        }
        if (is_array($value)) {
            return new Collection($value, Imp::class);
        }
        return null;
    }

    /** @param Collection<Imp>|array<Imp> $imp */
    public function setImp(Collection|array $imp): static
    {
        $collection = $imp instanceof Collection ? $imp : new Collection($imp, Imp::class);
        return $this->set('imp', $collection);
    }

    public function setSite(?Site $site): static
    {
        return $this->set('site', $site);
    }

    public function getSite(): ?Site
    {
        return $this->get('site');
    }

    public function setApp(?App $app): static
    {
        return $this->set('app', $app);
    }

    public function getApp(): ?App
    {
        return $this->get('app');
    }

    public function setDevice(Device $device): static
    {
        return $this->set('device', $device);
    }

    public function getDevice(): ?Device
    {
        return $this->get('device');
    }

    public function setUser(User $user): static
    {
        return $this->set('user', $user);
    }

    public function getUser(): ?User
    {
        return $this->get('user');
    }

    public function setTest(int $test): static
    {
        return $this->set('test', $test);
    }

    public function getTest(): ?int
    {
        return $this->get('test');
    }

    public function setAt(AuctionType $at): static
    {
        return $this->set('at', $at);
    }

    public function getAt(): ?AuctionType
    {
        return $this->get('at');
    }

    public function setTmax(int $tmax): static
    {
        return $this->set('tmax', $tmax);
    }

    public function getTmax(): ?int
    {
        return $this->get('tmax');
    }

    /** @param Collection<string>|array<string> $wseat */
    public function setWseat(Collection|array $wseat): static
    {
        return $this->set('wseat', is_array($wseat) ? $wseat : $wseat->toArray());
    }

    /** @return Collection<string>|null */
    public function getWseat(): ?Collection
    {
        $wseat = $this->get('wseat');
        if (is_array($wseat)) {
            return new Collection($wseat);
        }
        return $wseat;
    }

    /** @param Collection<string>|array<string> $bseat */
    public function setBseat(Collection|array $bseat): static
    {
        return $this->set('bseat', is_array($bseat) ? $bseat : $bseat->toArray());
    }

    /** @return Collection<string>|null */
    public function getBseat(): ?Collection
    {
        $bseat = $this->get('bseat');
        if (is_array($bseat)) {
            return new Collection($bseat);
        }
        return $bseat;
    }

    public function setAllimps(int $allimps): static
    {
        return $this->set('allimps', $allimps);
    }

    public function getAllimps(): ?int
    {
        return $this->get('allimps');
    }

    /** @param Collection<string>|array<string> $cur */
    public function setCur(Collection|array $cur): static
    {
        return $this->set('cur', is_array($cur) ? $cur : $cur->toArray());
    }

    /** @return Collection<string>|null */
    public function getCur(): ?Collection
    {
        $cur = $this->get('cur');
        if ($cur === null) {
            return null;
        }
        return new Collection($cur, 'string');
    }

    /** @param Collection<string>|array<string> $wlang */
    public function setWlang(Collection|array $wlang): static
    {
        return $this->set('wlang', is_array($wlang) ? $wlang : $wlang->toArray());
    }

    /** @return Collection<string>|null */
    public function getWlang(): ?Collection
    {
        return new Collection($this->get('wlang') ?? [], 'string');
    }

    /** @param Collection<string>|array<string> $wlangb */
    public function setWlangb(Collection|array $wlangb): static
    {
        return $this->set('wlangb', is_array($wlangb) ? $wlangb : $wlangb->toArray());
    }

    /** @return Collection<string>|null */
    public function getWlangb(): ?Collection
    {
        return new Collection($this->get('wlangb') ?? [], 'string');
    }

    /** @param Collection<string>|array<string> $bcat */
    public function setBcat(Collection|array $bcat): static
    {
        return $this->set('bcat', is_array($bcat) ? $bcat : $bcat->toArray());
    }

    /** @return Collection<string>|null */
    public function getBcat(): ?Collection
    {
        return new Collection($this->get('bcat') ?? [], 'string');
    }

    /** @param Collection<string>|array<string> $badv */
    public function setBadv(Collection|array $badv): static
    {
        return $this->set('badv', is_array($badv) ? $badv : $badv->toArray());
    }

    /** @return Collection<string>|null */
    public function getBadv(): ?Collection
    {
        return new Collection($this->get('badv') ?? [], 'string');
    }

    /** @param Collection<string>|array<string> $bapp */
    public function setBapp(Collection|array $bapp): static
    {
        return $this->set('bapp', is_array($bapp) ? $bapp : $bapp->toArray());
    }

    /** @return Collection<string>|null */
    public function getBapp(): ?Collection
    {
        return new Collection($this->get('bapp') ?? [], 'string');
    }

    public function setRegs(Regs $regs): static
    {
        return $this->set('regs', $regs);
    }

    public function getRegs(): ?Regs
    {
        return $this->get('regs');
    }

    public function setSource(Source $source): static
    {
        return $this->set('source', $source);
    }

    public function getSource(): ?Source
    {
        return $this->get('source');
    }

    public function setExt(Ext $ext): static
    {
        return $this->set('ext', $ext);
    }

    public function getExt(): ?Ext
    {
        return $this->get('ext');
    }
}
