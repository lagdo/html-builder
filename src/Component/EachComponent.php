<?php

/**
 * EachComponent.php
 *
 * Virtual UI component for each loop.
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
use Iterator;
use Generator;

class EachComponent extends VirtualComponent
{
    /**
     * @param array|Iterator|Generator $items
     * @param Closure $closure
     */
    public function __construct(private array|Iterator|Generator $items,
        private Closure $closure)
    {}

    /**
     * @return array<Element|Component>
     */
    public function children(): array
    {
        $children = [];
        foreach ($this->items as $key => $item) {
            $children[] = ($this->closure)($item, $key);
        }

        return $children;
    }
}
