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

namespace Lagdo\UiBuilder\Html\Component;

use Lagdo\UiBuilder\Html\Element\Element;
use Closure;

use function is_a;

class WhenComponent extends VirtualComponent
{
    /**
     * @param bool $condition
     * @param Closure|Component $element
     */
    public function __construct(private bool $condition,
        private Closure|Component $element)
    {}

    /**
     * @return bool
     */
    public function matches(): bool
    {
        return $this->condition;
    }

    /**
     * @return array<Element|Component>
     */
    public function children(): array
    {
        if (!$this->condition) {
            return [];
        }

        $element = is_a($this->element, Closure::class) ?
            ($this->element)() : $this->element;
        return $element !== null ? [$element] : [];
    }
}
