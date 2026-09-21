<?php

/**
 * Scope.php
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
use Lagdo\UiBuilder\Html\Component\VirtualComponent;
use Lagdo\UiBuilder\Html\HtmlComponent;

use function is_a;
use function implode;

/**
 * @template C = HtmlComponent
 */
class Scope
{
    /**
     * @var array<Element>
     */
    protected array $elements = [];

    /**
     * @var array<Element|C>
     */
    protected array $children = [];

    /**
     * Create the corresponding components
     *
     * @param mixed $component
     *
     * @return void
     */
    protected function expand(mixed $component): void
    {
        if (is_a($component, Element::class) || is_a($component, HtmlComponent::class)) {
            $this->children[] = $component;
            return;
        }

        if (is_a($component, VirtualComponent::class)) {
            // Recursively expand the children of the virtual components.
            foreach ($component->children() as $childElement) {
                $this->expand($childElement);
            }
        }
    }

    /**
     * @param array $arguments The arguments passed to the component
     *
     * @return void
     */
    public function build(array $arguments): void
    {
        foreach ($arguments as $argument) {
            $this->expand($argument);
        }

        foreach ($this->children as $component) {
            if (is_a($component, Element::class)) {
                // A children of type Element doesn't need any further processing.
                $this->elements[] = $component;
                continue;
            }

            $scope = new Scope();
            // Recursively build the component children.
            $scope->build($component->children());

            // Add the child component element to the scope elements.
            $this->elements = [
                ...$this->elements,
                ...$component->build($scope->elements),
            ];
        }
    }

    /**
     * @return string
     */
    public function html(): string
    {
        // Merge all the generated elements.
        return implode('', $this->elements);
    }
}
