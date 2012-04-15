<?php
/**
 * App Mail Plugin
 * @author: Attila Kerekes
 */
class Micro_Plugin_Contact
{
    private $_to;
    private $_subject;

    private $_name;
    private $_email;
    private $_message;

    function setTo($to)
    {
        $this->_to = trim(strip_tags($to));
        return $this;
    }

    function setSubject($subject)
    {
        $this->_email = trim(strip_tags($subject));
        return $this;
    }

    function setName($name)
    {
        $this->_name = trim(strip_tags($name));
        return $this;
    }

    function setEmail($email)
    {
        $this->_email = trim(strip_tags($email));
        return $this;
    }

    function setMessage($message)
    {
        $this->_message = $message;
        return $this;
    }

    function sendMail()
    {
        $headers = "From: $this->_name <$this->_email>\r\n";
        $headers .= "Content-type: text/plain\r\n";

        $myMessage = "Name: " . $this->_name . "\r\n" .
                     "E-mail: " .$this->_email . "\r\n" .
                     "Message: \r\n\r\n" . $this->_message;

        return mail($this->_to, $this->_subject, $myMessage, $headers);
    }

    function validateEmail()
    {
        return filter_var($this->_email, FILTER_VALIDATE_EMAIL);
    }

}