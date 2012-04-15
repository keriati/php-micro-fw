<?php

class index_Controller extends Micro_Controller
{
    function indexAction()
    {
        $this->data = "Hello World!";
    }
}