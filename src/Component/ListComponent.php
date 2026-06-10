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

class ListComponent extends VirtualComponent
{
    /**
     * @param array $children
     */
    public function __construct(private array $children)
    {}

    /**
     * @return array<Element|Component>
     */
    public function children(): array
    {
        return $this->children;
    }
}
