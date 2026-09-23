<?php

namespace Lagdo\HtmlBuilder\Tests;

use Lagdo\HtmlBuilder\HtmlBuilder;
use PHPUnit\Framework\TestCase;

final class AttrTest extends TestCase
{
    /**
     * @var HtmlBuilder
     */
    protected $builder;

    protected function setUp(): void
    {
        $this->builder = new HtmlBuilder();
    }

    public function testAttrEscape()
    {
        $html = $this->builder->build(
            $this->builder->div($this->builder->text('Content'))
                ->setAttribute('json', '{"name":"value"}', true)
        );
        $this->assertEquals('<div json="{&quot;name&quot;:&quot;value&quot;}">Content</div>', $html);

        $html = $this->builder->build(
            $this->builder->div($this->builder->text('Content'))
                ->setAttribute('json', '{"name":"value"}', false)
        );
        $this->assertEquals('<div json="{"name":"value"}">Content</div>', $html);
    }

    public function testAttrBoolean()
    {
        $html = $this->builder->build(
            $this->builder->div($this->builder->text('Content'))
                ->setDataIsPresent(true)
                ->setDataNotPresent(false)
        );
        $this->assertEquals('<div data-is-present>Content</div>', $html);
    }

    public function testAttrDisable()
    {
        $component = $this->builder->div($this->builder->text('Content'))->disable();
        $this->assertEquals('disabled', $component->getAttribute('disabled'));

        $html = $this->builder->build($component);
        $this->assertEquals('<div disabled="disabled">Content</div>', $html);
    }
}
