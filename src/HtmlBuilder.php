<?php

/**
 * HtmlBuilder.php
 *
 * The HTML Builder engine.
 *
 * @package html-builder
 * @author Thierry Feuzeu <thierry.feuzeu@gmail.com>
 * @copyright 2026 Thierry Feuzeu <thierry.feuzeu@gmail.com>
 * @license https://opensource.org/license/mit The MIT License
 * @link https://github.com/lagdo/html-builder
 */

namespace Lagdo\HtmlBuilder;

use Lagdo\HtmlBuilder\Builder\Engine;
use Lagdo\HtmlBuilder\Component\Component;
use Lagdo\HtmlBuilder\Component\EachComponent;
use Lagdo\HtmlBuilder\Component\ListComponent;
use Lagdo\HtmlBuilder\Component\LoopComponent;
use Lagdo\HtmlBuilder\Component\PickComponent;
use Lagdo\HtmlBuilder\Component\WhenComponent;
use Lagdo\HtmlBuilder\Element\Comment;
use Lagdo\HtmlBuilder\Element\Element;
use Lagdo\HtmlBuilder\Element\Html;
use Lagdo\HtmlBuilder\Element\Text;
use Closure;
use Generator;
use Iterator;

class HtmlBuilder
{
    /**
     * @var Engine
     */
    protected Engine $engine;

    public function __construct()
    {
        $this->engine = new Engine();
    }

    /**
     * @param string $method
     * @param array $arguments
     *
     * @return HtmlComponent
     */
    public function __call(string $method, array $arguments): mixed
    {
        return $this->engine->callBuilderHelper($method, $arguments);
    }

    /**
     * @param string $prefix
     * @param Closure $helper
     *
     * @return void
     */
    public function registerBuilderHelper(string $prefix, Closure $helper): void
    {
        $this->engine->registerBuilderHelper($prefix, $helper);
    }

    /**
     * @param string $prefix
     * @param Closure $helper
     *
     * @return void
     */
    public function registerElementHelper(string $prefix, Closure $helper): void
    {
        $this->engine->registerElementHelper($prefix, $helper);
    }

    /**
     * @param string $prefix
     * @param Closure $helper
     *
     * @return void
     */
    public function registerComponentHelper(string $prefix, Closure $helper): void
    {
        $this->engine->registerComponentHelper($prefix, $helper);
    }

    /**
     * @param string $tagName
     *
     * @return HtmlComponent
     */
    public function tag(string $tagName, ...$arguments): HtmlComponent
    {
        return $this->engine->tag(HtmlComponent::class, $tagName, $arguments);
    }

    /**
     * @return Component
     */
    public function list(...$arguments): Component
    {
        return new ListComponent($arguments);
    }

    /**
     * @param bool $condition
     * @param Closure $closure
     *
     * @return Component
     */
    public function when(bool $condition, Closure $closure): Component
    {
        return new WhenComponent($condition, $closure);
    }

    /**
     * @return Component
     */
    public function pick(...$arguments): Component
    {
        return new PickComponent($arguments);
    }

    /**
     * @param array|Iterator|Generator $items
     * @param Closure $closure
     *
     * @return Component
     */
    public function each(array|Iterator|Generator $items, Closure $closure): Component
    {
        return new EachComponent($items, $closure);
    }

    /**
     * @param array|Iterator|Generator $items
     * @param Closure $closure
     *
     * @return Component
     */
    public function loop(array|Iterator|Generator $items, Closure $closure): Component
    {
        return new LoopComponent($items, $closure);
    }

    /**
     * @param string $text
     *
     * @return Element
     */
    public function text(string $text): Element
    {
        return new Text($text);
    }

    /**
     * @param string $html
     *
     * @return Element
     */
    public function html(string $html): Element
    {
        return new Html($html);
    }

    /**
     * @param string $comment
     *
     * @return Element
     */
    public function comment(string $comment): Element
    {
        return new Comment($comment);
    }

    /**
     * @return string
     */
    public function build(...$arguments): string
    {
        return $this->engine->build($arguments);
    }
}
