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

/**
 * @template C of HtmlComponent = HtmlComponent
 */
class HtmlBuilder
{
    /**
     * @var Engine
     */
    protected Engine $engine;

    /**
     * @var string
     */
    protected static string $componentClass = HtmlComponent::class;

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
     * @template T of C
     * @param array $arguments
     * @param string $tagName
     * @psalm-param class-string<T>|null $class
     *
     * @return T
     */
    private function newComponent(array $arguments,
        string $tagName = '', string|null $class = null): mixed
    {
        $componentClass = $class ?? static::$componentClass;
        return (new $componentClass($tagName, $arguments))->_e($this->engine);
    }

    /**
     * @param string $tagName
     *
     * @return C
     */
    public function tag(string $tagName, ...$arguments): mixed
    {
        return $this->newComponent($arguments, tagName: $tagName);
    }

    /**
     * @param string $tagName
     * @param array $arguments
     *
     * @return C
     */
    public function createComponent(string $tagName, array $arguments = []): mixed
    {
        return $this->newComponent($arguments, tagName: $tagName);
    }

    /**
     * @template T of C
     * @psalm-param class-string<T> $class
     * @param array $arguments
     *
     * @return T
     */
    protected function createComponentOfClass(string $class, array $arguments = []): mixed
    {
        return $this->newComponent($arguments, class: $class);
    }

    /**
     * @param array $values
     * @param Closure $closure
     *
     * @return Component
     */
    public function each(array $values, Closure $closure): Component
    {
        return new EachComponent($values, $closure);
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
