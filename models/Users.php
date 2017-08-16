<?php

namespace Models;

use Core\Database;

/**
 * Class Users
 * @package Models
 */
class Users extends Database
{
    /**
     * @var
     */
    protected $_table = 'users';

    /**
     * @var string
     */
    protected $_model = 'Users';
}