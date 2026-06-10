<?php

/**
 * HtmlComponent.php
 *
 * The HTML UI components provided to the Builder engine.
 *
 * @package ui-builder-html
 * @author Thierry Feuzeu <thierry.feuzeu@gmail.com>
 * @copyright 2026 Thierry Feuzeu <thierry.feuzeu@gmail.com>
 * @license https://opensource.org/license/mit The MIT License
 * @link https://github.com/lagdo/ui-builder-html
 */

namespace Lagdo\UiBuilder\Html;

use Lagdo\UiBuilder\Html\Builder\Engine;
use Lagdo\UiBuilder\Html\Element\Element;
use Lagdo\UiBuilder\Html\Element\Html;
use Lagdo\UiBuilder\Html\Element\Text;
use Lagdo\UiBuilder\Html\Component\Component;
use Closure;

use function is_a;
use function is_array;
use function is_string;

/**
 * @method static setId(string $id, bool $escape = true)
 * @method static setClass(string $class, bool $escape = true)
 * @method static setFor(string $for, bool $escape = true)
 * @method static setName(string $name, bool $escape = true)
 * @method static setValue(string $value, bool $escape = true)
 * @method static setType(string $type, bool $escape = true)
 * @method static setTitle(string $type, bool $escape = true)
 * @method static setStyle(string $type, bool $escape = true)
 */
class HtmlComponent extends Component
{
    /**
     * @var Engine
     */
    public readonly Engine $engine;

    /**
     * @var HtmlElement
     */
    private HtmlElement $element;

    /**
     * @var array<Element|Component>
     */
    private array $children = [];

    /**
     * @var array
     */
    protected array $properties = [];

    /**
     * @var string
     */
    protected string $tagName = '';

    /**
     * @param string $tagName
     * @param array $arguments
     */
    public function __construct(string $tagName, array $arguments = [])
    {
        $this->element = new HtmlElement($this, $tagName ?: $this->tagName);
        // Resolve arguments
        $this->contents(...$arguments);
    }

    /**
     * Set the engine.
     *
     * @param Engine $engine
     *
     * @return HtmlComponent
     */
    public function _e(Engine $engine): static
    {
        // $this->engine is readonly, so this method must not be called again.
        $this->engine = $engine;
        return $this;
    }

    /**
     * @return HtmlElement
     */
    public function element(): HtmlElement
    {
        return $this->element;
    }

    /**
     * @param array<Element> $children
     *
     * @return array<HtmlElement>
     */
    public function build(array $children): array
    {
        return [
            $this->element()->addChildren($children),
        ];
    }

    /**
     * @return static
     */
    public function contents(...$arguments): static
    {
        // Resolve arguments
        foreach ($arguments as $argument) {
            switch (true) {
                case is_array($argument):
                    $this->element->setAttributes($argument);
                    break;
                case is_string($argument):
                    $this->children[] = new Html($argument);
                    break;
                case is_a($argument, Element::class):
                case is_a($argument, Component::class):
                    $this->children[] = $argument;
            }
        }
        return $this;
    }

    /**
     * @return array<Element|Component>
     */
    public function children(): array
    {
        return $this->children;
    }

    /**
     * @param string $text
     *
     * @return static
     */
    protected function addText(string $text): static
    {
        $this->children[] = new Text($text);
        return $this;
    }

    /**
     * @param string $html
     *
     * @return static
     */
    protected function addHtml(string $html): static
    {
        $this->children[] = new Html($html);
        return $this;
    }

    /**
     * @param string $method
     * @param array $arguments
     *
     * @return static
     */
    public function __call(string $method, array $arguments): static
    {
        $this->engine->callComponentHelper($this, $method, $arguments);
        return $this;
    }

    /**
     * @param string $class
     *
     * @return static
     */
    public function addClass(string $class): static
    {
        $this->element->addClass($class);
        return $this;
    }

    /**
     * @param string $class
     *
     * @return static
     */
    public function setClass(string $class): static
    {
        // Actually appends the class.
        return $this->addClass($class);
    }

    /**
     * @param string $class
     *
     * @return static
     */
    public function removeClass(string $class): static
    {
        $this->element->removeClass($class);
        return $this;
    }

    /**
     * @param string $class
     *
     * @return bool
     */
    public function hasClass(string $class): bool
    {
        return $this->element->hasClass($class);
    }

    /**
     * @param string $name
     * @param string|bool $value
     * @param bool $escape
     *
     * @return static
     */
    public function setAttribute(string $name, string|bool $value = true, bool $escape = true): static
    {
        $this->element->setAttribute($name, $value, $escape);
        return $this;
    }

    /**
     * @param array $attributes
     * @param bool $escape
     *
     * @return static
     */
    public function setAttributes(array $attributes, bool $escape = true): static
    {
        $this->element->setAttributes($attributes, $escape);
        return $this;
    }

    /**
     * @param string $name
     *
     * @return bool
     */
    public function hasAttribute(string $name): bool
    {
        return $this->element->hasAttribute($name);
    }

    /**
     * @param string $name
     *
     * @return string|bool
     */
    public function getAttribute(string $name): string|bool
    {
        return $this->element->getAttribute($name);
    }

    /**
     * @param string $name
     *
     * @return static
     */
    public function removeAttribute(string $name): static
    {
        $this->element->removeAttribute($name);
        return $this;
    }

    /**
     * @param bool $condition
     * @param Closure $closure
     *
     * @return static
     */
    public function when(bool $condition, Closure $closure): static
    {
        $condition && $closure($this);
        return $this;
    }

    /**
     * @param Closure $closure
     *
     * @return static
     */
    public function with(Closure $closure): static
    {
        $closure($this);
        return $this;
    }

    /**
     * @return static
     */
    public function disable(): static
    {
        $this->element()->setAttribute('disabled', 'disabled');
        return $this;
    }
}
