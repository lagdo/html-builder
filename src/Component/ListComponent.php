<?php

/**
 * ListComponent.php
 *
 * Virtual component for a list of components.
 *
 * @package html-builder
 * @author Thierry Feuzeu <thierry.feuzeu@gmail.com>
 * @copyright 2026 Thierry Feuzeu <thierry.feuzeu@gmail.com>
 * @license https://opensource.org/license/mit The MIT License
 * @link https://github.com/lagdo/html-builder
 */

namespace Lagdo\HtmlBuilder\Component;

use Lagdo\HtmlBuilder\Element\Element;

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
