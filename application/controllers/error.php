<?php

class error_Controller extends Micro_Controller
{
    function indexAction()
    {
        // TODO: Implement indexAction() method.
    }

    function notfoundAction()
    {
        header("HTTP/1.0 404 Not Found");
        $this->setLayout('error');
    }
}