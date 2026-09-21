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
use function sprintf;

/**
 * Provides html comment block
 */
class Comment extends Html
{
    /**
     * @inheritDoc
     */
    protected function render(): string
    {
        return sprintf('<!--%s-->', htmlspecialchars($this->text, ENT_COMPAT));
    }
}
