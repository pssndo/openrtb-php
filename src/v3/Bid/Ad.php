<?php

declare(strict_types=1);

namespace OpenRTB\v3\Bid;

use OpenRTB\Common\HasData;
use OpenRTB\Interfaces\ObjectInterface;
use OpenRTB\v3\Enums\Bid\CreativeAttribute;

class Ad implements ObjectInterface
{
    use HasData;

    protected static array $schema = [
        'id' => 'string',
        'adomain' => 'array',
        'bundle' => 'array',
        'cat' => 'array',
        'cattax' => 'int',
        'lang' => 'string',
        'attr' => [CreativeAttribute::class],
        'secure' => 'int',
        'init' => 'int',
        'lastmod' => 'int',
        'display' => Display::class,
        'video' => Video::class,
        'audio' => Audio::class,
        'native' => NativeAd::class,
        'audit' => Audit::class,
    ];

    public static function getSchema(): array
    {
        return static::$schema;
    }

    public function setId(string $id): self
    {
        return $this->set('id', $id);
    }

    public function getId(): ?string
    {
        return $this->get('id');
    }

    /** @param list<string> $adomain */
    public function setAdomain(array $adomain): self
    {
        return $this->set('adomain', $adomain);
    }

    /** @return list<string>|null */
    public function getAdomain(): ?array
    {
        return $this->get('adomain');
    }

    /** @param list<string> $bundle */
    public function setBundle(array $bundle): self
    {
        return $this->set('bundle', $bundle);
    }

    /** @return list<string>|null */
    public function getBundle(): ?array
    {
        return $this->get('bundle');
    }

    /** @param list<string> $cat */
    public function setCat(array $cat): self
    {
        return $this->set('cat', $cat);
    }

    /** @return list<string>|null */
    public function getCat(): ?array
    {
        return $this->get('cat');
    }

    public function setCattax(int $cattax): self
    {
        return $this->set('cattax', $cattax);
    }

    public function getCattax(): ?int
    {
        return $this->get('cattax');
    }

    public function setLang(string $lang): self
    {
        return $this->set('lang', $lang);
    }

    public function getLang(): ?string
    {
        return $this->get('lang');
    }

    /** @param list<CreativeAttribute> $attr */
    public function setAttr(array $attr): self
    {
        return $this->set('attr', $attr);
    }

    /** @return list<CreativeAttribute>|null */
    public function getAttr(): ?array
    {
        return $this->get('attr');
    }

    public function setSecure(int $secure): self
    {
        return $this->set('secure', $secure);
    }

    public function getSecure(): ?int
    {
        return $this->get('secure');
    }

    public function setInit(int $init): self
    {
        return $this->set('init', $init);
    }

    public function getInit(): ?int
    {
        return $this->get('init');
    }

    public function setLastmod(int $lastmod): self
    {
        return $this->set('lastmod', $lastmod);
    }

    public function getLastmod(): ?int
    {
        return $this->get('lastmod');
    }

    public function setDisplay(Display $display): self
    {
        return $this->set('display', $display);
    }

    public function getDisplay(): ?Display
    {
        return $this->get('display');
    }

    public function setVideo(Video $video): self
    {
        return $this->set('video', $video);
    }

    public function getVideo(): ?Video
    {
        return $this->get('video');
    }

    public function setAudio(Audio $audio): self
    {
        return $this->set('audio', $audio);
    }

    public function getAudio(): ?Audio
    {
        return $this->get('audio');
    }

    public function setNative(NativeAd $native): self
    {
        return $this->set('native', $native);
    }

    public function getNative(): ?NativeAd
    {
        return $this->get('native');
    }

    public function setAudit(Audit $audit): self
    {
        return $this->set('audit', $audit);
    }

    public function getAudit(): ?Audit
    {
        return $this->get('audit');
    }
}
