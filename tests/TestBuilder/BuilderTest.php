<?php

namespace Lagdo\HtmlBuilder\Tests\TestBuilder;

use Lagdo\HtmlBuilder\HtmlBuilder;
use Lagdo\HtmlBuilder\HtmlComponent;
use PHPUnit\Framework\TestCase;

final class BuilderTest extends TestCase
{
    /**
     * @var HtmlBuilder
     */
    protected $builder;

    protected function setUp(): void
    {
        $this->builder = new HtmlBuilder();
    }

    public function testHelloWorld()
    {
        $html = $this->builder->build(
            $this->builder->div(
                $this->builder->html('Hello&nbsp;'),
                $this->builder->b(
                    $this->builder->text('World')
                ),
                $this->builder->comment('Salutations')
            )
        );
        $this->assertEquals('<div>Hello&nbsp;<b>World</b><!--Salutations--></div>', $html);
    }

    public function testAttributes()
    {
        $html = $this->builder->build(
            $this->builder->div($this->builder->text('Content'))
                ->setId('div-id')
                ->setClass('div-class')
                ->setDataKey('div-key')
        );
        $this->assertEquals('<div id="div-id" data-key="div-key" class="div-class">Content</div>', $html);
    }

    private function formatParagraph(HtmlComponent $component)
    {
        $component->setClass('paragraph');
    }

    public function testConditionalAttribute()
    {
        $important = false;
        $html = $this->builder->build(
            $this->builder->div($this->builder->text('Content'))
                ->when($important, fn($component) => $component->addClass('important'))
        );
        $this->assertEquals('<div>Content</div>', $html);

        $important = true;
        $html = $this->builder->build(
            $this->builder->div($this->builder->text('Content'))
                ->when($important, fn($component) => $component->addClass('important'))
        );
        $this->assertEquals('<div class="important">Content</div>', $html);

        $html = $this->builder->build(
            $this->builder->div($this->builder->text('Content'))
                ->with($this->formatParagraph(...))
        );
        $this->assertEquals('<div class="paragraph">Content</div>', $html);
    }

    public function testBuilderWhen()
    {
        $user = (object)['name' => 'Admin'];
        $html = $this->builder->build(
            $this->builder->div(
                $this->builder->text('Welcome'),
                $this->builder->when($user !== null, fn() => $this->builder->html("&nbsp;{$user->name}"))
            )
        );
        $this->assertEquals('<div>Welcome&nbsp;Admin</div>', $html);
    }

    public function testBuilderPick()
    {
        $user = (object)['name' => 'Admin', 'isAdmin' => true];
        $html = $this->builder->build(
            $this->builder->div(
                $this->builder->pick(
                    $this->builder->when($user === null, fn() => $this->builder->text('Welcome')),
                    $this->builder->when($user->isAdmin, fn() => $this->builder->html("Welcome&nbsp;<b>{$user->name}</b>")),
                    $this->builder->when(true, fn() => $this->builder->html("Welcome&nbsp;{$user->name}"))
                )
            )
        );
        $this->assertEquals('<div>Welcome&nbsp;<b>Admin</b></div>', $html);
    }

    public function testBuilderEach()
    {
        $menuItems = [
            (object)['title' => 'First'],
            (object)['title' => 'Second'],
            (object)['title' => 'Third'],
        ];
        $html = $this->builder->build(
            $this->builder->ul(
                $this->builder->each($menuItems, fn($menuItem) => $this->builder->li($menuItem->title))
            )
        );
        $this->assertEquals('<ul><li>First</li><li>Second</li><li>Third</li></ul>', $html);
    }

    public function testBuilderLoop()
    {
        $menuItems = [
            (object)['title' => 'First', 'group' => 'One'],
            (object)['title' => 'Second', 'group' => 'One'],
            (object)['title' => 'Third', 'group' => 'One'],
            (object)['title' => 'Fourth', 'group' => 'Two'],
            (object)['title' => 'Fifth', 'group' => 'Two'],
        ];
        $html = $this->builder->build(
            $this->builder->ul(
                $this->builder->loop(
                    $menuItems,
                    fn($menuItem, $loop) => $this->builder->li($menuItem->title)
                        ->setClass($loop->cycle('item-odd', 'item-even'))
                        ->when(
                            $loop->changed(fn($item) => $item?->group ?? ''),
                            fn($menuComponent) => $menuComponent->setClass('item-group')
                        )
                )
            )
        );
        $this->assertEquals('<ul>' .
            '<li class="item-odd item-group">First</li>' .
            '<li class="item-even">Second</li>' .
            '<li class="item-odd">Third</li>' .
            '<li class="item-even item-group">Fourth</li>' .
            '<li class="item-odd">Fifth</li>' .
            '</ul>', $html);
    }

    public function testBuilderList()
    {
        $menuItems = [
            (object)['title' => 'First', 'group' => 'One'],
            (object)['title' => 'Second', 'group' => 'One'],
            (object)['title' => 'Third', 'group' => 'One'],
            (object)['title' => 'Fourth', 'group' => 'Two'],
            (object)['title' => 'Fifth', 'group' => 'Two'],
        ];
        $html = $this->builder->build(
            $this->builder->ul(
                $this->builder->each($menuItems, fn($menuItem) =>
                    $this->builder->list(
                        $this->builder->li($menuItem->title),
                        $this->builder->comment("Group: {$menuItem->group}")
                    )
                )
            )
        );
        $this->assertEquals('<ul>' .
            '<li>First</li><!--Group: One-->' .
            '<li>Second</li><!--Group: One-->' .
            '<li>Third</li><!--Group: One-->' .
            '<li>Fourth</li><!--Group: Two-->' .
            '<li>Fifth</li><!--Group: Two-->' .
            '</ul>', $html);
    }
}
