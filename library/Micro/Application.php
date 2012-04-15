<?php
/**
 * PHP Micro Framework - Application Class
 *
 * @author: Attila Kerekes
 */
class Micro_Application
{
    private $_controller,
        $_action,
        $_options;

    public function __construct()
    {
        // Get Configuration
        $mc             = new Micro_Config();
        $this->_options = $mc->getConfig();

        // Autoload Plugins, Helpers, Models
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

        // Set Controller & Action
        $action     = isset($this->_options['defaults']['action'])
            ? $this->_options['defaults']['action']
            : 'index';
        $controller = isset($this->_options['defaults']['action'])
            ? $this->_options['defaults']['action']
            : 'index';

        // Check Request
        if (isset($_SERVER['REQUEST_URI'])) {
            $ruri = explode('?', $_SERVER['REQUEST_URI']);
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

        $this->checkErrors();
        $this->start();
    }

    private function start()
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

    private function checkErrors()
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
                $this->setError('notfound');
            }
        }
        else {
            $this->setError('notfound');
        }
    }

    private function setError($type)
    {
        // Controller not found -> 404;
        $file = APPLICATION_PATH . '/controllers/error.php';
        include_once($file);
        $this->_controller = 'error';
        $this->_action     = $type;
    }
}