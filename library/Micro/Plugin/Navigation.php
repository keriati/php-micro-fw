<?php
/**
 * PHP Micro Framework
 *
 * Tiny MVC framework for learning purposes.
 *
 * LICENSE: This source file is subject to the MIT license as follows:
 * Copyright (c) 2012 Attila Kerekes
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated
 * documentation files (the "Software"), to deal in the Software without restriction, including without limitation the
 * rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to
 * permit persons to whom the Software is furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all copies or substantial portions of the
 * Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE
 * WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR
 * COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR
 * OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 *
 * @package        Micro
 * @author         Attila Kerekes
 * @copyright      Copyright (c) 2012, Attila Kerekes. (http://www.attilakerekes.com)
 * @license        http://www.opensource.org/licenses/MIT The MIT License (MIT)
 * @since          Version 1.0
 */

/**
 * Navigation helper plugin.
 *
 * @package        Micro
 * @author         Attila Kerekes
 */
class Micro_Plugin_Navigation {

    //TODO: refactor, phpdoc
    /**
     * @var
     */
    private $_view;
    /**
     * @var
     */
    private $_config;

    /**
     * @param $view
     * @param $config
     */
    public function __construct($view, $config) {
        $this->_view = $view;
        $this->_config = $config;
    }

    /**
     * @param $site
     *
     * @return string
     */public function makeUrl($site) {
        if(isset($this->_config['url'])) {
            return $this->_config['url'] . '/' . $site;
        }
        return '/' . $site;
}

    /**
     * @param $site
     * @return string
     */public function makeClass($site) {
        if($site === $this->_view) {
            return 'active';
        }
        return '';
    }
}