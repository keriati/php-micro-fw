<?php

abstract class Micro_Controller
{

    protected $_layout = "layout",
        $_view,
        $_options,
        $_controller,
        $_action;

    function __construct($options)
    {
        $this->_options    = $options;
        $this->_controller = $options['controller'];
        $this->_action     = $options['action'];
        $this->_setLayout();
        $this->_setView();
    }

    abstract function indexAction();

    protected function _renderView()
    {
        $file = APPLICATION_PATH . '/views/' . $this->_options['controller'] . '/' . $this->_view . '.phtml';

        ob_start();
        include $file;
        return ob_get_clean();
    }

    protected function _renderLayout()
    {
        $file = APPLICATION_PATH . '/layouts/' . $this->_layout . '.phtml';

        ob_start();
        include $file;
        return ob_get_clean();
    }

    protected function _renderPartial($partial)
    {
        $file = APPLICATION_PATH . '/views/partials/' . $partial . '.phtml';

        if (is_file($file)) {
            ob_start();
            include $file;
            return ob_get_clean();
        }
        return "Partial not found: " . $partial;
    }

    protected function _renderLayoutPartial($partial)
    {
        $file = APPLICATION_PATH . '/layouts/partials/' . $partial . '.phtml';

        if (is_file($file)) {
            ob_start();
            include $file;
            return ob_get_clean();
        }
        return "Partial not found: " . $partial;
    }

    // Get View Data set in the config file
    protected function _getData($name)
    {
        if (isset($this->_options[$this->_controller][$this->_action][$name])) {
            return $this->_options[$this->_controller][$this->_action][$name];
        }
        elseif (isset($this->_options['defaults'][$name])) {
            return $this->_options['defaults'][$name];
        }
        return "Error: " . $name . " not set!";
    }

    protected function _setView($view = "")
    {
        if ($view == "") {
            $view = $this->_options['action'];
        }
        // Check for file
        $file = APPLICATION_PATH . '/views/' . $this->_options['controller'] . '/' . $view . '.phtml';

        if (is_file($file)) {
            $this->_view = $view;
        }
        else {
            die('View not found :(');
        }
    }

    protected function _setLayout($layout = "")
    {
        // Check config for layout
        if ($layout == "") {
            $layout = (isset($this->_options['defaults']['layout']))
                ? $this->_options['defaults']['layout']
                // Nothing in the config, default Layout
                : 'layout';
        }

        // Check for file
        $file = APPLICATION_PATH . '/layouts/' . $layout . '.phtml';

        if (is_file($file)) {
            $this->_layout = $layout;
        }
        else {
            die('Layout not found :(');
        }
    }

    // Render the site
    public function render()
    {
        // Launch the layout
        $siteContent = $this->_renderLayout();

        // Print site.
        return $siteContent;
    }
}