<?php

declare(strict_types=1);

namespace OpenRTB\Tests\v25;

use OpenRTB\Common\Resources\Ext;
use OpenRTB\v25\Context\App;
use OpenRTB\v25\Context\Content;
use OpenRTB\v25\Context\Device;
use OpenRTB\v25\Context\Geo;
use OpenRTB\v25\Context\Producer;
use OpenRTB\v25\Context\Publisher;
use OpenRTB\v25\Context\Regs;
use OpenRTB\v25\Context\Site;
use OpenRTB\v25\Context\Source;
use OpenRTB\v25\Context\SupplyChain;
use OpenRTB\v25\Context\SupplyChain\Node;
use OpenRTB\v25\Context\User;
use PHPUnit\Framework\TestCase;

/**
 * @covers \OpenRTB\v25\Context\App
 * @covers \OpenRTB\v25\Context\Content
 * @covers \OpenRTB\v25\Context\Device
 * @covers \OpenRTB\v25\Context\Geo
 * @covers \OpenRTB\v25\Context\Producer
 * @covers \OpenRTB\v25\Context\Publisher
 * @covers \OpenRTB\v25\Context\Regs
 * @covers \OpenRTB\v25\Context\Site
 * @covers \OpenRTB\v25\Context\Source
 * @covers \OpenRTB\v25\Context\SupplyChain
 * @covers \OpenRTB\v25\Context\SupplyChain\Node
 * @covers \OpenRTB\v25\Context\User
 */
class ContextObjectsTest extends TestCase
{
    public function testGeoGetSchema(): void
    {
        $schema = Geo::getSchema();
        /** @phpstan-ignore-next-line method.alreadyNarrowedType */
        $this->assertIsArray($schema);
    }

    public function testGeoSetType(): void
    {
        $geo = new Geo();
        $result = $geo->setType(1);
        $this->assertSame($geo, $result);
    }

    public function testGeoGetType(): void
    {
        $geo = (new Geo())->setType(2);
        $this->assertEquals(2, $geo->getType());
    }

    public function testGeoSetExt(): void
    {
        $ext = new Ext();
        $geo = new Geo();
        $result = $geo->setExt($ext);
        $this->assertSame($geo, $result);
    }

    public function testGeoGetExt(): void
    {
        $ext = new Ext();
        $geo = (new Geo())->setExt($ext);
        $this->assertSame($ext, $geo->getExt());
    }

    public function testPublisherGetSchema(): void
    {
        $schema = Publisher::getSchema();
        /** @phpstan-ignore-next-line method.alreadyNarrowedType */
        $this->assertIsArray($schema);
    }

    public function testPublisherSetId(): void
    {
        $publisher = new Publisher();
        $result = $publisher->setId('pub-1');
        $this->assertSame($publisher, $result);
    }

    public function testPublisherGetId(): void
    {
        $publisher = (new Publisher())->setId('pub-123');
        $this->assertEquals('pub-123', $publisher->getId());
    }

    public function testPublisherSetName(): void
    {
        $publisher = (new Publisher())->setName('Test Publisher');
        $this->assertEquals('Test Publisher', $publisher->getName());
    }

    public function testPublisherSetDomain(): void
    {
        $publisher = (new Publisher())->setDomain('example.com');
        $this->assertEquals('example.com', $publisher->getDomain());
    }

    public function testPublisherSetExt(): void
    {
        $ext = new Ext();
        $publisher = (new Publisher())->setExt($ext);
        $this->assertSame($ext, $publisher->getExt());
    }

    public function testProducerGetSchema(): void
    {
        $schema = Producer::getSchema();
        /** @phpstan-ignore-next-line method.alreadyNarrowedType */
        $this->assertIsArray($schema);
    }

    public function testProducerSetId(): void
    {
        $producer = (new Producer())->setId('prod-1');
        $this->assertEquals('prod-1', $producer->getId());
    }

    public function testProducerSetName(): void
    {
        $producer = (new Producer())->setName('Test Producer');
        $this->assertEquals('Test Producer', $producer->getName());
    }

    public function testProducerSetDomain(): void
    {
        $producer = (new Producer())->setDomain('producer.com');
        $this->assertEquals('producer.com', $producer->getDomain());
    }

    public function testProducerSetExt(): void
    {
        $ext = new Ext();
        $producer = (new Producer())->setExt($ext);
        $this->assertSame($ext, $producer->getExt());
    }

    public function testProducerGetExt(): void
    {
        $producer = new Producer();
        $this->assertNull($producer->getExt());
    }

    public function testContentGetSchema(): void
    {
        $schema = Content::getSchema();
        /** @phpstan-ignore-next-line method.alreadyNarrowedType */
        $this->assertIsArray($schema);
    }

    public function testContentSetId(): void
    {
        $content = (new Content())->setId('content-1');
        $this->assertEquals('content-1', $content->getId());
    }

    public function testContentSetEpisode(): void
    {
        $content = (new Content())->setEpisode(5);
        $this->assertEquals(5, $content->getEpisode());
    }

    public function testContentSetTitle(): void
    {
        $content = (new Content())->setTitle('Episode Title');
        $this->assertEquals('Episode Title', $content->getTitle());
    }

    public function testContentSetSeries(): void
    {
        $content = (new Content())->setSeries('Series Name');
        $this->assertEquals('Series Name', $content->getSeries());
    }

    public function testContentSetSeason(): void
    {
        $content = (new Content())->setSeason('Season 1');
        $this->assertEquals('Season 1', $content->getSeason());
    }

    public function testContentSetProducer(): void
    {
        $producer = new Producer();
        $content = (new Content())->setProducer($producer);
        $this->assertSame($producer, $content->getProducer());
    }

    public function testContentSetUrl(): void
    {
        $content = (new Content())->setUrl('http://example.com');
        $this->assertEquals('http://example.com', $content->getUrl());
    }

    public function testContentSetKeywords(): void
    {
        $content = (new Content())->setKeywords('tech,news');
        $this->assertEquals('tech,news', $content->getKeywords());
    }

    public function testContentSetExt(): void
    {
        $ext = new Ext();
        $content = (new Content())->setExt($ext);
        $this->assertSame($ext, $content->getExt());
    }

    public function testContentGetExt(): void
    {
        $content = new Content();
        $this->assertNull($content->getExt());
    }

    public function testSiteGetSchema(): void
    {
        $schema = Site::getSchema();
        /** @phpstan-ignore-next-line method.alreadyNarrowedType */
        $this->assertIsArray($schema);
    }

    public function testSiteSetId(): void
    {
        $site = (new Site())->setId('site-1');
        $this->assertEquals('site-1', $site->getId());
    }

    public function testSiteSetName(): void
    {
        $site = (new Site())->setName('Test Site');
        $this->assertEquals('Test Site', $site->getName());
    }

    public function testSiteSetDomain(): void
    {
        $site = (new Site())->setDomain('example.com');
        $this->assertEquals('example.com', $site->getDomain());
    }

    public function testSiteSetPage(): void
    {
        $site = (new Site())->setPage('http://example.com/page');
        $this->assertEquals('http://example.com/page', $site->getPage());
    }

    public function testSiteSetRef(): void
    {
        $site = (new Site())->setRef('http://referrer.com');
        $this->assertEquals('http://referrer.com', $site->getRef());
    }

    public function testSiteSetPublisher(): void
    {
        $publisher = new Publisher();
        $site = (new Site())->setPublisher($publisher);
        $this->assertSame($publisher, $site->getPublisher());
    }

    public function testSiteSetContent(): void
    {
        $content = new Content();
        $site = (new Site())->setContent($content);
        $this->assertSame($content, $site->getContent());
    }

    public function testSiteSetCat(): void
    {
        $site = (new Site())->setCat(['IAB1', 'IAB2']);
        $cat = $site->getCat();
        $this->assertEquals(['IAB1', 'IAB2'], $cat);
    }

    public function testSiteGetCat(): void
    {
        $site = new Site();
        $this->assertNull($site->getCat());
    }

    public function testSiteSetExt(): void
    {
        $ext = new Ext();
        $site = (new Site())->setExt($ext);
        $this->assertSame($ext, $site->getExt());
    }

    public function testSiteGetExt(): void
    {
        $site = new Site();
        $this->assertNull($site->getExt());
    }

    public function testAppGetSchema(): void
    {
        $schema = App::getSchema();
        /** @phpstan-ignore-next-line method.alreadyNarrowedType */
        $this->assertIsArray($schema);
    }

    public function testAppSetId(): void
    {
        $app = (new App())->setId('app-1');
        $this->assertEquals('app-1', $app->getId());
    }

    public function testAppSetName(): void
    {
        $app = (new App())->setName('Test App');
        $this->assertEquals('Test App', $app->getName());
    }

    public function testAppSetBundle(): void
    {
        $app = (new App())->setBundle('com.test.app');
        $this->assertEquals('com.test.app', $app->getBundle());
    }

    public function testAppSetDomain(): void
    {
        $app = (new App())->setDomain('app.com');
        $this->assertEquals('app.com', $app->getDomain());
    }

    public function testAppSetStoreurl(): void
    {
        $app = (new App())->setStoreurl('http://store.com/app');
        $this->assertEquals('http://store.com/app', $app->getStoreurl());
    }

    public function testAppSetPublisher(): void
    {
        $publisher = new Publisher();
        $app = (new App())->setPublisher($publisher);
        $this->assertSame($publisher, $app->getPublisher());
    }

    public function testAppSetContent(): void
    {
        $content = new Content();
        $app = (new App())->setContent($content);
        $this->assertSame($content, $app->getContent());
    }

    public function testAppSetExt(): void
    {
        $ext = new Ext();
        $app = (new App())->setExt($ext);
        $this->assertSame($ext, $app->getExt());
    }

    public function testDeviceGetSchema(): void
    {
        $schema = Device::getSchema();
        /** @phpstan-ignore-next-line method.alreadyNarrowedType */
        $this->assertIsArray($schema);
    }

    public function testDeviceSetUa(): void
    {
        $device = (new Device())->setUa('Mozilla/5.0');
        $this->assertEquals('Mozilla/5.0', $device->getUa());
    }

    public function testDeviceSetGeo(): void
    {
        $geo = new Geo();
        $device = (new Device())->setGeo($geo);
        $this->assertSame($geo, $device->getGeo());
    }

    public function testDeviceSetIp(): void
    {
        $device = (new Device())->setIp('192.168.1.1');
        $this->assertEquals('192.168.1.1', $device->getIp());
    }

    public function testDeviceSetJs(): void
    {
        $device = (new Device())->setJs(1);
        $this->assertEquals(1, $device->getJs());
    }

    public function testDeviceSetDevicetype(): void
    {
        $device = (new Device())->setDevicetype(1);
        $this->assertEquals(1, $device->getDevicetype());
    }

    public function testDeviceSetMake(): void
    {
        $device = (new Device())->setMake('Apple');
        $this->assertEquals('Apple', $device->getMake());
    }

    public function testDeviceSetModel(): void
    {
        $device = (new Device())->setModel('iPhone');
        $this->assertEquals('iPhone', $device->getModel());
    }

    public function testDeviceSetOs(): void
    {
        $device = (new Device())->setOs('iOS');
        $this->assertEquals('iOS', $device->getOs());
    }

    public function testDeviceSetOsv(): void
    {
        $device = (new Device())->setOsv('15.0');
        $this->assertEquals('15.0', $device->getOsv());
    }

    public function testDeviceSetHwv(): void
    {
        $device = (new Device())->setHwv('14,5');
        $this->assertEquals('14,5', $device->getHwv());
    }

    public function testDeviceSetW(): void
    {
        $device = (new Device())->setW(1170);
        $this->assertEquals(1170, $device->getW());
    }

    public function testDeviceSetH(): void
    {
        $device = (new Device())->setH(2532);
        $this->assertEquals(2532, $device->getH());
    }

    public function testDeviceSetLanguage(): void
    {
        $device = (new Device())->setLanguage('en');
        $this->assertEquals('en', $device->getLanguage());
    }

    public function testDeviceSetConnectiontype(): void
    {
        $device = (new Device())->setConnectiontype(2);
        $this->assertEquals(2, $device->getConnectiontype());
    }

    public function testDeviceSetExt(): void
    {
        $ext = new Ext();
        $device = (new Device())->setExt($ext);
        $this->assertSame($ext, $device->getExt());
    }

    public function testUserGetSchema(): void
    {
        $schema = User::getSchema();
        /** @phpstan-ignore-next-line method.alreadyNarrowedType */
        $this->assertIsArray($schema);
    }

    public function testUserSetId(): void
    {
        $user = (new User())->setId('user-1');
        $this->assertEquals('user-1', $user->getId());
    }

    public function testUserSetBuyeruid(): void
    {
        $user = (new User())->setBuyeruid('buyer-123');
        $this->assertEquals('buyer-123', $user->getBuyeruid());
    }

    public function testUserSetYob(): void
    {
        $user = (new User())->setYob(1990);
        $this->assertEquals(1990, $user->getYob());
    }

    public function testUserSetGender(): void
    {
        $user = (new User())->setGender('M');
        $this->assertEquals('M', $user->getGender());
    }

    public function testUserSetKeywords(): void
    {
        $user = (new User())->setKeywords('tech,sports');
        $this->assertEquals('tech,sports', $user->getKeywords());
    }

    public function testUserSetGeo(): void
    {
        $geo = new Geo();
        $user = (new User())->setGeo($geo);
        $this->assertSame($geo, $user->getGeo());
    }

    public function testUserSetExt(): void
    {
        $ext = new Ext();
        $user = (new User())->setExt($ext);
        $this->assertSame($ext, $user->getExt());
    }

    public function testUserGetExt(): void
    {
        $user = new User();
        $this->assertNull($user->getExt());
    }

    public function testRegsGetSchema(): void
    {
        $schema = Regs::getSchema();
        /** @phpstan-ignore-next-line method.alreadyNarrowedType */
        $this->assertIsArray($schema);
    }

    public function testRegsSetCoppa(): void
    {
        $regs = (new Regs())->setCoppa(1);
        $this->assertEquals(1, $regs->getCoppa());
    }

    public function testRegsSetGdpr(): void
    {
        $regs = (new Regs())->setGdpr(1);
        $this->assertEquals(1, $regs->getGdpr());
    }

    public function testRegsSetUsPrivacy(): void
    {
        $regs = (new Regs())->setUsPrivacy('1YNN');
        $this->assertEquals('1YNN', $regs->getUsPrivacy());
    }

    public function testRegsGetUsPrivacy(): void
    {
        $regs = new Regs();
        $this->assertNull($regs->getUsPrivacy());
    }

    public function testRegsSetExt(): void
    {
        $ext = new Ext();
        $regs = (new Regs())->setExt($ext);
        $this->assertSame($ext, $regs->getExt());
    }

    public function testSourceGetSchema(): void
    {
        $schema = Source::getSchema();
        /** @phpstan-ignore-next-line method.alreadyNarrowedType */
        $this->assertIsArray($schema);
    }

    public function testSourceSetFd(): void
    {
        $source = (new Source())->setFd(1);
        $this->assertEquals(1, $source->getFd());
    }

    public function testSourceSetTid(): void
    {
        $source = (new Source())->setTid('trans-123');
        $this->assertEquals('trans-123', $source->getTid());
    }

    public function testSourceSetPchain(): void
    {
        $source = (new Source())->setPchain('pchain-data');
        $this->assertEquals('pchain-data', $source->getPchain());
    }

    public function testSourceSetExt(): void
    {
        $ext = new Ext();
        $source = (new Source())->setExt($ext);
        $this->assertSame($ext, $source->getExt());
    }

    public function testSourceGetExt(): void
    {
        $source = new Source();
        $this->assertNull($source->getExt());
    }

    public function testSourceGetFd(): void
    {
        $source = new Source();
        $this->assertNull($source->getFd());
    }

    public function testSourceGetPchain(): void
    {
        $source = new Source();
        $this->assertNull($source->getPchain());
    }

    public function testSourceSetSchain(): void
    {
        $schain = new SupplyChain();
        $source = (new Source())->setSchain($schain);
        $this->assertSame($schain, $source->getSchain());
    }

    public function testSourceGetSchain(): void
    {
        $source = new Source();
        $this->assertNull($source->getSchain());
    }

    public function testSupplyChainSetComplete(): void
    {
        $schain = new SupplyChain();
        $schain->setComplete(1);
        $this->assertEquals(1, $schain->getComplete());
    }

    public function testSupplyChainGetComplete(): void
    {
        $schain = new SupplyChain();
        $this->assertNull($schain->getComplete());
    }

    public function testSupplyChainSetVer(): void
    {
        $schain = new SupplyChain();
        $schain->setVer('1.0');
        $this->assertEquals('1.0', $schain->getVer());
    }

    public function testSupplyChainGetVer(): void
    {
        $schain = new SupplyChain();
        $this->assertNull($schain->getVer());
    }

    public function testSupplyChainSetNodes(): void
    {
        $schain = new SupplyChain();
        $node = new Node();
        $node->setAsi('example.com');
        $node->setSid('seller-1');
        $node->setHp(1);
        $schain->setNodes([$node]);
        $result = $schain->getNodes();
        $this->assertNotNull($result);
    }

    public function testSupplyChainGetNodes(): void
    {
        $schain = new SupplyChain();
        $this->assertNull($schain->getNodes());
    }

    public function testSupplyChainSetExt(): void
    {
        $ext = new Ext();
        $schain = new SupplyChain();
        $schain->setExt($ext);
        $this->assertSame($ext, $schain->getExt());
    }

    public function testSupplyChainGetExt(): void
    {
        $schain = new SupplyChain();
        $this->assertNull($schain->getExt());
    }

    public function testSupplyChainGetSchema(): void
    {
        $schema = SupplyChain::getSchema();
        /** @phpstan-ignore-next-line method.alreadyNarrowedType */
        $this->assertIsArray($schema);
    }

    // SupplyChain\Node tests
    public function testNodeGetSchema(): void
    {
        $schema = Node::getSchema();
        /** @phpstan-ignore-next-line method.alreadyNarrowedType */
        $this->assertIsArray($schema);
    }

    public function testNodeSetAsi(): void
    {
        $node = new Node();
        $node->setAsi('example.com');
        $this->assertEquals('example.com', $node->getAsi());
    }

    public function testNodeGetAsi(): void
    {
        $node = new Node();
        $this->assertNull($node->getAsi());
    }

    public function testNodeSetSid(): void
    {
        $node = new Node();
        $node->setSid('seller-123');
        $this->assertEquals('seller-123', $node->getSid());
    }

    public function testNodeGetSid(): void
    {
        $node = new Node();
        $this->assertNull($node->getSid());
    }

    public function testNodeSetHp(): void
    {
        $node = new Node();
        $node->setHp(1);
        $this->assertEquals(1, $node->getHp());
    }

    public function testNodeGetHp(): void
    {
        $node = new Node();
        $this->assertNull($node->getHp());
    }

    public function testNodeSetRid(): void
    {
        $node = new Node();
        $node->setRid('request-123');
        $this->assertEquals('request-123', $node->getRid());
    }

    public function testNodeGetRid(): void
    {
        $node = new Node();
        $this->assertNull($node->getRid());
    }

    public function testNodeSetName(): void
    {
        $node = new Node();
        $node->setName('Publisher Name');
        $this->assertEquals('Publisher Name', $node->getName());
    }

    public function testNodeGetName(): void
    {
        $node = new Node();
        $this->assertNull($node->getName());
    }

    public function testNodeSetDomain(): void
    {
        $node = new Node();
        $node->setDomain('publisher.com');
        $this->assertEquals('publisher.com', $node->getDomain());
    }

    public function testNodeGetDomain(): void
    {
        $node = new Node();
        $this->assertNull($node->getDomain());
    }

    public function testNodeSetExt(): void
    {
        $ext = new Ext();
        $node = new Node();
        $node->setExt($ext);
        $this->assertSame($ext, $node->getExt());
    }

    public function testNodeGetExt(): void
    {
        $node = new Node();
        $this->assertNull($node->getExt());
    }
}
