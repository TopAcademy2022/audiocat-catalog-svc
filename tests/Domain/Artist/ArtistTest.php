<?php

declare(strict_types=1);

namespace Tests\Domain\Artist;

use App\Domain\Artist\Artist;
use Tests\TestCase;

final class ArtistTest extends TestCase
{
    public function artistProvider(): array
    {
        return [
            // name, description, expectedName, expectedDescription
            ['Radiohead', null, 'radiohead', null],
            ['Daft Punk', '  French duo  ', 'daft punk', 'French duo'],
            ['MUSE', '', 'muse', ''],
            ['The Prodigy', '   ', 'the prodigy', ''], // trim keeps empty string (because "   " -> "")
        ];
    }

    /**
     * @dataProvider artistProvider
     */
    public function testGetters(
        string $name,
        ?string $description,
        string $expectedName,
        ?string $expectedDescription
    ): void {
        $artist = new Artist($name, $description);

        // id is UUID string generated in constructor, cannot predict exact value
        $this->assertNotEmpty($artist->getId());
        $this->assertMatchesRegularExpression(
            '/^[0-9a-f]{8}-[0-9a-f]{4}-[1-5][0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/i',
            $artist->getId()
        );

        $this->assertSame($expectedName, $artist->getName());
        $this->assertSame($expectedDescription, $artist->getDescription());
    }

    /**
     * @dataProvider artistProvider
     */
    public function testJsonSerialize(
        string $name,
        ?string $description,
        string $expectedName,
        ?string $expectedDescription
    ): void {

        $artist = new Artist($name, $description);

        $payload = json_decode((string) json_encode($artist), true);

        $this->assertIsArray($payload);

        $this->assertArrayHasKey('id', $payload);
        $this->assertArrayHasKey('name', $payload);
        $this->assertArrayHasKey('description', $payload);

        $this->assertMatchesRegularExpression(
            '/^[0-9a-f]{8}-[0-9a-f]{4}-[1-5][0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/i',
            (string) $payload['id']
        );

        $this->assertSame($expectedName, (string) $payload['name']);
        $this->assertSame($expectedDescription, $payload['description']);
    }
}
