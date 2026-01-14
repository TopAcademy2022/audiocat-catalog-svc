<?php

declare(strict_types=1);

namespace Tests\Domain\Track;

use App\Domain\Track\Track;
use Tests\TestCase;

final class TrackTest extends TestCase
{
    public function trackProvider(): array
    {
        return [
            // title, media_id, expectedTitle, expectedMediaId
            ['Creep', null, 'creep', null],
            ['Paranoid Android', '  abc123  ', 'paranoid android', 'abc123'],
            ['NO SURPRISES', '', 'no surprises', ''],
            ['Karma Police', '   ', 'karma police', ''], // trim keeps empty string (because "   " -> "")
        ];
    }

    /**
     * @dataProvider trackProvider
     */
    public function testGetters(
        string $title,
        ?string $mediaId,
        string $expectedTitle,
        ?string $expectedMediaId
    ): void {
        $track = new Track($title, $mediaId);

        // id is UUID string generated in constructor, cannot predict exact value
        $this->assertNotEmpty($track->getId());
        $this->assertMatchesRegularExpression(
            '/^[0-9a-f]{8}-[0-9a-f]{4}-[1-5][0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/i',
            $track->getId()
        );

        $this->assertSame($expectedTitle, $track->getTitle());
        $this->assertSame($expectedMediaId, $track->getMediaId());
    }

    /**
     * @dataProvider trackProvider
     */
    public function testJsonSerialize(
        string $title,
        ?string $mediaId,
        string $expectedTitle,
        ?string $expectedMediaId
    ): void {

        $track = new Track($title, $mediaId);

        $payload = json_decode((string) json_encode($track), true);

        $this->assertIsArray($payload);

        $this->assertArrayHasKey('id', $payload);
        $this->assertArrayHasKey('title', $payload);
        $this->assertArrayHasKey('media_id', $payload);

        $this->assertMatchesRegularExpression(
            '/^[0-9a-f]{8}-[0-9a-f]{4}-[1-5][0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/i',
            (string) $payload['id']
        );

        $this->assertSame($expectedTitle, (string) $payload['title']);
        $this->assertSame($expectedMediaId, $payload['media_id']);
    }

    public function testRenameWithValidTitle(): void
    {
        $track = new Track('Original Title', null);

        $track->rename('  New Title  ');

        $this->assertSame('new title', $track->getTitle());
    }

    public function testRenameWithEmptyStringThrowsException(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Track title cannot be empty.');

        $track = new Track('Original Title', null);
        $track->rename('');
    }

    public function testRenameWithWhitespaceOnlyThrowsException(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Track title cannot be empty.');

        $track = new Track('Original Title', null);
        $track->rename('   ');
    }

    public function testRenameConvertsToLowercase(): void
    {
        $track = new Track('Original Title', null);

        $track->rename('UPPERCASE TITLE');

        $this->assertSame('uppercase title', $track->getTitle());
    }

    public function testRenameTrimsWhitespace(): void
    {
        $track = new Track('Original Title', null);

        $track->rename('  Spaced Title  ');

        $this->assertSame('spaced title', $track->getTitle());
    }
}
