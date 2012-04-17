<?php
/**
 * PHP Micro Framework
 *
 * Tiny MVC framework for learning purposes.
 *
 * LICENSE: This source file is subject to the MIT license as follows:
 * The MIT License (MIT)
 * Copyright (c) 2012 Attila Kerekes
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 *
 * @package        Micro
 * @author         Attila Kerekes
 * @copyright      Copyright (c) 2012, Attila Kerekes. (http://www.attilakerekes.com)
 * @license        http://www.opensource.org/licenses/MIT The MIT License (MIT)
 * @since          Version 1.0
 */

/**
 * Micro Application Class
 *
 * @package        Micro
 * @author         Attila Kerekes
 */
class Micro_Application
{

    /**
     * Controller name
     *
     * @var string
     */
    private $_controller;

    /**
     * Action name
     *
     * @var string
     */
    private $_action;

    /**
     * Options array
     *
     * @var array
     */
    private $_options;

    /**
     * Constructor
     *
     * Initialize application.
     * Load config file.
     * Load plugins and models.
     * Set controller and action based on request.
     *
     * @return \Micro_Application
     */
    public function __construct()
    {
        // Get configuration
        $mc             = new Micro_Config();
        $this->_options = $mc->getConfig();

        // Autoload plugins and models
        foreach (array('plugin', 'model') as $type) {
            if (isset($this->_options['autoload'][$type])) {
                $classes = explode(',', $this->_options['autoload'][$type]);
                foreach ($classes as $class) {
                    $file = MICRO_PATH . '/' . ucfirst(trim($type)) . '/' . ucfirst(trim($class)) . '.php';
                    if (is_file($file)) {
                        include_once($file);
                    }
                }
            }
        }

        // Set controller & action
        $action     = isset($this->_options['defaults']['action'])
            ? $this->_options['defaults']['action']
            : 'index';
        $controller = isset($this->_options['defaults']['action'])
            ? $this->_options['defaults']['action']
            : 'index';

        // Check Request
        if (isset($_SERVER['REQUEST_URI'])) {
            $ruri  = explode('?', $_SERVER['REQUEST_URI']);
            $query = explode('/', $ruri[0]);

            if (isset($query[2]) && $query[2] != "") {
                $action = $query[2];
            }
            if (isset($query[1]) && $query[1] != "") {
                $controller = $query[1];
            }
        }

        $this->_action     = $action;
        $this->_controller = $controller;

        $this->_checkErrors();
        $this->run();
    }

    /**
     * Run the application
     */
    public function run()
    {
        $controller = $this->_controller;
        $action     = $this->_action;

        // Controller Class name, Action name
        $cc = $controller . '_Controller';
        $an = $action . 'Action';

        // Extend options with controller and action
        $this->_options['controller'] = $controller;
        $this->_options['action']     = $action;

        $microController = new $cc($this->_options);
        $microController->$an();

        $siteContent = $microController->render();
        echo $siteContent;
    }

    /**
     * Error checker
     *
     * Test the controller and the action. Set 404 if missing.
     */
    private function _checkErrors()
    {
        $controller = $this->_controller;
        $action     = $this->_action;

        // Controller Class name, Action name
        $cc = $controller . '_Controller';
        $an = $action . 'Action';

        // Autoload Controller
        $file = APPLICATION_PATH . '/controllers/' . $controller . '.php';
        if (is_file($file)) {
            include_once($file);
            $methods = get_class_methods($cc);
            if (!in_array($an, $methods)) {
                $this->_setError('notfound');
            }
        }
        else {
            $this->_setError('notfound');
        }
    }

    /**
     * Error checker
     *
     * Test the controller and the action. Set 404 if missing.
     *
     * @param $type string Type of the error (i.e. notfound)
     */
    private function _setError($type)
    {
        // Controller not found -> 404;
        $file = APPLICATION_PATH . '/controllers/error.php';
        include_once($file);
        $this->_controller = 'error';
        $this->_action     = $type;
    }
}