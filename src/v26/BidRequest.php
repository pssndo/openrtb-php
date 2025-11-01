<?php

declare(strict_types=1);

namespace OpenRTB\v26;

use OpenRTB\Common\HasData;
use OpenRTB\Interfaces\ObjectInterface;
use OpenRTB\v26\Context\App;
use OpenRTB\v26\Enums\AuctionType;
use OpenRTB\v26\Context\Device;
use OpenRTB\v26\Context\Regs;
use OpenRTB\v26\Context\Site;
use OpenRTB\v26\Context\Source;
use OpenRTB\v26\Context\User;
use OpenRTB\v26\Impression\Imp;

/**
 * @see https://iabtechlab.com/wp-content/uploads/2022/04/OpenRTB-2-6_FINAL.pdf#page=19
 */
class BidRequest implements ObjectInterface
{
    use HasData;

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
        'wseat' => 'array',
        'bseat' => 'array',
        'allimps' => 'int',
        'cur' => 'array',
        'wlang' => 'array',
        'wlangb' => 'array',
        'bcat' => 'array',
        'badv' => 'array',
        'bapp' => 'array',
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

    /** @param list<Imp> $imp */
    public function setImp(array $imp): static
    {
        return $this->set('imp', $imp);
    }

    /** @return list<Imp>|null */
    public function getImp(): ?array
    {
        return $this->get('imp');
    }

    public function addImp(Imp $imp): static
    {
        $imps = $this->getImp() ?? [];
        $imps[] = $imp;

        return $this->setImp($imps);
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

    /** @param list<string> $wseat */
    public function setWseat(array $wseat): static
    {
        return $this->set('wseat', $wseat);
    }

    /** @return list<string>|null */
    public function getWseat(): ?array
    {
        return $this->get('wseat');
    }

    /** @param list<string> $bseat */
    public function setBseat(array $bseat): static
    {
        return $this->set('bseat', $bseat);
    }

    /** @return list<string>|null */
    public function getBseat(): ?array
    {
        return $this->get('bseat');
    }

    public function setAllimps(int $allimps): static
    {
        return $this->set('allimps', $allimps);
    }

    public function getAllimps(): ?int
    {
        return $this->get('allimps');
    }

    /** @param list<string> $cur */
    public function setCur(array $cur): static
    {
        return $this->set('cur', $cur);
    }

    /** @return list<string>|null */
    public function getCur(): ?array
    {
        return $this->get('cur');
    }

    /** @param list<string> $wlang */
    public function setWlang(array $wlang): static
    {
        return $this->set('wlang', $wlang);
    }

    /** @return list<string>|null */
    public function getWlang(): ?array
    {
        return $this->get('wlang');
    }

    /** @param list<string> $wlangb */
    public function setWlangb(array $wlangb): static
    {
        return $this->set('wlangb', $wlangb);
    }

    /** @return list<string>|null */
    public function getWlangb(): ?array
    {
        return $this->get('wlangb');
    }

    /** @param list<string> $bcat */
    public function setBcat(array $bcat): static
    {
        return $this->set('bcat', $bcat);
    }

    /** @return list<string>|null */
    public function getBcat(): ?array
    {
        return $this->get('bcat');
    }

    /** @param list<string> $badv */
    public function setBadv(array $badv): static
    {
        return $this->set('badv', $badv);
    }

    /** @return list<string>|null */
    public function getBadv(): ?array
    {
        return $this->get('badv');
    }

    /** @param list<string> $bapp */
    public function setBapp(array $bapp): static
    {
        return $this->set('bapp', $bapp);
    }

    /** @return list<string>|null */
    public function getBapp(): ?array
    {
        return $this->get('bapp');
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
