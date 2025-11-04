<?php

declare(strict_types=1);

namespace OpenRTB\v3\Bid;

use OpenRTB\Common\HasData;
use OpenRTB\Interfaces\ObjectInterface;
use OpenRTB\v3\Enums\Bid\CreativeAttribute;
use OpenRTB\Common\Collection;

class Ad implements ObjectInterface
{
    use HasData;

    /**
     * @var array<string, string|int|class-string|array<string>|array<class-string>>
     */
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
        'audit' => Audit::class
    ];

    /**
     * @return array<string, string|int|class-string|array<string>|array<class-string>>
     */
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

    /** @param Collection<string>|array<string> $adomain */
    public function setAdomain(Collection|array $adomain): static
    {
        return $this->set('adomain', $adomain);
    }

    /** @return list<string>|null */
    public function getAdomain(): ?array
    {
        return $this->get('adomain');
    }

    /** @param Collection<string>|array<string> $bundle */
    public function setBundle(Collection|array $bundle): static
    {
        return $this->set('bundle', $bundle);
    }

    /** @return list<string>|null */
    public function getBundle(): ?array
    {
        return $this->get('bundle');
    }

    /** @param Collection<string>|array<string> $cat */
    public function setCat(Collection|array $cat): static
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

    /** @param Collection<CreativeAttribute>|array<CreativeAttribute> $attr */
    public function setAttr(Collection|array $attr): static
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

    public function setDisplay(Display $display): static
    {
        return $this->set('display', $display);
    }

    public function getDisplay(): ?Display
    {
        return $this->get('display');
    }

    public function setVideo(Video $video): static
    {
        return $this->set('video', $video);
    }

    public function getVideo(): ?Video
    {
        return $this->get('video');
    }

    public function setAudio(Audio $audio): static
    {
        return $this->set('audio', $audio);
    }

    public function getAudio(): ?Audio
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
