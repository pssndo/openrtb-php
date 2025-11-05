<?php

declare(strict_types=1);

namespace OpenRTB\Tests\Common\Resources;

use OpenRTB\Common\Resources\Geo;
use OpenRTB\Common\Resources\User;
use PHPUnit\Framework\TestCase;

/**
 * @covers \OpenRTB\Common\Resources\User
 */
class UserTest extends TestCase
{
    public function testGetSchema(): void
    {
        $schema = User::getSchema();
        // @phpstan-ignore-next-line - Testing return type
        $this->assertIsArray($schema);
        $this->assertArrayHasKey('id', $schema);
        $this->assertEquals('string', $schema['id']);
        $this->assertArrayHasKey('buyeruid', $schema);
        $this->assertEquals('string', $schema['buyeruid']);
        $this->assertArrayHasKey('yob', $schema);
        $this->assertEquals('int', $schema['yob']);
        $this->assertArrayHasKey('gender', $schema);
        $this->assertEquals('string', $schema['gender']);
        $this->assertArrayHasKey('keywords', $schema);
        $this->assertEquals('string', $schema['keywords']);
        $this->assertArrayHasKey('geo', $schema);
        $this->assertEquals(Geo::class, $schema['geo']);
    }

    public function testSetAndGetId(): void
    {
        $user = new User();
        $user->setId('user-123');
        $this->assertEquals('user-123', $user->getId());
    }

    public function testSetAndGetBuyeruid(): void
    {
        $user = new User();
        $user->setBuyeruid('buyer-456');
        $this->assertEquals('buyer-456', $user->getBuyeruid());
    }

    public function testSetAndGetYob(): void
    {
        $user = new User();
        $user->setYob(1990);
        $this->assertEquals(1990, $user->getYob());
    }

    public function testSetAndGetGender(): void
    {
        $user = new User();
        $user->setGender('M');
        $this->assertEquals('M', $user->getGender());
    }

    public function testSetAndGetKeywords(): void
    {
        $user = new User();
        $user->setKeywords('test,keywords');
        $this->assertEquals('test,keywords', $user->getKeywords());
    }

    public function testSetAndGetGeo(): void
    {
        $user = new User();
        $geo = new Geo();
        $user->setGeo($geo);
        $this->assertSame($geo, $user->getGeo());
    }

    public function testGetGeoReturnsNullByDefault(): void
    {
        $user = new User();
        $this->assertNull($user->getGeo());
    }
}
