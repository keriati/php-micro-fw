<?php

// Debug
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Set PATHs
define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../application'));
define('MICRO_PATH', realpath(dirname(__FILE__) . '/../library/Micro'));

// Base classes
require_once(MICRO_PATH . '/Application.php');
require_once(MICRO_PATH . '/Controller.php');
require_once(MICRO_PATH . '/Config.php');

// Launch Application
$myApplication = new Micro_Application();