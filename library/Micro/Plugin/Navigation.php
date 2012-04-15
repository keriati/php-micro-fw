<?php
/**
 * App Viewhelpers
 * @author: Attila Kerekes
 */
class Micro_Plugin_Navigation {

    private $_view,
            $_config;

    public function __construct($view, $config) {
        $this->_view = $view;
        $this->_config = $config;
    }

    public function makeUrl($site) {
        if(isset($this->_config['url'])) {
            return $this->_config['url'] . '/' . $site;
        }
        return '/' . $site;
    }

    public function makeClass($site) {
        if($site === $this->_view) {
            return 'active';
        }
        return '';
    }
}