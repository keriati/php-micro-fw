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
 * Abstract class for controllers
 *
 * @package        Micro
 * @author         Attila Kerekes
 */
abstract class Micro_Controller
{
    /**
     * @var string Name of the layout (file).
     */
    public $layout = "layout";

    /**
     * @var string Name of the view (file).
     */
    public $view;

    /**
     * @var array Options array.
     */
    public $options;

    /**
     * @var string Name of the controller.
     */
    public $controller;

    /**
     * @var string Name of the array.
     */
    public $action;

    /**
     * Constructor
     *
     * Sets options, layout, view.
     *
     * @param $options array Options array
     * @return \Micro_Controller
     */
    function __construct($options)
    {
        $this->options    = $options;
        $this->controller = $options['controller'];
        $this->action     = $options['action'];
        $this->setLayout();
        $this->setView();
    }

    /**
     * The default (index) action of the controller.
     */
    abstract function indexAction();

    /**
     * Render the active view (file). Used in the layout template file.
     *
     * @return string Content of the view.
     */
    public function renderView()
    {
        $file = APPLICATION_PATH . '/views/' . $this->options['controller'] . '/' . $this->view . '.phtml';

        ob_start();
        include $file;
        return ob_get_clean();
    }

    /**
     * Render the layout view (file).
     *
     * @return string The layout
     */
    public function renderLayout()
    {
        $file = APPLICATION_PATH . '/layouts/' . $this->layout . '.phtml';

        ob_start();
        include $file;
        return ob_get_clean();
    }

    /**
     * Render partial file in the view.
     *
     * @param $partial string Name of the partial (file).
     * @return string Content of the partial.
     */
    public function renderPartial($partial)
    {
        $file = APPLICATION_PATH . '/views/partials/' . $partial . '.phtml';

        if (is_file($file)) {
            ob_start();
            include $file;
            return ob_get_clean();
        }
        return "Partial not found: " . $partial;
    }

    /**
     * Render partial file in the layout.
     *
     * @param $partial string Name of the partial (file).
     * @return string Content of the partial.
     */
    public function renderLayoutPartial($partial)
    {
        $file = APPLICATION_PATH . '/layouts/partials/' . $partial . '.phtml';

        if (is_file($file)) {
            ob_start();
            include $file;
            return ob_get_clean();
        }
        return "Partial not found: " . $partial;
    }

    /**
     * Get view data from the config (title, description etc).
     *
     * @param $name string Name of the data.
     * @return string Content of the option.
     */
    public function getData($name)
    {
        if (isset($this->options[$this->controller][$this->action][$name])) {
            return $this->options[$this->controller][$this->action][$name];
        }
        elseif (isset($this->options['defaults'][$name])) {
            return $this->options['defaults'][$name];
        }
        return "Error: " . $name . " not set!";
    }

    /**
     * Set the view.
     *
     * @param string $view
     */
    public function setView($view = "")
    {
        if ($view == "") {
            $view = $this->options['action'];
        }
        // Check for file
        $file = APPLICATION_PATH . '/views/' . $this->options['controller'] . '/' . $view . '.phtml';

        if (is_file($file)) {
            $this->view = $view;
        }
        else {
            die('View not found :(');
        }
    }

    /**
     * Set the layout.
     *
     * @param string $layout
     */
    public function setLayout($layout = "")
    {
        // Check config for layout
        if ($layout == "") {
            $layout = (isset($this->options['defaults']['layout']))
                ? $this->options['defaults']['layout']
                // Nothing in the config, default Layout
                : 'layout';
        }

        // Check for file
        $file = APPLICATION_PATH . '/layouts/' . $layout . '.phtml';

        if (is_file($file)) {
            $this->layout = $layout;
        }
        else {
            die('Layout not found :(');
        }
    }

    /**
     * Start rendering the site with the layout.
     *
     * @return string Content of the site.
     */
    public function render()
    {
        // Launch the layout
        $siteContent = $this->renderLayout();

        // Print site.
        return $siteContent;
    }
}