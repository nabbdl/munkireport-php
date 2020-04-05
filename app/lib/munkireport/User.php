<?php

namespace munkireport\lib;

/**
* User class
*
* Store and retrieve information about the logged in user
*
*/
class User
{
    private $conf, $session;

    public function __construct($conf = [])
    {
        $this->conf = $conf;
        $this->session = $_SESSION;
    }

    public function canArchive()
    {
        return $this->_getRole() == 'admin';
    }

    private function _getRole()
    {
        return $_SESSION['role'] ?? '';
    }
}