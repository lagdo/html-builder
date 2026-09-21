<?php

/*
 * This file is part of the PhpHtmlBuilder package.
 *
 * (c) Andrew Polupanov <andrewfortalking@gmail.com>
 * (c) 2026 Thierry Feuzeu <thierry.feuzeu@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Lagdo\UiBuilder\Html\Element;

/**
 * Provides text block. No escaping.
 */
class Html extends Element
{
    /**
     * @param string $text
     */
    public function __construct(protected string $text)
    {}

    /**
     * @inheritDoc
     */
    protected function render(): string
    {
        return $this->text;
    }
}
