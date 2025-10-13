<?php

declare(strict_types=1);

namespace OpenRTB\v3\Bid;

use OpenRTB\v3\BaseObject;
use OpenRTB\v3\Enums\Bid\CreativeAttribute;
use OpenRTB\v3\Enums\Placement\ApiFramework;

class Ad extends BaseObject
{
    /** @var array<string, class-string|array<class-string>> */
    protected static array $schema = [
        'attr' => [CreativeAttribute::class],
        'apis' => [ApiFramework::class],
        'display' => DisplayAd::class,
        'video' => VideoAd::class,
        'audio' => AudioAd::class,
        'native' => NativeAd::class,
        'audit' => Audit::class,
    ];

    public function setId(string $id): static
    {
        return $this->set('id', $id);
    }

    public function getId(): ?string
    {
        return $this->get('id');
    }

    public function setAname(string $aname): static
    {
        return $this->set('aname', $aname);
    }

    public function getAname(): ?string
    {
        return $this->get('aname');
    }

    public function setCrid(string $crid): static
    {
        return $this->set('crid', $crid);
    }

    public function getCrid(): ?string
    {
        return $this->get('crid');
    }

    /** @param list<string> $adomain */
    public function setAdomain(array $adomain): static
    {
        return $this->set('adomain', $adomain);
    }

    /** @return list<string>|null */
    public function getAdomain(): ?array
    {
        return $this->get('adomain');
    }

    /** @param list<string> $bundle */
    public function setBundle(array $bundle): static
    {
        return $this->set('bundle', $bundle);
    }

    /** @return list<string>|null */
    public function getBundle(): ?array
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

    /** @param list<string> $cat */
    public function setCat(array $cat): static
    {
        return $this->set('cat', $cat);
    }

    /** @return list<string>|null */
    public function getCat(): ?array
    {
        return $this->get('cat');
    }

    public function setCattax(int $cattax): static
    {
        return $this->set('cattax', $cattax);
    }

    public function getCattax(): ?int
    {
        return $this->get('cattax');
    }

    public function setLang(string $lang): static
    {
        return $this->set('lang', $lang);
    }

    public function getLang(): ?string
    {
        return $this->get('lang');
    }

    /** @param list<CreativeAttribute> $attr */
    public function setAttr(array $attr): static
    {
        return $this->set('attr', $attr);
    }

    /** @return list<CreativeAttribute>|null */
    public function getAttr(): ?array
    {
        return $this->get('attr');
    }

    public function setSecure(int $secure): static
    {
        return $this->set('secure', $secure);
    }

    public function getSecure(): ?int
    {
        return $this->get('secure');
    }

    public function setMrating(int $mrating): static
    {
        return $this->set('mrating', $mrating);
    }

    public function getMrating(): ?int
    {
        return $this->get('mrating');
    }

    public function setInit(int $init): static
    {
        return $this->set('init', $init);
    }

    public function getInit(): ?int
    {
        return $this->get('init');
    }

    public function setLastmod(int $lastmod): static
    {
        return $this->set('lastmod', $lastmod);
    }

    public function getLastmod(): ?int
    {
        return $this->get('lastmod');
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

    public function setDur(int $dur): static
    {
        return $this->set('dur', $dur);
    }

    public function getDur(): ?int
    {
        return $this->get('dur');
    }

    /** @param list<ApiFramework> $apis */
    public function setApis(array $apis): static
    {
        return $this->set('apis', $apis);
    }

    /** @return list<ApiFramework>|null */
    public function getApis(): ?array
    {
        return $this->get('apis');
    }

    public function setDisplay(DisplayAd $display): static
    {
        return $this->set('display', $display);
    }

    public function getDisplay(): ?DisplayAd
    {
        return $this->get('display');
    }

    public function setVideo(VideoAd $video): static
    {
        return $this->set('video', $video);
    }

    public function getVideo(): ?VideoAd
    {
        return $this->get('video');
    }

    public function setAudio(AudioAd $audio): static
    {
        return $this->set('audio', $audio);
    }

    public function getAudio(): ?AudioAd
    {
        return $this->get('audio');
    }

    public function setNative(NativeAd $native): static
    {
        return $this->set('native', $native);
    }

    public function getNative(): ?NativeAd
    {
        return $this->get('native');
    }

    public function setAudit(Audit $audit): static
    {
        return $this->set('audit', $audit);
    }

    public function getAudit(): ?Audit
    {
        return $this->get('audit');
    }
}
