<?php

/**
 * LoopComponent.php
 *
 * Virtual UI component for a loop.
 *
 * @package ui-builder-html
 * @author Thierry Feuzeu <thierry.feuzeu@gmail.com>
 * @copyright 2026 Thierry Feuzeu <thierry.feuzeu@gmail.com>
 * @license https://opensource.org/license/mit The MIT License
 * @link https://github.com/lagdo/ui-builder-html
 */

namespace Lagdo\UiBuilder\Html\Component;

use Lagdo\UiBuilder\Html\Element\Element;
use Lagdo\UiBuilder\Html\LoopItem;
use Closure;
use Iterator;
use Generator;

class LoopComponent extends VirtualComponent
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
        $firstLoop = true;
        $loopItem = new LoopItem();
        foreach ($this->items as $key => $item) {
            // Each item is process one loop later.
            // So the first loop is skipped.
            if ($firstLoop) {
                $loopItem->key = $key;
                $loopItem->current = $item;
                $firstLoop = false;
                continue;
            }

            $loopItem->nextKey = $key;
            $loopItem->next = $item;
            $children[] = ($this->closure)($loopItem->current, $loopItem);

            // Before moving to the next item.
            $loopItem->prevKey = $loopItem->key;
            $loopItem->prev = $loopItem->current;
            $loopItem->key = $key;
            $loopItem->current = $item;
            $loopItem->isFirst = false;
            $loopItem->index++;
        }

        if (!$firstLoop) {
            // Process the last item.
            $loopItem->isLast = true;
            $loopItem->nextKey = null;
            $loopItem->next = null;
            $children[] = ($this->closure)($loopItem->current, $loopItem);
        }

        return $children;
    }
}
