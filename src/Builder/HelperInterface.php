<?php

/**
 * HelperInterface.php
 *
 * Helper functions for the components and elements.
 *
 * @package html-builder
 * @author Thierry Feuzeu <thierry.feuzeu@gmail.com>
 * @copyright 2026 Thierry Feuzeu <thierry.feuzeu@gmail.com>
 * @license https://opensource.org/license/mit The MIT License
 * @link https://github.com/lagdo/html-builder
 */

namespace Lagdo\HtmlBuilder\Builder;

use Lagdo\HtmlBuilder\HtmlComponent;
use Lagdo\HtmlBuilder\HtmlElement;
use LogicException;

interface HelperInterface
{
    /**
     * @param HtmlElement $element
     * @param string $method
     * @param array $arguments
     *
     * @return HtmlElement
     * @throws LogicException When component is not initialized yet
     */
    public function callElementHelper(HtmlElement $element,
        string $method, array $arguments): HtmlElement;

    /**
     * @param HtmlComponent $component
     * @param string $method
     * @param array $arguments
     *
     * @return HtmlComponent
     * @throws LogicException When component is not initialized yet
     */
    public function callComponentHelper(HtmlComponent $component,
        string $method, array $arguments): HtmlComponent;
}
