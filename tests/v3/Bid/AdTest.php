<?php

declare(strict_types=1);

namespace OpenRTB\Tests\v3\Bid;

use PHPUnit\Framework\TestCase;
use OpenRTB\v3\Bid\Ad;
use OpenRTB\v3\Bid\Display;
use OpenRTB\v3\Bid\Video;
use OpenRTB\v3\Bid\Audio;
use OpenRTB\v3\Bid\NativeAd;
use OpenRTB\v3\Bid\Audit;
use OpenRTB\v3\Enums\Bid\CreativeAttribute;

/**
 * @covers \OpenRTB\v3\Bid\Ad
 */
final class AdTest extends TestCase
{
    public function testGetSchema(): void
    {
        $schema = Ad::getSchema();

        $this->assertArrayHasKey('id', $schema);
        $this->assertEquals('string', $schema['id']);
        $this->assertArrayHasKey('adomain', $schema);
        $this->assertEquals('array', $schema['adomain']);
        $this->assertArrayHasKey('bundle', $schema);
        $this->assertEquals('array', $schema['bundle']);
        $this->assertArrayHasKey('cat', $schema);
        $this->assertEquals('array', $schema['cat']);
        $this->assertArrayHasKey('cattax', $schema);
        $this->assertEquals('int', $schema['cattax']);
        $this->assertArrayHasKey('lang', $schema);
        $this->assertEquals('string', $schema['lang']);
        $this->assertArrayHasKey('attr', $schema);
        $this->assertEquals([CreativeAttribute::class], $schema['attr']);
        $this->assertArrayHasKey('secure', $schema);
        $this->assertEquals('int', $schema['secure']);
        $this->assertArrayHasKey('init', $schema);
        $this->assertEquals('int', $schema['init']);
        $this->assertArrayHasKey('lastmod', $schema);
        $this->assertEquals('int', $schema['lastmod']);
        $this->assertArrayHasKey('display', $schema);
        $this->assertEquals(Display::class, $schema['display']);
        $this->assertArrayHasKey('video', $schema);
        $this->assertEquals(Video::class, $schema['video']);
        $this->assertArrayHasKey('audio', $schema);
        $this->assertEquals(Audio::class, $schema['audio']);
        $this->assertArrayHasKey('native', $schema);
        $this->assertEquals(NativeAd::class, $schema['native']);
        $this->assertArrayHasKey('audit', $schema);
        $this->assertEquals(Audit::class, $schema['audit']);
    }

    public function testSetId(): void
    {
        $ad = new Ad();
        $id = 'ad123';
        $ad->setId($id);
        $this->assertEquals($id, $ad->getId());
    }

    public function testGetId(): void
    {
        $ad = new Ad();
        $ad->setId('test_id');
        $this->assertEquals('test_id', $ad->getId());
    }

    public function testSetAdomain(): void
    {
        $ad = new Ad();
        $adomain = ['example.com'];
        $ad->setAdomain($adomain);
        $this->assertEquals($adomain, $ad->getAdomain());
    }

    public function testGetAdomain(): void
    {
        $ad = new Ad();
        $ad->setAdomain(['test.com']);
        $this->assertEquals(['test.com'], $ad->getAdomain());
    }

    public function testSetBundle(): void
    {
        $ad = new Ad();
        $bundle = ['com.example.app'];
        $ad->setBundle($bundle);
        $this->assertEquals($bundle, $ad->getBundle());
    }

    public function testGetBundle(): void
    {
        $ad = new Ad();
        $ad->setBundle(['com.test.app']);
        $this->assertEquals(['com.test.app'], $ad->getBundle());
    }

    public function testSetCat(): void
    {
        $ad = new Ad();
        $cat = ['IAB1-1'];
        $ad->setCat($cat);
        $this->assertEquals($cat, $ad->getCat());
    }

    public function testGetCat(): void
    {
        $ad = new Ad();
        $ad->setCat(['IAB2-2']);
        $this->assertEquals(['IAB2-2'], $ad->getCat());
    }

    public function testSetCattax(): void
    {
        $ad = new Ad();
        $cattax = 1;
        $ad->setCattax($cattax);
        $this->assertEquals($cattax, $ad->getCattax());
    }

    public function testGetCattax(): void
    {
        $ad = new Ad();
        $ad->setCattax(2);
        $this->assertEquals(2, $ad->getCattax());
    }

    public function testSetLang(): void
    {
        $ad = new Ad();
        $lang = 'en';
        $ad->setLang($lang);
        $this->assertEquals($lang, $ad->getLang());
    }

    public function testGetLang(): void
    {
        $ad = new Ad();
        $ad->setLang('es');
        $this->assertEquals('es', $ad->getLang());
    }

    public function testSetAttr(): void
    {
        $ad = new Ad();
        $attr = [CreativeAttribute::ONE_POOR];
        $ad->setAttr($attr);
        $this->assertEquals($attr, $ad->getAttr());
    }

    public function testGetAttr(): void
    {
        $ad = new Ad();
        $ad->setAttr([CreativeAttribute::ELEVEN_SURVEYS]);
        $this->assertEquals([CreativeAttribute::ELEVEN_SURVEYS], $ad->getAttr());
    }

    public function testSetSecure(): void
    {
        $ad = new Ad();
        $secure = 1;
        $ad->setSecure($secure);
        $this->assertEquals($secure, $ad->getSecure());
    }

    public function testGetSecure(): void
    {
        $ad = new Ad();
        $ad->setSecure(0);
        $this->assertEquals(0, $ad->getSecure());
    }

    public function testSetInit(): void
    {
        $ad = new Ad();
        $init = 1;
        $ad->setInit($init);
        $this->assertEquals($init, $ad->getInit());
    }

    public function testGetInit(): void
    {
        $ad = new Ad();
        $ad->setInit(0);
        $this->assertEquals(0, $ad->getInit());
    }

    public function testSetLastmod(): void
    {
        $ad = new Ad();
        $lastmod = 123456789;
        $ad->setLastmod($lastmod);
        $this->assertEquals($lastmod, $ad->getLastmod());
    }

    public function testGetLastmod(): void
    {
        $ad = new Ad();
        $ad->setLastmod(987654321);
        $this->assertEquals(987654321, $ad->getLastmod());
    }

    public function testSetDisplay(): void
    {
        $ad = new Ad();
        $display = new Display();
        $ad->setDisplay($display);
        $this->assertSame($display, $ad->getDisplay());
    }

    public function testGetDisplay(): void
    {
        $ad = new Ad();
        $display = new Display();
        $ad->setDisplay($display);
        $this->assertSame($display, $ad->getDisplay());
    }

    public function testSetVideo(): void
    {
        $ad = new Ad();
        $video = new Video();
        $ad->setVideo($video);
        $this->assertSame($video, $ad->getVideo());
    }

    public function testGetVideo(): void
    {
        $ad = new Ad();
        $video = new Video();
        $ad->setVideo($video);
        $this->assertSame($video, $ad->getVideo());
    }

    public function testSetAudio(): void
    {
        $ad = new Ad();
        $audio = new Audio();
        $ad->setAudio($audio);
        $this->assertSame($audio, $ad->getAudio());
    }

    public function testGetAudio(): void
    {
        $ad = new Ad();
        $audio = new Audio();
        $ad->setAudio($audio);
        $this->assertSame($audio, $ad->getAudio());
    }

    public function testSetNative(): void
    {
        $ad = new Ad();
        $native = new NativeAd();
        $ad->setNative($native);
        $this->assertSame($native, $ad->getNative());
    }

    public function testGetNative(): void
    {
        $ad = new Ad();
        $native = new NativeAd();
        $ad->setNative($native);
        $this->assertSame($native, $ad->getNative());
    }

    public function testSetAudit(): void
    {
        $ad = new Ad();
        $audit = new Audit();
        $ad->setAudit($audit);
        $this->assertSame($audit, $ad->getAudit());
    }

    public function testGetAudit(): void
    {
        $ad = new Ad();
        $audit = new Audit();
        $ad->setAudit($audit);
        $this->assertSame($audit, $ad->getAudit());
    }
}
