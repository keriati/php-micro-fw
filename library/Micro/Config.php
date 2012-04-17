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
 * Class to read the configuration from ini files.
 *
 * @package        Micro
 * @author         Attila Kerekes
 */
class Micro_Config
{
    /**
     * @var array All the options in one variable.
     */
    public $config = array();

    /**
     * Parse the ini file with the options/settings!
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

        $this->config = $config;
    }

    /**
     * Extend the configuration with another array!
     *
     * @param array $config  Associative Array with settings;
     * @return array
     */
    public function extendConfig(array $config)
    {
        $this->config = array_merge_recursive($this->config, $config);
        return $this->config;
    }

    /**
     * Get all the settings in one array!
     *
     * @return array
     */
    public function getConfig()
    {
        return $this->config;
    }
}