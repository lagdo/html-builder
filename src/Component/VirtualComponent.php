<?php

/**
 * VirtualComponent.php
 *
 * Base class for virtual UI components.
 *
 * @package html-builder
 * @author Thierry Feuzeu <thierry.feuzeu@gmail.com>
 * @copyright 2026 Thierry Feuzeu <thierry.feuzeu@gmail.com>
 * @license https://opensource.org/license/mit The MIT License
 * @link https://github.com/lagdo/html-builder
 */

namespace Lagdo\HtmlBuilder\Component;

use Lagdo\HtmlBuilder\Element\Element;

/**
 * Base class for virtual components.
 */
abstract class VirtualComponent extends Component
{
    /**
     * @return array<Element|Component>
     */
    abstract public function children(): array;
}
