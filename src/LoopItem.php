<?php

/**
 * LoopItem.php
 *
 * An item in a LoopComponent UI component loop.
 *
 * @package html-builder
 * @author Thierry Feuzeu <thierry.feuzeu@gmail.com>
 * @copyright 2026 Thierry Feuzeu <thierry.feuzeu@gmail.com>
 * @license https://opensource.org/license/mit The MIT License
 * @link https://github.com/lagdo/html-builder
 */

namespace Lagdo\HtmlBuilder;

use Closure;

class LoopItem
{
    /**
     * @param int $index
     * @param string|int|null $key
     * @param mixed $current
     * @param string|int|null $prevKey
     * @param mixed $prev
     * @param string|int|null $nextKey
     * @param mixed $next
     * @param bool $isFirst
     * @param bool $isLast
     */
    public function __construct(public int $index = 0,
        public string|int|null $key = null, public mixed $current = null,
        public string|int|null $prevKey = null, public mixed $prev = null,
        public string|int|null $nextKey = null, public mixed $next = null,
        public bool $isFirst = true, public bool $isLast = false)
    {}

    /**
     * @param Closure $valueGetter
     *
     * @return bool
     */
    public function changed(Closure $valueGetter): bool
    {
        return $valueGetter($this->current) !== $valueGetter($this->prev);
    }

    /**
     * @param string $odd
     * @param string $even
     *
     * @return string
     */
    public function cycle(string $odd, string $even): string
    {
        return $this->index % 2 === 0 ? $odd : $even; // The index starts at 0.
    }
}
