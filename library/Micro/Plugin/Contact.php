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
 * Plugin class for contact forms.
 *
 * @package        Micro
 * @author         Attila Kerekes
 */
class Micro_Plugin_Contact
{

    // TODO: refactor, phpdoc
    /**
     * @var
     */
    private $_to;
    /**
     * @var
     */
    private $_subject;

    /**
     * @var
     */
    private $_name;
    /**
     * @var
     */
    private $_email;
    /**
     * @var
     */
    private $_message;

    /**
     * @param $to
     *
     * @return Micro_Plugin_Contact
     */function setTo($to)
    {
        $this->_to = trim(strip_tags($to));
        return $this;
    }

    /**
     * @param $subject
     * @return Micro_Plugin_Contact
     */function setSubject($subject)
    {
        $this->_email = trim(strip_tags($subject));
        return $this;
    }

    /**
     * @param $name
     * @return Micro_Plugin_Contact
     */function setName($name)
    {
        $this->_name = trim(strip_tags($name));
        return $this;
    }

    /**
     * @param $email
     * @return Micro_Plugin_Contact
     */function setEmail($email)
    {
        $this->_email = trim(strip_tags($email));
        return $this;
    }

    /**
     * @param $message
     * @return Micro_Plugin_Contact
     */function setMessage($message)
    {
        $this->_message = $message;
        return $this;
    }

    /**
     * @return bool
     */function sendMail()
    {
        $headers = "From: $this->_name <$this->_email>\r\n";
        $headers .= "Content-type: text/plain\r\n";

        $myMessage = "Name: " . $this->_name . "\r\n" .
                     "E-mail: " .$this->_email . "\r\n" .
                     "Message: \r\n\r\n" . $this->_message;

        return mail($this->_to, $this->_subject, $myMessage, $headers);
    }

    /**
     * @return mixed
     */function validateEmail()
    {
        return filter_var($this->_email, FILTER_VALIDATE_EMAIL);
    }

}