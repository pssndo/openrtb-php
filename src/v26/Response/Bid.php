<?php

declare(strict_types=1);

namespace OpenRTB\v26\Response;

use OpenRTB\Common\Resources\Bid as CommonBid;
use OpenRTB\Common\Resources\Ext;

/**
 * @see https://iabtechlab.com/wp-content/uploads/2022/04/OpenRTB-2-6_FINAL.pdf#page=45
 */
class Bid extends CommonBid
{
    /**
     * @return array<string, string|class-string|int|array<string>|array<int>>
     */
    protected static function getBaseSchema(): array
    {
        return [
            'impid' => 'string',
            'adid' => 'string',
            'nurl' => 'string',
            'burl' => 'string',
            'lurl' => 'string',
            'adm' => 'string',
            'adomain' => ['string'],
            'bundle' => 'string',
            'iurl' => 'string',
            'cid' => 'string',
            'crid' => 'string',
            'tactic' => 'string',
            'cat' => ['string'],
            'attr' => ['int'],
            'api' => 'int',
            'protocol' => 'int',
            'qagmediarating' => 'int',
            'dealid' => 'string',
            'w' => 'int',
            'h' => 'int',
            'exp' => 'int',
            'ext' => Ext::class,
        ];
    }

    public static function getSchema(): array
    {
        return array_merge(parent::getSchema(), static::getBaseSchema());
    }

    public function setImpid(string $impid): static
    {
        return $this->set('impid', $impid);
    }

    public function getImpid(): ?string
    {
        return $this->get('impid');
    }

    public function setAdid(string $adid): static
    {
        return $this->set('adid', $adid);
    }

    public function getAdid(): ?string
    {
        return $this->get('adid');
    }

    public function setNurl(string $nurl): static
    {
        return $this->set('nurl', $nurl);
    }

    public function getNurl(): ?string
    {
        return $this->get('nurl');
    }

    public function setBurl(string $burl): static
    {
        return $this->set('burl', $burl);
    }

    public function getBurl(): ?string
    {
        return $this->get('burl');
    }

    public function setLurl(string $lurl): static
    {
        return $this->set('lurl', $lurl);
    }

    public function getLurl(): ?string
    {
        return $this->get('lurl');
    }

    public function setAdm(string $adm): static
    {
        return $this->set('adm', $adm);
    }

    public function getAdm(): ?string
    {
        return $this->get('adm');
    }

    public function setCrid(string $crid): static
    {
        return $this->set('crid', $crid);
    }

    public function getCrid(): ?string
    {
        return $this->get('crid');
    }

    public function setDealid(string $dealid): static
    {
        return $this->set('dealid', $dealid);
    }

    public function getDealid(): ?string
    {
        return $this->get('dealid');
    }

    public function setW(int $w): static
    {
        return $this->set('w', $w);
    }

    public function getW(): ?int
    {
        return $this->get('w');
    }

    public function setH(int $h): static
    {
        return $this->set('h', $h);
    }

    public function getH(): ?int
    {
        return $this->get('h');
    }

    /** @param array<string> $adomain */
    public function setAdomain(array $adomain): static
    {
        return $this->set('adomain', $adomain);
    }

    /** @return list<string>|null */
    public function getAdomain(): ?array
    {
        return $this->get('adomain');
    }

    public function setBundle(string $bundle): static
    {
        return $this->set('bundle', $bundle);
    }

    public function getBundle(): ?string
    {
        return $this->get('bundle');
    }

    public function setIurl(string $iurl): static
    {
        return $this->set('iurl', $iurl);
    }

    public function getIurl(): ?string
    {
        return $this->get('iurl');
    }

    public function setCid(string $cid): static
    {
        return $this->set('cid', $cid);
    }

    public function getCid(): ?string
    {
        return $this->get('cid');
    }

    public function setTactic(string $tactic): static
    {
        return $this->set('tactic', $tactic);
    }

    public function getTactic(): ?string
    {
        return $this->get('tactic');
    }

    /** @param array<string> $cat */
    public function setCat(array $cat): static
    {
        return $this->set('cat', $cat);
    }

    /** @return list<string>|null */
    public function getCat(): ?array
    {
        return $this->get('cat');
    }

    /** @param array<int> $attr */
    public function setAttr(array $attr): static
    {
        return $this->set('attr', $attr);
    }

    /** @return list<int>|null */
    public function getAttr(): ?array
    {
        return $this->get('attr');
    }

    public function setApi(int $api): static
    {
        return $this->set('api', $api);
    }

    public function getApi(): ?int
    {
        return $this->get('api');
    }

    public function setProtocol(int $protocol): static
    {
        return $this->set('protocol', $protocol);
    }

    public function getProtocol(): ?int
    {
        return $this->get('protocol');
    }

    public function setQagmediarating(int $qagmediarating): static
    {
        return $this->set('qagmediarating', $qagmediarating);
    }

    public function getQagmediarating(): ?int
    {
        return $this->get('qagmediarating');
    }

    public function setExp(int $exp): static
    {
        return $this->set('exp', $exp);
    }

    public function getExp(): ?int
    {
        return $this->get('exp');
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
