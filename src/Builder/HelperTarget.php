<?php

/**
 * HelperTarget.php
 *
 * Enum values for the helpers.
 *
 * @package ui-builder-html
 * @author Thierry Feuzeu <thierry.feuzeu@gmail.com>
 * @copyright 2026 Thierry Feuzeu <thierry.feuzeu@gmail.com>
 * @license https://opensource.org/license/mit The MIT License
 * @link https://github.com/lagdo/ui-builder-html
 */

namespace Lagdo\UiBuilder\Html\Builder;

enum HelperTarget: int
{
    case BUILDER = 0;

    case ELEMENT = 1;

    case COMPONENT = 2;
}
