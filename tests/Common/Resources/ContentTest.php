<?php

declare(strict_types=1);

namespace OpenRTB\Tests\Common\Resources;

use OpenRTB\Common\Resources\Content;
use OpenRTB\Common\Resources\Producer;
use PHPUnit\Framework\TestCase;

/**
 * @covers \OpenRTB\Common\Resources\Content
 */
class ContentTest extends TestCase
{
    public function testGetSchema(): void
    {
        $schema = Content::getSchema();
        // @phpstan-ignore-next-line - Testing return type
        $this->assertIsArray($schema);
        $this->assertArrayHasKey('id', $schema);
        $this->assertEquals('string', $schema['id']);
        $this->assertArrayHasKey('episode', $schema);
        $this->assertEquals('int', $schema['episode']);
        $this->assertArrayHasKey('title', $schema);
        $this->assertEquals('string', $schema['title']);
        $this->assertArrayHasKey('series', $schema);
        $this->assertEquals('string', $schema['series']);
        $this->assertArrayHasKey('season', $schema);
        $this->assertEquals('string', $schema['season']);
        $this->assertArrayHasKey('artist', $schema);
        $this->assertEquals('string', $schema['artist']);
        $this->assertArrayHasKey('genre', $schema);
        $this->assertEquals('string', $schema['genre']);
        $this->assertArrayHasKey('album', $schema);
        $this->assertEquals('string', $schema['album']);
        $this->assertArrayHasKey('isrc', $schema);
        $this->assertEquals('string', $schema['isrc']);
        $this->assertArrayHasKey('producer', $schema);
        $this->assertEquals(Producer::class, $schema['producer']);
        $this->assertArrayHasKey('url', $schema);
        $this->assertEquals('string', $schema['url']);
        $this->assertArrayHasKey('cat', $schema);
        $this->assertEquals('array', $schema['cat']);
        $this->assertArrayHasKey('prodq', $schema);
        $this->assertEquals('int', $schema['prodq']);
        $this->assertArrayHasKey('videoquality', $schema);
        $this->assertEquals('int', $schema['videoquality']);
        $this->assertArrayHasKey('context', $schema);
        $this->assertEquals('int', $schema['context']);
        $this->assertArrayHasKey('contentrating', $schema);
        $this->assertEquals('string', $schema['contentrating']);
        $this->assertArrayHasKey('userrating', $schema);
        $this->assertEquals('string', $schema['userrating']);
        $this->assertArrayHasKey('qagmediarating', $schema);
        $this->assertEquals('int', $schema['qagmediarating']);
        $this->assertArrayHasKey('keywords', $schema);
        $this->assertEquals('string', $schema['keywords']);
        $this->assertArrayHasKey('livestream', $schema);
        $this->assertEquals('int', $schema['livestream']);
        $this->assertArrayHasKey('sourcerelationship', $schema);
        $this->assertEquals('int', $schema['sourcerelationship']);
        $this->assertArrayHasKey('len', $schema);
        $this->assertEquals('int', $schema['len']);
        $this->assertArrayHasKey('language', $schema);
        $this->assertEquals('string', $schema['language']);
        $this->assertArrayHasKey('embeddable', $schema);
        $this->assertEquals('int', $schema['embeddable']);
        $this->assertArrayHasKey('data', $schema);
        $this->assertEquals('array', $schema['data']);
    }

    public function testSetAndGetId(): void
    {
        $content = new Content();
        $content->setId('content-123');
        $this->assertEquals('content-123', $content->getId());
    }

    public function testSetAndGetEpisode(): void
    {
        $content = new Content();
        $content->setEpisode(5);
        $this->assertEquals(5, $content->getEpisode());
    }

    public function testSetAndGetTitle(): void
    {
        $content = new Content();
        $content->setTitle('Test Title');
        $this->assertEquals('Test Title', $content->getTitle());
    }

    public function testSetAndGetSeries(): void
    {
        $content = new Content();
        $content->setSeries('Test Series');
        $this->assertEquals('Test Series', $content->getSeries());
    }

    public function testSetAndGetSeason(): void
    {
        $content = new Content();
        $content->setSeason('Season 1');
        $this->assertEquals('Season 1', $content->getSeason());
    }

    public function testSetAndGetProducer(): void
    {
        $content = new Content();
        $producer = new Producer();
        $content->setProducer($producer);
        $this->assertSame($producer, $content->getProducer());
    }

    public function testSetAndGetUrl(): void
    {
        $content = new Content();
        $content->setUrl('https://example.com/video');
        $this->assertEquals('https://example.com/video', $content->getUrl());
    }

    public function testSetAndGetContentrating(): void
    {
        $content = new Content();
        $content->setContentrating('PG-13');
        $this->assertEquals('PG-13', $content->getContentrating());
    }

    public function testSetAndGetKeywords(): void
    {
        $content = new Content();
        $content->setKeywords('test,keywords,example');
        $this->assertEquals('test,keywords,example', $content->getKeywords());
    }

    public function testGetProducerReturnsNullByDefault(): void
    {
        $content = new Content();
        $this->assertNull($content->getProducer());
    }

    public function testSetAndGetArtist(): void
    {
        $content = new Content();
        $content->setArtist('Test Artist');
        $this->assertEquals('Test Artist', $content->getArtist());
    }

    public function testGetArtistReturnsNullByDefault(): void
    {
        $content = new Content();
        $this->assertNull($content->getArtist());
    }

    public function testSetAndGetGenre(): void
    {
        $content = new Content();
        $content->setGenre('Comedy');
        $this->assertEquals('Comedy', $content->getGenre());
    }

    public function testGetGenreReturnsNullByDefault(): void
    {
        $content = new Content();
        $this->assertNull($content->getGenre());
    }

    public function testSetAndGetAlbum(): void
    {
        $content = new Content();
        $content->setAlbum('Test Album');
        $this->assertEquals('Test Album', $content->getAlbum());
    }

    public function testGetAlbumReturnsNullByDefault(): void
    {
        $content = new Content();
        $this->assertNull($content->getAlbum());
    }

    public function testSetAndGetIsrc(): void
    {
        $content = new Content();
        $content->setIsrc('USRC17607839');
        $this->assertEquals('USRC17607839', $content->getIsrc());
    }

    public function testGetIsrcReturnsNullByDefault(): void
    {
        $content = new Content();
        $this->assertNull($content->getIsrc());
    }

    public function testSetAndGetCatWithArray(): void
    {
        $content = new Content();
        $categories = ['IAB1', 'IAB2-3'];
        $content->setCat($categories);
        $this->assertEquals($categories, $content->getCat());
    }

    public function testGetCatReturnsNullByDefault(): void
    {
        $content = new Content();
        $this->assertNull($content->getCat());
    }

    public function testSetAndGetProdq(): void
    {
        $content = new Content();
        $content->setProdq(2);
        $this->assertEquals(2, $content->getProdq());
    }

    public function testGetProdqReturnsNullByDefault(): void
    {
        $content = new Content();
        $this->assertNull($content->getProdq());
    }

    public function testSetAndGetVideoquality(): void
    {
        $content = new Content();
        $content->setVideoquality(3);
        $this->assertEquals(3, $content->getVideoquality());
    }

    public function testGetVideoqualityReturnsNullByDefault(): void
    {
        $content = new Content();
        $this->assertNull($content->getVideoquality());
    }

    public function testSetAndGetContext(): void
    {
        $content = new Content();
        $content->setContext(1);
        $this->assertEquals(1, $content->getContext());
    }

    public function testGetContextReturnsNullByDefault(): void
    {
        $content = new Content();
        $this->assertNull($content->getContext());
    }

    public function testSetAndGetUserrating(): void
    {
        $content = new Content();
        $content->setUserrating('4.5');
        $this->assertEquals('4.5', $content->getUserrating());
    }

    public function testGetUserratingReturnsNullByDefault(): void
    {
        $content = new Content();
        $this->assertNull($content->getUserrating());
    }

    public function testSetAndGetQagmediarating(): void
    {
        $content = new Content();
        $content->setQagmediarating(2);
        $this->assertEquals(2, $content->getQagmediarating());
    }

    public function testGetQagmediaratingReturnsNullByDefault(): void
    {
        $content = new Content();
        $this->assertNull($content->getQagmediarating());
    }

    public function testSetAndGetLivestream(): void
    {
        $content = new Content();
        $content->setLivestream(1);
        $this->assertEquals(1, $content->getLivestream());
    }

    public function testGetLivestreamReturnsNullByDefault(): void
    {
        $content = new Content();
        $this->assertNull($content->getLivestream());
    }

    public function testSetAndGetSourcerelationship(): void
    {
        $content = new Content();
        $content->setSourcerelationship(1);
        $this->assertEquals(1, $content->getSourcerelationship());
    }

    public function testGetSourcerelationshipReturnsNullByDefault(): void
    {
        $content = new Content();
        $this->assertNull($content->getSourcerelationship());
    }

    public function testSetAndGetLen(): void
    {
        $content = new Content();
        $content->setLen(300);
        $this->assertEquals(300, $content->getLen());
    }

    public function testGetLenReturnsNullByDefault(): void
    {
        $content = new Content();
        $this->assertNull($content->getLen());
    }

    public function testSetAndGetLanguage(): void
    {
        $content = new Content();
        $content->setLanguage('en');
        $this->assertEquals('en', $content->getLanguage());
    }

    public function testGetLanguageReturnsNullByDefault(): void
    {
        $content = new Content();
        $this->assertNull($content->getLanguage());
    }

    public function testSetAndGetEmbeddable(): void
    {
        $content = new Content();
        $content->setEmbeddable(1);
        $this->assertEquals(1, $content->getEmbeddable());
    }

    public function testGetEmbeddableReturnsNullByDefault(): void
    {
        $content = new Content();
        $this->assertNull($content->getEmbeddable());
    }

    public function testSetAndGetData(): void
    {
        $content = new Content();
        $data = [
            ['id' => '1', 'name' => 'data1'],
            ['id' => '2', 'name' => 'data2'],
        ];
        $content->setData($data);
        $this->assertEquals($data, $content->getData());
    }

    public function testGetDataReturnsNullByDefault(): void
    {
        $content = new Content();
        $this->assertNull($content->getData());
    }
}
