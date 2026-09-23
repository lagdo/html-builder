<?php

/**
 * HtmlTrait.php
 *
 * Builder functions for the most common HTML tags.
 *
 * @package html-builder
 * @author Thierry Feuzeu <thierry.feuzeu@gmail.com>
 * @copyright 2026 Thierry Feuzeu <thierry.feuzeu@gmail.com>
 * @license https://opensource.org/license/mit The MIT License
 * @link https://github.com/lagdo/html-builder
 */

namespace Lagdo\HtmlBuilder\Builder;

use Lagdo\HtmlBuilder\HtmlComponent;

trait HtmlTrait
{
    /**
     * @param string $tagName
     *
     * @return HtmlComponent
     */
    abstract public function tag(string $tagName, ...$arguments): HtmlComponent;

    /**
     * @return HtmlComponent
     */
    public function body(...$arguments): HtmlComponent
    {
        return $this->tag('body', ...$arguments);
    }

    /**
     * @return HtmlComponent
     */
    public function div(...$arguments): HtmlComponent
    {
        return $this->tag('div', ...$arguments);
    }

    /**
     * @return HtmlComponent
     */
    public function span(...$arguments): HtmlComponent
    {
        return $this->tag('span', ...$arguments);
    }

    /**
     * @return HtmlComponent
     */
    public function a(...$arguments): HtmlComponent
    {
        return $this->tag('a', ...$arguments);
    }

    /**
     * @return HtmlComponent
     */
    public function i(...$arguments): HtmlComponent
    {
        return $this->tag('i', ...$arguments);
    }

    /**
     * @return HtmlComponent
     */
    public function nav(...$arguments): HtmlComponent
    {
        return $this->tag('nav', ...$arguments);
    }

    /**
     * @return HtmlComponent
     */
    public function h1(...$arguments): HtmlComponent
    {
        return $this->tag('h1', ...$arguments);
    }

    /**
     * @return HtmlComponent
     */
    public function h2(...$arguments): HtmlComponent
    {
        return $this->tag('h2', ...$arguments);
    }

    /**
     * @return HtmlComponent
     */
    public function h3(...$arguments): HtmlComponent
    {
        return $this->tag('h3', ...$arguments);
    }

    /**
     * @return HtmlComponent
     */
    public function h4(...$arguments): HtmlComponent
    {
        return $this->tag('h4', ...$arguments);
    }

    /**
     * @return HtmlComponent
     */
    public function h5(...$arguments): HtmlComponent
    {
        return $this->tag('h5', ...$arguments);
    }

    /**
     * @return HtmlComponent
     */
    public function h6(...$arguments): HtmlComponent
    {
        return $this->tag('h6', ...$arguments);
    }

    /**
     * @return HtmlComponent
     */
    public function ul(...$arguments): HtmlComponent
    {
        return $this->tag('ul', ...$arguments);
    }

    /**
     * @return HtmlComponent
     */
    public function ol(...$arguments): HtmlComponent
    {
        return $this->tag('ol', ...$arguments);
    }

    /**
     * @return HtmlComponent
     */
    public function li(...$arguments): HtmlComponent
    {
        return $this->tag('li', ...$arguments);
    }

    /**
     * @return HtmlComponent
     */
    public function optgroup(...$arguments): HtmlComponent
    {
        return $this->tag('optgroup', ...$arguments);
    }

    /**
     * @return HtmlComponent
     */
    public function thead(...$arguments): HtmlComponent
    {
        return $this->tag('thead', ...$arguments);
    }

    /**
     * @return HtmlComponent
     */
    public function tbody(...$arguments): HtmlComponent
    {
        return $this->tag('tbody', ...$arguments);
    }

    /**
     * @return HtmlComponent
     */
    public function th(...$arguments): HtmlComponent
    {
        return $this->tag('th', ...$arguments);
    }

    /**
     * @return HtmlComponent
     */
    public function tr(...$arguments): HtmlComponent
    {
        return $this->tag('tr', ...$arguments);
    }

    /**
     * @return HtmlComponent
     */
    public function td(...$arguments): HtmlComponent
    {
        return $this->tag('td', ...$arguments);
    }

    /**
     * @return HtmlComponent
     */
    public function img(...$arguments): HtmlComponent
    {
        return $this->tag('img', ...$arguments);
    }

    /**
     * @return HtmlComponent
     */
    public function figure(...$arguments): HtmlComponent
    {
        return $this->tag('figure', ...$arguments);
    }

    /**
     * @return HtmlComponent
     */
    public function p(...$arguments): HtmlComponent
    {
        return $this->tag('p', ...$arguments);
    }
}
