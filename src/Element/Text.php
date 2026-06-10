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

use function htmlspecialchars;

/**
 * Provides text block. Supports escaping.
 */
class Text extends Html
{
    /**
     * @inheritDoc
     */
    protected function render(): string
    {
        return htmlspecialchars($this->text, ENT_COMPAT);
    }
}
