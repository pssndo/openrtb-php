<?php

declare(strict_types=1);

namespace OpenRTB\Tests\v26;

use OpenRTB\v26\Context\App;
use OpenRTB\v26\Context\Content;
use OpenRTB\v26\Context\Device;
use OpenRTB\v26\Context\Geo;
use OpenRTB\v26\Context\Producer;
use OpenRTB\v26\Context\Publisher;
use OpenRTB\v26\Context\Regs;
use OpenRTB\v26\Context\Site;
use OpenRTB\v26\Context\Source;
use OpenRTB\v26\Context\SupplyChain;
use OpenRTB\v26\Context\SupplyChain\Node;
use OpenRTB\v26\Context\User;
use OpenRTB\v26\Ext;
use PHPUnit\Framework\TestCase;

/**
 * @covers \OpenRTB\v26\Ext
 * @covers \OpenRTB\v26\Context\App
 * @covers \OpenRTB\v26\Context\Content
 * @covers \OpenRTB\v26\Context\Device
 * @covers \OpenRTB\v26\Context\Geo
 * @covers \OpenRTB\v26\Context\Producer
 * @covers \OpenRTB\v26\Context\Publisher
 * @covers \OpenRTB\v26\Context\Regs
 * @covers \OpenRTB\v26\Context\Site
 * @covers \OpenRTB\v26\Context\Source
 * @covers \OpenRTB\v26\Context\SupplyChain
 * @covers \OpenRTB\v26\Context\SupplyChain\Node
 * @covers \OpenRTB\v26\Context\User
 */
class ContextObjectsTest extends TestCase
{
    public function testAppObject(): void
    {
        $publisher = new Publisher();
        $content = new Content();
        $ext = new Ext();
        $app = (new App())
            ->setId('app-1')
            ->setName('Test App')
            ->setBundle('com.example.app')
            ->setDomain('example.com')
            ->setStoreurl('https://store.example.com')
            ->setPublisher($publisher)
            ->setContent($content)
            ->setExt($ext);

        $this->assertEquals('app-1', $app->getId());
        $this->assertEquals('Test App', $app->getName());
        $this->assertEquals('com.example.app', $app->getBundle());
        $this->assertEquals('example.com', $app->getDomain());
        $this->assertEquals('https://store.example.com', $app->getStoreurl());
        $this->assertSame($publisher, $app->getPublisher());
        $this->assertSame($content, $app->getContent());
        $this->assertSame($ext, $app->getExt());
        $this->assertIsArray(Ext::getSchema());
        $this->assertIsArray(App::getSchema());
    }

    public function testContentObject(): void
    {
        $producer = new Producer();
        $ext = new Ext();
        $content = (new Content())
            ->setId('content-1')
            ->setEpisode(1)
            ->setTitle('Episode 1')
            ->setSeries('Test Series')
            ->setSeason('S01')
            ->setProducer($producer)
            ->setUrl('https://example.com/content')
            ->setContentrating('PG')
            ->setKeywords('test,content')
            ->setExt($ext);

        $this->assertEquals('content-1', $content->getId());
        $this->assertEquals(1, $content->getEpisode());
        $this->assertEquals('Episode 1', $content->getTitle());
        $this->assertEquals('Test Series', $content->getSeries());
        $this->assertEquals('S01', $content->getSeason());
        $this->assertSame($producer, $content->getProducer());
        $this->assertEquals('https://example.com/content', $content->getUrl());
        $this->assertEquals('PG', $content->getContentrating());
        $this->assertEquals('test,content', $content->getKeywords());
        $this->assertSame($ext, $content->getExt());
        $this->assertIsArray(Content::getSchema());
    }

    public function testDeviceObject(): void
    {
        $geo = new Geo();
        $ext = new Ext();
        $device = (new Device())
            ->setUa('ua-string')
            ->setGeo($geo)
            ->setIp('1.2.3.4')
            ->setDeviceType(1)
            ->setMake('TestMake')
            ->setModel('TestModel')
            ->setOs('TestOS')
            ->setOsv('1.0')
            ->setHwv('1.0')
            ->setW(1920)
            ->setH(1080)
            ->setJs(1)
            ->setLanguage('en')
            ->setConnectionType(2)
            ->setExt($ext);

        $this->assertEquals('ua-string', $device->getUa());
        $this->assertSame($geo, $device->getGeo());
        $this->assertEquals('1.2.3.4', $device->getIp());
        $this->assertEquals(1, $device->getDeviceType());
        $this->assertEquals('TestMake', $device->getMake());
        $this->assertEquals('TestModel', $device->getModel());
        $this->assertEquals('TestOS', $device->getOs());
        $this->assertEquals('1.0', $device->getOsv());
        $this->assertEquals('1.0', $device->getHwv());
        $this->assertEquals(1920, $device->getW());
        $this->assertEquals(1080, $device->getH());
        $this->assertEquals(1, $device->getJs());
        $this->assertEquals('en', $device->getLanguage());
        $this->assertEquals(2, $device->getConnectionType());
        $this->assertSame($ext, $device->getExt());
    }

    public function testGeoObject(): void
    {
        $ext = new Ext();
        $geo = (new Geo())
            ->setLat(40.7128)
            ->setLon(-74.0060)
            ->setType(1)
            ->setCountry('USA')
            ->setRegion('NY')
            ->setCity('New York')
            ->setZip('10001')
            ->setUtcoffset(300)
            ->setExt($ext);

        $this->assertEquals(40.7128, $geo->getLat());
        $this->assertEquals(-74.0060, $geo->getLon());
        $this->assertEquals(1, $geo->getType());
        $this->assertEquals('USA', $geo->getCountry());
        $this->assertEquals('NY', $geo->getRegion());
        $this->assertEquals('New York', $geo->getCity());
        $this->assertEquals('10001', $geo->getZip());
        $this->assertEquals(300, $geo->getUtcoffset());
        $this->assertSame($ext, $geo->getExt());
    }

    public function testProducerObject(): void
    {
        $ext = new Ext();
        $producer = (new Producer())->setId('prod-1')->setName('Producer A')->setCat(['IAB1'])->setDomain('producer.com')->setExt($ext);
        $this->assertEquals('prod-1', $producer->getId());
        $this->assertEquals('Producer A', $producer->getName());
        $this->assertEquals(['IAB1'], $producer->getCat());
        $this->assertEquals('producer.com', $producer->getDomain());
        $this->assertSame($ext, $producer->getExt());
    }

    public function testPublisherObject(): void
    {
        $ext = new Ext();
        $publisher = (new Publisher())->setId('pub-1')->setName('Publisher A')->setCat(['IAB1'])->setDomain('publisher.com')->setExt($ext);
        $this->assertEquals('pub-1', $publisher->getId());
        $this->assertEquals('Publisher A', $publisher->getName());
        $this->assertEquals(['IAB1'], $publisher->getCat());
        $this->assertEquals('publisher.com', $publisher->getDomain());
        $this->assertSame($ext, $publisher->getExt());
    }

    public function testRegsObject(): void
    {
        $ext = new Ext();
        $regs = (new Regs())->setCoppa(1)->setGdpr(1)->setUsPrivacy('1YYN')->setExt($ext);
        $this->assertEquals(1, $regs->getCoppa());
        $this->assertEquals(1, $regs->getGdpr());
        $this->assertEquals('1YYN', $regs->getUsPrivacy());
        $this->assertSame($ext, $regs->getExt());
    }

    public function testSiteObject(): void
    {
        $publisher = new Publisher();
        $content = new Content();
        $ext = new Ext();
        $site = (new Site())->setId('site-1')->setName('Test Site')->setDomain('example.com')->setPage('https://example.com/page')->setRef('https://referrer.com')->setPublisher($publisher)->setContent($content)->setExt($ext);
        $this->assertEquals('site-1', $site->getId());
        $this->assertEquals('Test Site', $site->getName());
        $this->assertEquals('example.com', $site->getDomain());
        $this->assertEquals('https://example.com/page', $site->getPage());
        $this->assertEquals('https://referrer.com', $site->getRef());
        $this->assertSame($publisher, $site->getPublisher());
        $this->assertSame($content, $site->getContent());
        $this->assertSame($ext, $site->getExt());
    }

    public function testSourceObject(): void
    {
        $schain = new SupplyChain();
        $ext = new Ext();
        $source = (new Source())->setFd(1)->setTid('tid-1')->setPchain('pchain-val')->setSchain($schain)->setExt($ext);
        $this->assertEquals(1, $source->getFd());
        $this->assertEquals('tid-1', $source->getTid());
        $this->assertEquals('pchain-val', $source->getPchain());
        $this->assertSame($schain, $source->getSchain());
        $this->assertSame($ext, $source->getExt());
    }
}
