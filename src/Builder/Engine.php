<?php

/**
 * Engine.php
 *
 * The HTML UI Builder engine.
 *
 * @package ui-builder-html
 * @author Thierry Feuzeu <thierry.feuzeu@gmail.com>
 * @copyright 2026 Thierry Feuzeu <thierry.feuzeu@gmail.com>
 * @license https://opensource.org/license/mit The MIT License
 * @link https://github.com/lagdo/ui-builder-html
 */

namespace Lagdo\UiBuilder\Html\Builder;

use Lagdo\UiBuilder\Html\Element\Element;
use Lagdo\UiBuilder\Html\HtmlBuilder;
use Lagdo\UiBuilder\Html\HtmlComponent;
use Lagdo\UiBuilder\Html\HtmlElement;
use Closure;
use LogicException;

use function preg_replace;
use function strlen;
use function substr;
use function strtolower;

class Engine
{
    /**
     * @var array<int, array<string, Closure>>
     */
    protected $helpers = [
        HelperTarget::BUILDER->value => [],
        HelperTarget::ELEMENT->value => [],
        HelperTarget::COMPONENT->value => [],
    ];

    /**
     * @param HtmlBuilder $builder
     */
    public function __construct(protected HtmlBuilder $builder)
    {
        // Register a helper for the element attribute setter.
        $helper = fn(HtmlElement $element, string $tagName, string $method, array $arguments)
            => $element->setAttribute($tagName, $arguments[0] ?? null, $arguments[1] ?? true);
        $this->registerElementHelper('set', $helper);
        // Register a helper for the component attribute setter.
        $helper = fn(HtmlComponent $component, string $tagName, string $method, array $arguments)
            => $component->setAttribute($tagName, $arguments[0] ?? null, $arguments[1] ?? true);
        $this->registerComponentHelper('set', $helper);
    }

    /**
     * @param string $prefix
     * @param HelperTarget $target
     * @param Closure $helper
     *
     * @return static
     */
    private function registerHelper(string $prefix, HelperTarget $target, Closure $helper): static
    {
        // Do not overwrite existing helpers.
        if (!isset($this->helpers[$target->value][$prefix])) {
            $this->helpers[$target->value][$prefix] = $helper;
        }

        return $this;
    }

    /**
     * @param string $prefix
     * @param Closure $helper
     *
     * @return static
     */
    public function registerBuilderHelper(string $prefix, Closure $helper): static
    {
        return $this->registerHelper($prefix, HelperTarget::BUILDER, $helper);
    }

    /**
     * @param string $prefix
     * @param Closure $helper
     *
     * @return static
     */
    public function registerElementHelper(string $prefix, Closure $helper): static
    {
        return $this->registerHelper($prefix, HelperTarget::ELEMENT, $helper);
    }

    /**
     * @param string $prefix
     * @param Closure $helper
     *
     * @return static
     */
    public function registerComponentHelper(string $prefix, Closure $helper): static
    {
        return $this->registerHelper($prefix, HelperTarget::COMPONENT, $helper);
    }

    /**
     * @param string $method
     *
     * @return string
     */
    private function getTagName(string $method): string
    {
        return strtolower(preg_replace('/(?<!^)([A-Z])/', '-$1', $method));
    }

    /**
     * @param string $method
     * @param array $arguments
     *
     * @return HtmlComponent|Element
     */
    public function callBuilderHelper(string $method, array $arguments): HtmlComponent|Element
    {
        $methodTagName = $this->getTagName($method);
        foreach($this->helpers[HelperTarget::BUILDER->value] as $prefix => $helper) {
            $tagName = substr($methodTagName, strlen($prefix) + 1);
            if ($tagName === "$prefix-") {
                return $helper($tagName, $method, $arguments);
            }
        }

        return $this->builder->createComponent($tagName, $arguments);
    }

    /**
     * @param HtmlElement $element
     * @param string $method
     * @param array $arguments
     *
     * @return HtmlElement
     * @throws LogicException When component is not initialized yet
     */
    public function callElementHelper(HtmlElement $element,
        string $method, array $arguments): HtmlElement
    {
        $methodTagName = $this->getTagName($method);
        foreach($this->helpers[HelperTarget::ELEMENT->value] as $prefix => $helper) {
            $tagName = substr($methodTagName, strlen($prefix) + 1);
            if ($tagName === "$prefix-") {
                return $helper($element, $tagName, $method, $arguments);
            }
        }

        throw new LogicException("Call to undefined method \"{$method}()\" in the HTML element.");
    }

    /**
     * @param HtmlComponent $component
     * @param string $method
     * @param array $arguments
     *
     * @return HtmlComponent
     * @throws LogicException When component is not initialized yet
     */
    public function callComponentHelper(HtmlComponent $component,
        string $method, array $arguments): HtmlComponent
    {
        $methodTagName = $this->getTagName($method);
        foreach($this->helpers[HelperTarget::COMPONENT->value] as $prefix => $helper) {
            $tagName = substr($methodTagName, strlen($prefix) + 1);
            if ($tagName === "$prefix-") {
                return $helper($component, $tagName, $method, $arguments);
            }
        }

        throw new LogicException("Call to undefined method \"{$method}()\" in the HTML component.");
    }

    /**
     * @param array $arguments
     *
     * @return string
     */
    public function build(array $arguments): string
    {
        // The "root" component below will not be printed.
        $scope = new Scope($this->builder->createComponent('root'));
        $scope->build($arguments);

        return $scope->html();
    }
}
