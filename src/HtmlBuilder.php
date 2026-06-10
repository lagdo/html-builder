<?php

/**
 * HtmlBuilder.php
 *
 * The HTML UI Builder engine.
 *
 * @package ui-builder-html
 * @author Thierry Feuzeu <thierry.feuzeu@gmail.com>
 * @copyright 2026 Thierry Feuzeu <thierry.feuzeu@gmail.com>
 * @license https://opensource.org/license/mit The MIT License
 * @link https://github.com/lagdo/ui-builder-html
 */

namespace Lagdo\UiBuilder\Html;

use Lagdo\UiBuilder\Html\Builder\Engine;
use Lagdo\UiBuilder\Html\Component\Component;
use Lagdo\UiBuilder\Html\Component\EachComponent;
use Lagdo\UiBuilder\Html\Component\ListComponent;
use Lagdo\UiBuilder\Html\Component\PickComponent;
use Lagdo\UiBuilder\Html\Component\WhenComponent;
use Lagdo\UiBuilder\Html\Element\Comment;
use Lagdo\UiBuilder\Html\Element\Element;
use Lagdo\UiBuilder\Html\Element\Html;
use Lagdo\UiBuilder\Html\Element\Text;
use Closure;

class HtmlBuilder
{
    /**
     * @var Engine
     */
    private $engine;

    /**
     * The constructor
     */
    public function __construct()
    {
        $this->engine = new Engine($this);
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
        $this->registerBuilderHelper($prefix, $helper);
    }

    /**
     * @param string $prefix
     * @param Closure $helper
     *
     * @return void
     */
    public function registerElementHelper(string $prefix, Closure $helper): void
    {
        $this->registerElementHelper($prefix, $helper);
    }

    /**
     * @param string $prefix
     * @param Closure $helper
     *
     * @return void
     */
    public function registerComponentHelper(string $prefix, Closure $helper): void
    {
        $this->registerComponentHelper($prefix, $helper);
    }

    /**
     * @template T of HtmlComponent
     * @param array $arguments
     * @param string $tagName
     * @psalm-param class-string<T> $class
     *
     * @return T
     */
    private function _createComponent(array $arguments,
        string $tagName = '', string $class = HtmlComponent::class): mixed
    {
        return new $class($this->engine, $tagName, $arguments);
    }

    /**
     * @inheritDoc
     */
    public function tag(string $tagName, ...$arguments): HtmlComponent
    {
        return $this->_createComponent($arguments, tagName: $tagName);
    }

    /**
     * @param string $tagName
     * @param array $arguments
     *
     * @return HtmlComponent
     */
    public function createComponent(string $tagName, array $arguments = []): HtmlComponent
    {
        return $this->_createComponent($arguments, tagName: $tagName);
    }

    /**
     * @template T of HtmlComponent
     * @psalm-param class-string<T> $class
     * @param array $arguments
     *
     * @return T
     */
    protected function createComponentOfClass(string $class, array $arguments = []): HtmlComponent
    {
        return $this->_createComponent($arguments, class: $class);
    }

    /**
     * @inheritDoc
     */
    public function each(array $values, Closure $closure): Component
    {
        return new EachComponent($values, $closure);
    }

    /**
     * @inheritDoc
     */
    public function list(...$arguments): Component
    {
        return new ListComponent($arguments);
    }

    /**
     * @inheritDoc
     */
    public function when(bool $condition, Closure $closure): Component
    {
        return new WhenComponent($condition, $closure);
    }

    /**
     * @inheritDoc
     */
    public function pick(...$arguments): Component
    {
        return new PickComponent($arguments);
    }

    /**
     * @inheritDoc
     */
    public function text(string $text): Element
    {
        return new Text($text);
    }

    /**
     * @inheritDoc
     */
    public function html(string $html): Element
    {
        return new Html($html);
    }

    /**
     * @inheritDoc
     */
    public function comment(string $comment): Element
    {
        return new Comment($comment);
    }

    /**
     * @inheritDoc
     */
    public function build(...$arguments): string
    {
        return $this->engine->build($arguments);
    }
}
