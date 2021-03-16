<?php declare(strict_types=1);

namespace Service\Tag;

use PHPUnit\Framework\TestCase;
use ShipEngine\Model\Tag\Tag;
use ShipEngine\ShipEngine;

/**
 * Tests the methods provided in the `TagTrait`.
 *
 * @covers \ShipEngine\Model\Tag\Tag
 * @covers \ShipEngine\Service\Tag\TagTrait
 * @covers \ShipEngine\Service\Tag\TagService
 * @covers \ShipEngine\Service\AbstractService
 * @covers \ShipEngine\Service\ServiceFactory
 * @covers \ShipEngine\ShipEngine
 * @covers \ShipEngine\ShipEngineClient
 */
final class TagTraitTest extends TestCase
{
    /**
     * @var ShipEngine
     */
    private ShipEngine $shipengine;

    /**
     * @var string
     */
    private string $test_tag;

    /**
     * Pass in an `api-key` the new instance of the *ShipEngine* class.
     *
     * @return void
     */
    protected function setUp(): void
    {
        $this->test_tag = 'calque';
        $this->shipengine = new ShipEngine('baz');
    }

    /**
     * Test the `createTag()` convenience method on the *TagTrait* successfully creates a new tag using
     * the `tag/create` remote procedure.
     *
     * @return void
     */
    public function testCreateValidTag(): void
    {
        $new_tag = $this->shipengine->createTag($this->test_tag);

        $this->assertEquals($this->test_tag, $new_tag->name);
    }

    /**
     * Test the return type, should be an instance of the `Tag` Type.
     */
    public function testReturnValue(): void
    {
        $new_tag = $this->shipengine->tags->create(array('name' => $this->test_tag));

        $this->assertInstanceOf(Tag::class, $new_tag);
    }
}
