<?php
/**
 * App Configuration Class
 * @author: Attila Kerekes
 */
class Micro_Config
{
    /**
     * @var array
     */
    private $_config = array();

    /**
     * Parse the ini file with the settings!
     */
    public function __construct()
    {
        $data = parse_ini_file(APPLICATION_PATH . '/configs/application.ini', true);

        $config = array();

        foreach($data['Application'] as $key => $value) {
            $explo = array_reverse(explode(".", $key));
            $ret = array();
            $ret[array_shift($explo)] = $value;
            foreach($explo as $e) {
                $ret = array($e => $ret);
            }
            $config = array_merge_recursive($config, $ret);
        }

        $this->_config = $config;
    }

    /**
     * Extend the configuration with another array!
     *
     * @param array $config  Associative Array with settings;
     * @return array
     */
    public function extendConfig(array $config)
    {
        $this->_config = array_merge_recursive($this->_config, $config);
        return $this->_config;
    }

    /**
     * Get all the settings in one array!
     * @return array
     */
    public function getConfig()
    {
        return $this->_config;
    }
}