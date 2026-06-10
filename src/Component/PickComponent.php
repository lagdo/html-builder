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

use function is_a;

class PickComponent extends VirtualComponent
{
    /**
     * @param array $choices
     */
    public function __construct(private array $choices)
    {}

    /**
     * @return array<Element|Component>
     */
    public function children(): array
    {
        foreach ($this->choices as $choice) {
            if (is_a($choice, WhenComponent::class) && $choice->matches()) {
                return $choice->children();
            }
        }

        return [];
    }
}
